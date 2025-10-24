<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;
use App\Models\Settings;

class ContactExport implements FromQuery, WithMapping, WithHeadings
{
    protected $contacts;

    public function __construct($contacts)
    {
        $this->contacts = $contacts;
    }
    /**
     * @return \Illuminate\Support\Collection
     */

    public function map($contacts): array
    {
        $set = Settings::find(1);
        return [
            $contacts->first_name.' '.$contacts->last_name,
            $contacts->email,
            $contacts->mobile,
            $contacts->created_at
        ];
    }

    public function headings(): array
    {
        return ['Name', 'Email', 'Phone', 'Date'];
    }

    public function query()
    {
        return $this->contacts;
    }
}
