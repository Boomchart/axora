<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Curl\Curl;
use App\Models\Category;
use App\Models\Settings;

class ExchangeRate implements ShouldQueue
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
        //Fetch Exchange Rates for united states
        $set = Settings::find(1);
        if ($set->currency_layer == 1) {
            $curl = new Curl();
            $curl->setHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]);
            $url = ($set->cl_api_mode == 'free') ? 'http://apilayer.net/api/live' : 'https://api.currencylayer.com/live';
            $curl->get($url . "?access_key=" . $set->cl_api_key . "&format=1");
            $curl->close();

            $quote = json_decode(json_encode($curl->response->quotes), true);

            $usd = [];
            foreach ($quote as $key => $res) {
                $usd[str_replace('USD', '', $key)] = $res;
            }
            $usd['USD'] = 1;

            //Updates rates
            $to = Settings::first()->real->currency;
            foreach (Category::whereType('giftcard_buy_rate')->whereAutoRate(1)->get() as $val) {
                $from = $val?->rateCountry?->country?->currency;
                if ($from != null) {
                    if ($val->auto_rate == 1) {
                        if ($to == "USD" && $from != "USD") {
                            $rate = 1 / $usd[$from];
                            $real = $val->amount * $rate;
                            $val->update([
                                'rate' => $real + ($real * $val->margin / 100)
                            ]);
                        } elseif ($to != "USD" && $from == "USD") {
                            $rate = $usd[$to];
                            $real = $val->amount * $rate;
                            $val->update([
                                'rate' => $real + ($real * $val->margin / 100)
                            ]);
                        } elseif ($to == $from) {
                            $rate = 1;
                            $real = $val->amount * $rate;
                            $val->update([
                                'rate' => $real + ($real * $val->margin / 100)
                            ]);
                        } else {
                            $usdRateFromCurrency = $usd[$val->currency];
                            $usdRateToCurrency = $usd[$to];
                            $rate = $usdRateToCurrency / $usdRateFromCurrency;
                            $real = $val->amount * $rate;
                            if ($usdRateToCurrency != null && $usdRateFromCurrency != null) {
                                $val->update([
                                    'rate' => $real + ($real * $val->margin / 100)
                                ]);
                            }
                        }
                    }
                }
            }
        }
    }
}
