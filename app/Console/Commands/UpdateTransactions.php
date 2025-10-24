<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Settings;
use Illuminate\Support\Facades\Http;

class UpdateTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:transactions';
    protected $settings;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Transaction';

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

    public function getDuration($duration)
    {
        if ($duration == 'monday') {
            return Carbon::MONDAY;
        } else if ($duration == 'tuesday') {
            return Carbon::TUESDAY;
        } else if ($duration == 'wednesday') {
            return Carbon::WEDNESDAY;
        } else if ($duration == 'thursday') {
            return Carbon::THURSDAY;
        } else if ($duration == 'friday') {
            return Carbon::FRIDAY;
        } else if ($duration == 'saturday') {
            return Carbon::SATURDAY;
        } else if ($duration == 'sunday') {
            return Carbon::SUNDAY;
        }
    }

    public function handle()
    {
        if ($this->settings->redboxx_low_notify == 0) {
            foreach (\App\Models\CardIssued::whereStatus('pending')->whereMode('live')->take(5)->whereNull('order_id')->with('transaction')->get() as $val) {
                $orderResponse = Http::withHeaders([
                    'Authorization' => 'Bearer ' . config('settings.redboxx_api_key'),
                ])->post(config('settings.redboxx_url') . '/v1/order', [
                    'card_id' => $val->card_id,
                    'name' => $val->name,
                    'quantity' => 1,
                    'email' => $val->email,
                    'phone' => $val->phone,
                    'phone_code' => $val->transaction->phone_code,
                    'amount' => $val->amount,
                ]);

                if ($orderResponse->status() == 200) {
                    $this->settings->update([
                        'redboxx_low_notify' => 0
                    ]);
                    $data = $orderResponse->json()['data'];
                    foreach ($data['order'] as $order) {
                        $val->update([
                            'order_id' => $order['id'],
                            'data' => json_encode($order),
                            'expires' => $order['expires'],
                        ]);
                    }
                }
            }
        }
        $this->info('Failed Order Retried updated!!!');
    }
}
