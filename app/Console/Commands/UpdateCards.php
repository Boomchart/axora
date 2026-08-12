<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\{Settings, CountryReg, BuyCard};
use Illuminate\Support\Facades\Http;
use App\Services\Reloadly\ReloadlyGiftcardService;
use App\Services\Redboxx\RedboxxGiftcardService;
use Illuminate\Support\Facades\DB;

class UpdateCards extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:cards';
    protected $settings;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Cards';

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

    public function formatRedeemInstructions($instructions)
    {
        $instructions = preg_replace('/<\s*(p|div|li|h[1-6]|tr)[^>]*>/i', "\n", $instructions);
        $instructions = preg_replace('/<\s*\/?\s*(br|\/?p|\/?div|\/?li|\/?h[1-6]|\/?tr)\s*\/?\s*>/i', "\n", $instructions);
        $instructions = html_entity_decode(strip_tags($instructions), ENT_QUOTES | ENT_HTML5);
        $instructions = preg_replace('/[ \t]+/', ' ', $instructions);
        $instructions = preg_replace('/\n{3,}/', "\n\n", $instructions);
        $instructions = trim($instructions);
        return $instructions;
    }

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
        foreach (CountryReg::whereStatus(1)->withCount(['giftcards'])->get() as $country) {
            if ($country->giftcards_count) {
                //Check Reloadly
                $reloadly = new ReloadlyGiftcardService();
                $products = $reloadly->productsByCountry($country->iso2);
                if ($products['success'] == true) {
                    $reloadly_data = collect($products['data'])->where('senderCurrencyCode', 'USD')->where('recipientCurrencyCode', $country->currency)->map(function ($data) {
                        $instructions = $this->formatRedeemInstructions($data['redeemInstruction']['verbose'] ?? '');
                        return [
                            'id' => $data['productId'],
                            'title' => $data['productName'],
                            'description' => $data['productName'],
                            'discount' => $data['discountPercentage'],
                            'only_denominations' => $data['denominationType'] == 'RANGE' ? false : true,
                            'redemption_instructions' => $instructions,
                            'min' =>  $data['minRecipientDenomination'],
                            'max' =>  $data['maxRecipientDenomination'],
                            'denominations' =>  $data['denominationType'] == 'RANGE' ? [] : $data['fixedRecipientDenominations'],
                            'issuing_pc' => $data['senderFeePercentage'],
                            'issuing_fc' => $data['senderFee'],
                            'charge_phase' => 'after_conversion',
                            'tier_pricing' => 0,
                            'issuing_tiers' => [],
                            'rate' => $data['recipientCurrencyToSenderCurrencyExchangeRate'],
                            'status' => $data['status'] == 'ACTIVE' ? 1 : 0
                        ];
                    })->sortBy('title')->values();

                    $vendorIds = $reloadly_data->pluck('id')->all();
                    $existingVendorIds = BuyCard::whereIn('reloadly_id', $vendorIds)
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
                            'terms' => $data['terms'] ?? null,
                            'discount' => $data['discount'],
                            'redemption_instructions' => $data['redemption_instructions'],
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
                            'denominations' => json_encode($data['only_denominations'] ? $data['denominations'] : []),
                        ])
                        ->values()
                        ->all();

                    $this->massUpdate('buy_cards', 'reloadly_id', $updates);
                }

                //Check Redboxx
                $redboxx = new RedboxxGiftcardService();
                $products = $redboxx->productsByCountry($country->iso2);
                if ($products['success'] == true) {
                    $redboxx_data = collect($products['data'])->where('currency', $country->currency)->map(function ($data) {
                        $instructions = $this->formatRedeemInstructions($data['redemption_instructions'] ?? '');
                        return [
                            'id' => $data['id'],
                            'title' => $data['name'],
                            'description' => $data['description'],
                            'discount' => 0,
                            'only_denominations' => $data['denomination_type'] == 'RANGE' ? false : true,
                            'redemption_instructions' => $instructions,
                            'min' =>  $data['min'],
                            'max' =>  $data['max'],
                            'denominations' =>  $data['denomination_type'] == 'RANGE' ? [] : $data['denominations'],
                            'issuing_pc' => ($data['issuing_fee']['type'] == 'single') ? $data['issuing_fee']['fee']['percent'] : 0,
                            'issuing_fc' => ($data['issuing_fee']['type'] == 'single') ? $data['issuing_fee']['fee']['flat'] : 0,
                            'charge_phase' => $data['issuing_fee']['charge_phase'],
                            'tier_pricing' => ($data['issuing_fee']['type'] == 'single') ? 0 : 1,
                            'issuing_tiers' => ($data['issuing_fee']['type'] == 'single') ? [] : $data['issuing_fee']['fee'],
                            'rate' => $data['exchange_rate'],
                        ];
                    })->sortBy('title')->values();

                    $vendorIds = $redboxx_data->pluck('id')->all();
                    $existingVendorIds = BuyCard::whereIn('redboxx_id', $vendorIds)
                        ->pluck('redboxx_id')
                        ->all();

                    if (empty($existingVendorIds)) {
                        continue;
                    }

                    $updates = $redboxx_data
                        ->whereIn('id', $existingVendorIds)
                        ->map(fn($data) => [
                            'redboxx_id' => $data['id'],
                            'title' => $data['title'],
                            'description' => $data['description'],
                            'terms' => $data['terms'] ?? null,
                            'discount' => $data['discount'],
                            'redemption_instructions' => $data['redemption_instructions'],
                            'only_denominations' => $data['only_denominations'],
                            'min' => $data['only_denominations'] ? min($data['denominations']) : $data['min'],
                            'max' => $data['only_denominations'] ? max($data['denominations']) : $data['max'],
                            'issuing_pc' => $data['issuing_pc'] ?? 0,
                            'issuing_fc' => $data['issuing_fc'] ?? 0,
                            'rate' => $data['rate'],
                            'charge_phase' => $data['charge_phase'],
                            'tier_pricing' => $data['tier_pricing'],
                            'issuing_tiers' => json_encode($data['issuing_tiers']),
                            'denominations' => json_encode($data['only_denominations'] ? array_map(fn($v) => ['amount' => $v], $data['denominations']) : []),
                        ])
                        ->values()
                        ->all();

                    $this->massUpdate('buy_cards', 'redboxx_id', $updates);
                }
            }
        }

        $this->info('Updated Cards!!!');
    }
}
