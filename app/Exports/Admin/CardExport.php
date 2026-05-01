<?php

namespace App\Exports\Admin;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue as ShouldQueueContract;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CardExport implements FromQuery, WithHeadings, WithMapping, WithColumnFormatting, ShouldQueueContract
{
    use Exportable, Queueable, Dispatchable, InteractsWithQueue, SerializesModels;

    public $timeout = 3600;
    public $tries = 3;
    public $categoryMap = [];

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function query()
    {
        $query = DB::table('buy_cards as card')
            ->whereNull('card.deleted_at');

        $query = $this->applyComplexFilters($query);

        $finalQuery = $query->select([
            'card.id',
            'card.title',
            'card.currency',
            'card.iso2',
            'card.logo',
            'card.min',
            'card.max',
            'card.provider',
            'card.denominations',
            'card.main_categories',
        ])->orderBy('card.title', 'desc');

        $this->categoryMap = DB::table('categories as category')->where('category.type', 'giftcard_buy')->get()->mapWithKeys(function ($x) {
            return [$x->id => $x->name];
        });

        return $finalQuery;
    }

    protected function applyComplexFilters($query)
    {
        if (array_key_exists('country', $this->data)) {
            $query->when(!empty($this->data['country']), function ($q) {
                return $q->where('card.iso2', $this->data['country']);
            });
        }


        return $query;
    }

    public function map($card): array
    {
        return [
            $card->id,
            $card->title,
            $card->provider,
            $card->iso2,
            $card->currency,
            $card->logo,
            $card->min,
            $card->max,
            implode(', ', json_decode($card->denominations, true)),
            implode(', ', collect(json_decode($card->main_categories, true))->map(function ($item) {
                return $this->categoryMap[$item] ?? '';
            })->toArray())
        ];
    }

    public function headings(): array
    {
        return ['Reference', 'Card', 'Vendor', 'Country', 'Currency', 'Logo', 'Min', 'Max', 'Denominations', 'Categories'];
    }

    public function columnFormats(): array
    {
        return [];
    }
}
