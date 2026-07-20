<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\CryptoBalance;
use App\Models\Business;
use Illuminate\Support\Str;

class AddCryptoWallet implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $businesses = Business::with('user')->get();
        $currencies = getAllCryptoCurrencies(); // Already eager loads countryReg
        $balances = CryptoBalance::all()->groupBy(function ($item) {
            return $item->business_id . '-' . $item->country_id;
        });

        foreach ($businesses as $business) {
            foreach ($currencies as $currency) {
                $key = $business->reference . '-' . $currency->id;
                $existing = $balances->get($key)?->first();

                if (!$existing) {
                    // No balance record exists
                    if ($business->user) {
                        CryptoBalance::create([
                            'user_id'      => $business->user_id,
                            'country_id'   => $currency->id,
                            'business_id'  => $business->reference,
                            'network'    => $currency->network,
                            'token' => $currency->token,
                            'ref_id'       => Str::uuid(),
                            'mode' => 'live'
                        ]);
                    }
                } elseif ($existing->ref_id === null) {
                    $existing->update(['ref_id' => Str::uuid()]);
                }
            }
        }
    }
}
