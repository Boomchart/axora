<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue as ShouldQueueContract;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithMapping;

class AuditExport implements FromQuery, WithHeadings, WithMapping, WithChunkReading, ShouldQueueContract
{
    use Exportable, Queueable, Dispatchable, InteractsWithQueue, SerializesModels;

    public $timeout = 3600;
    public $tries = 3;

    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function query()
    {
        $query = DB::table('audit_logs as t');

        $basicConditions = [
            'business_id' => 't.business_id',
        ];

        foreach ($basicConditions as $key => $column) {
            if (isset($this->data[$key]) && $this->data[$key] !== null) {
                $query->where($column, $this->data[$key]);
            }
        }

        return $query->select([
            't.trx',
            't.log',
            't.created_at',
        ])->orderBy('t.created_at');
    }

    public function map($audit): array
    {
        return [
            $audit->trx,
            $audit->log,
            $audit->created_at,
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function headings(): array
    {
        return ['Reference', 'Log', 'Date'];
    }
}
