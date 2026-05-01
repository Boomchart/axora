<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\{Settings, CountryReg, DataProvider};
use Illuminate\Support\Facades\Http;
use App\Services\Reloadly\ReloadlyAirtimeService;
use Illuminate\Support\Facades\DB;

class UpdateDataOperators extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:data:operators';
    protected $settings;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Data Operators';

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
        foreach (CountryReg::whereStatus(1)->withCount(['dataProviders'])->get() as $country) {
            if ($country->data_providers_count) {
                //Check Reloadly
                $reloadly = new ReloadlyAirtimeService();
                $products = $reloadly->productsByCountry($country->iso2);
                if ($products['success'] == true) {

                    $reloadly_data = collect($products['data'])->where('bundle', false)->where('data', true)->where('senderCurrencyCode', 'USD')->where('destinationCurrencyCode', $country->currency)->map(function ($data) {
                        return [
                            'id' => $data['id'],
                            'title' => $data['name'],
                            'discount' => $data['internationalDiscount'],
                            'only_denominations' => $data['denominationType'] == 'RANGE' ? false : true,
                            'min' =>  min($data['localFixedAmounts']),
                            'max' =>  max($data['localFixedAmounts']),
                            'denominations' =>  $data['denominationType'] == 'RANGE' ? [] : $data['fixedAmounts'],
                            'issuing_pc' => $data['fees']['internationalPercentage'],
                            'issuing_fc' => $data['fees']['international'],
                            'charge_phase' => 'after_conversion',
                            'tier_pricing' => 0,
                            'issuing_tiers' => [],
                            'rate' => 1 / $data['fx']['rate'],
                            'status' => $data['status'] == 'ACTIVE' ? 1 : 0,
                            'description' => $data['localFixedAmountsDescriptions']
                        ];
                    })->sortBy('title')->values();

                    $vendorIds = $reloadly_data->pluck('id')->all();
                    $existingVendorIds = DataProvider::whereIn('reloadly_id', $vendorIds)
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
                            'discount' => $data['discount'],
                            'only_denominations' => $data['only_denominations'],
                            'min' => round($data['min']),
                            'max' => round($data['max']),
                            'issuing_pc' => $data['issuing_pc'] ?? 0,
                            'issuing_fc' => $data['issuing_fc'] ?? 0,
                            'rate' => $data['rate'],
                            'status' => $data['status'],
                            'charge_phase' => $data['charge_phase'],
                            'tier_pricing' => $data['tier_pricing'],
                            'issuing_tiers' => json_encode($data['issuing_tiers']),
                            'denominations' => json_encode(array_map(
                                fn($amount, $plan) => ['amount' => (float) round($amount), 'plan' => $plan],
                                array_keys($data['description']),
                                array_values($data['description'])
                            )),
                            'description' =>  $data['title'],
                        ])
                        ->values()
                        ->all();

                    $this->massUpdate('data_providers', 'reloadly_id', $updates);
                }
            }
        }

        $this->info('Updated Data Operators!!!');
    }
}
