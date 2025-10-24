<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue as ShouldQueueContract;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransactionExport implements FromQuery, WithHeadings, WithMapping, WithChunkReading, WithColumnFormatting, ShouldQueueContract
{
    use Exportable, Queueable, Dispatchable, InteractsWithQueue, SerializesModels;

    public $timeout = 3600;
    public $tries = 3;

    protected $data;
    protected $user;

    public function __construct(array $data, $user)
    {
        $this->data = $data;
        $this->user = $user;
    }

    public function query()
    {
        $query = DB::table('transactions as t')
            ->join('businesses as b', 't.business_id', '=', 'b.reference');

        $conditions = [
            'mode' => 't.mode',
            'business_id' => 't.business_id'
        ];

        foreach ($conditions as $key => $column) {
            if (isset($this->data[$key]) && $this->data[$key] !== null) {
                $query->where($column, $this->data[$key]);
            }
        }

        $query = $this->applyComplexFilters($query);

        return $query->select([
            't.ref_id',
            't.trx_type',
            't.type',
            't.amount',
            't.charge',
            't.status',
            't.created_at',
        ])->orderBy('t.created_at');
    }

    protected function applyComplexFilters($query)
    {
        // Status filter
        if (array_key_exists('status', $this->data)) {
            $query->when(!empty($this->data['status']), function ($q) {
                return $q->where('t.status', $this->data['status']);
            });
        }

        // Date range filter
        if (array_key_exists('date', $this->data)) {
            $query->when(!empty($this->data['date']), function ($q) {
                $dates = explode('-', $this->data['date']);
                $timezone = $this->data['user_timezone'] ?? 'UTC';

                $from = Carbon::create($dates[0])->setTimezone($timezone);
                $to = Carbon::create($dates[1])->setTimezone($timezone)->addDay(1);

                if ($from->ne($to->subDay())) {
                    return $q->whereBetween('t.created_at', [$from, $to]);
                }
                return $q->whereDate('t.created_at', $from);
            });
        }

        // Type filter (with OR condition)
        if (array_key_exists('type', $this->data)) {
            $query->when(!empty($this->data['type']), function ($q) {
                return $q->where('t.type', $this->data['type']);
            });
        }

        // Transaction type filter
        if (array_key_exists('trx_type', $this->data)) {
            $query->when(!empty($this->data['trx_type']), function ($q) {
                return $q->where('t.trx_type', $this->data['trx_type']);
            });
        }

        if (array_key_exists('mode', $this->data)) {
            $query->when(!empty($this->data['mode']), function ($q) {
                return $q->where('t.mode', $this->data['mode']);
            });
        }

        return $query;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function headings(): array
    {
        return ['Reference', 'Type', 'Description', 'Amount', 'Fees', 'Status', 'Date'];
    }

    public function map($transaction): array
    {
        $baseResult = [
            $transaction->ref_id,
            ucwords($transaction->trx_type),
            ucwords($transaction->type),
            sprintf('%.2f', $transaction->amount),
            sprintf('%.2f', $transaction->charge),
            ucwords($transaction->status),
            $transaction->created_at,
        ];

        return $baseResult;
    }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_NUMBER_00,
            'E' => NumberFormat::FORMAT_NUMBER_00,
        ];
    }
}
