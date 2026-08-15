<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\{Settings, CountryReg, AirtimeProvider};
use Illuminate\Support\Facades\Http;
use App\Services\Reloadly\ReloadlyAirtimeService;
use Illuminate\Support\Facades\DB;

class UpdateAirtimeOperators extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:airtime:operators';
    protected $settings;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Airtime Operators';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->settings = Settings::find(1);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    protected function massUpdate(string $table, string $keyColumn, array $rows): void
    {
        if (empty($rows)) {
            return;
        }

        $columns = array_keys($rows[0]);
        $columns = array_values(array_diff($columns, [$keyColumn]));

        $bindings = [];
        $cases = [];
        foreach ($columns as $col) {
            $sql = "`{$col}` = CASE `{$keyColumn}`";
            foreach ($rows as $row) {
                $sql .= " WHEN ? THEN ?";
                $bindings[] = $row[$keyColumn];
                $bindings[] = $row[$col];
            }
            $sql .= " END";
            $cases[] = $sql;
        }

        $keys = array_column($rows, $keyColumn);
        $placeholders = implode(',', array_fill(0, count($keys), '?'));
        $bindings = array_merge($bindings, $keys);

        $sql = "UPDATE `{$table}` SET " . implode(', ', $cases)
            . ", `updated_at` = ? WHERE `{$keyColumn}` IN ({$placeholders})";

        array_splice($bindings, count($bindings) - count($keys), 0, [Carbon::now()]);

        DB::update($sql, $bindings);
    }

    public function handle()
    {
        foreach (CountryReg::whereStatus(1)->withCount(['airtimeProviders'])->get() as $country) {
            if ($country->airtime_providers_count) {
                //Check Reloadly
                $reloadly = new ReloadlyAirtimeService();
                $products = $reloadly->productsByCountry($country->iso2);
                if ($products['success'] == true) {
                    $reloadly_data = collect($products['data'])->where('bundle', false)->where('data', false)->where('senderCurrencyCode', 'USD')->where('destinationCurrencyCode', $country->currency)->map(function ($data) use($country) {

                        return [
                            'id' => $data['id'],
                            'title' => $data['name'],
                            'description' => $data['name'],
                            'discount' => $data['internationalDiscount'],
                            'only_denominations' => $data['denominationType'] == 'RANGE' ? false : true,
                            'min' => (($country->currency == 'INR') ? min($data['geographicalRechargePlans'][0]['localAmounts']) : $data['localMinAmount']) ?? $data['minAmount'] ?? null,
                            'max' => (($country->currency == 'INR') ? max($data['geographicalRechargePlans'][0]['localAmounts']) : $data['localMaxAmount']) ?? $data['maxAmount'] ?? null,
                            'denominations' =>  $data['denominationType'] == 'RANGE' ? [] : (($country->currency == 'INR') ? $data['geographicalRechargePlans'][0]['localAmounts'] : $data['fixedAmounts']),
                            'issuing_pc' => $data['fees']['internationalPercentage'],
                            'issuing_fc' => $data['fees']['international'],
                            'charge_phase' => 'after_conversion',
                            'tier_pricing' => 0,
                            'issuing_tiers' => [],
                            'rate' => 1 / $data['fx']['rate'],
                            'status' => $data['status'] == 'ACTIVE' ? 1 : 0
                        ];
                    })->sortBy('title')->values();

                    $vendorIds = $reloadly_data->pluck('id')->all();
                    $existingVendorIds = AirtimeProvider::whereIn('reloadly_id', $vendorIds)
                        ->pluck('reloadly_id')
                        ->all();

                    if (empty($existingVendorIds)) {
                        continue;
                    }

                    $updates = $reloadly_data
                        ->whereIn('id', $existingVendorIds)
                        ->map(fn($data) => [
                            'reloadly_id' => $data['id'],
                            'title' => $data['title'],
                            'description' => $data['description'],
                            'discount' => $data['discount'],
                            'only_denominations' => $data['only_denominations'],
                            'min' => $data['only_denominations'] ? min($data['denominations']) : $data['min'],
                            'max' => $data['only_denominations'] ? max($data['denominations']) : $data['max'],
                            'issuing_pc' => $data['issuing_pc'] ?? 0,
                            'issuing_fc' => $data['issuing_fc'] ?? 0,
                            'rate' => $data['rate'],
                            'status' => $data['status'],
                            'charge_phase' => $data['charge_phase'],
                            'tier_pricing' => $data['tier_pricing'],
                            'issuing_tiers' => json_encode($data['issuing_tiers']),
                            'denominations' => json_encode($data['only_denominations'] ? array_map(fn($v) => ['amount' => $v], $data['denominations']) : []),
                        ])
                        ->values()
                        ->all();

                    $this->massUpdate('airtime_providers', 'reloadly_id', $updates);
                }
            }
        }

        $this->info('Updated Airtime Operators!!!');
    }
}
