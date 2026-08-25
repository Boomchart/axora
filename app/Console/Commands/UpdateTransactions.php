<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Settings;
use Illuminate\Support\Str;
use App\Services\Reloadly\{ReloadlyGiftcardService, ReloadlyAirtimeService};
use App\Services\Redboxx\RedboxxGiftcardService;
use App\Jobs\Webhook\{Giftcard, Airtime, Data};

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

    public function sendWebhook($val)
    {
        if ($val->business_id) {
            if ($val->business->webhook_url) {
                if ($val->type == 'giftcard_purchase') {
                    dispatch(new Giftcard($val));
                } elseif ($val->type == 'airtime_purchase') {
                    dispatch(new Airtime($val));
                } elseif ($val->type == 'data_purchase') {
                    dispatch(new Data($val));
                }
            }
        }
    }

    public function failedOrder($orderResponse)
    {
        $responseStatus = $orderResponse['status'];
        $responseBody = json_encode($orderResponse['error'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        $emailBody = __('Hello admin, you have a new failed order')
            . '<br><br><strong>' . __('Response Status') . ':</strong> ' . e($responseStatus)
            . '<br><strong>' . __('Response Body') . ':</strong><br>'
            . '<pre>' . e($responseBody) . '</pre>';
        foreach (\App\Models\Admin::whereGiftcard(1)->get() as $admin) {
            dispatch(new \App\Jobs\SendEmail($admin->email, $this->settings->site_name, __('New failed order'), $emailBody, null, null, 0));
        }
    }

    public function handle()
    {
        //Reloadly
        foreach (\App\Models\Orders::whereStatus('pending')->whereProvider('reloadly')->whereType('giftcard')->whereMode('live')->whereFailedOrder(0)->take(5)->whereNotNull('order_id')->get() as $val) {
            $reloadly = new ReloadlyGiftcardService();
            $getCard = $reloadly->redeemCodes($val->order_id);
            if ($getCard['success'] == true) {
                $val->update([
                    'status' => 'success',
                    'card_code' => encryptRSA($getCard['data'][0]['cardNumber']) ?? null,
                    'pin_code' => encryptRSA($getCard['data'][0]['pinCode']) ?? null,
                    'card_url' => encryptRSA($getCard['data'][0]['redemptionUrl']) ?? null,
                ]);
                $this->sendWebhook($val);
            }
        }
        foreach (\App\Models\Orders::whereStatus('pending')->whereProvider('reloadly')->whereType('giftcard')->whereMode('live')->whereFailedOrder(0)->take(5)->whereNull('order_id')->get() as $val) {
            $reloadly = new ReloadlyGiftcardService();
            $order = $reloadly->order([
                'customIdentifier' => $val->id,
                'productAdditionalRequirements' => [
                    'userId' => $val->email
                ],
                'productId' => $val->vendor_id,
                'quantity' => 1,
                'senderName' => $val->name,
                'unitPrice' => $val->amount,
            ]);


            if ($order['success'] == true) {
                $order = $order['data'];
                $val->update([
                    'order_id' => $order['transactionId'],
                ]);
                $getCard = $reloadly->redeemCodes($order['transactionId']);

                if ($getCard['success'] == true) {
                    $val->update([
                        'status' => 'success',
                        'card_code' => encryptRSA($getCard['data'][0]['cardNumber']) ?? null,
                        'pin_code' => encryptRSA($getCard['data'][0]['pinCode']) ?? null,
                        'card_url' => encryptRSA($getCard['data'][0]['redemptionUrl']) ?? null,
                    ]);
                    $this->sendWebhook($val);
                }
            } else {
                $val->update([
                    'failed_order' => 1
                ]);
                $this->failedOrder($order);
            }
        }

        //Reloadly Airtime/Data
        foreach (\App\Models\Orders::whereStatus('pending')->whereProvider('reloadly')->whereIn('type', ['airtime', 'data'])->whereMode('live')->whereFailedOrder(0)->take(5)->whereNull('order_id')->get() as $val) {
            $reloadly = new ReloadlyAirtimeService();
            $order = $reloadly->order([
                'customIdentifier' => $val->id,
                'operatorId' => $val->vendor_id,
                'recipientPhone' => [
                    'countryCode' => $val->phone_code,
                    'number' => $val->phone
                ],
                'amount' => (float) $val->amount * $val->rate,
            ]);


            if ($order['success'] == true) {
                $order = $order['data'];
                $val->update([
                    'status' => 'success',
                    'order_id' => $order['transactionId'],
                ]);
                $this->sendWebhook($val);
            } else {
                $val->update([
                    'failed_order' => 1
                ]);
                $this->failedOrder($order);
            }
        }

        // //Redboxx
        foreach (\App\Models\Orders::whereStatus('pending')->whereProvider('redboxx')->whereMode('live')->whereFailedOrder(0)->take(5)->whereNull('order_id')->get() as $val) {
            $redboxx = new RedboxxGiftcardService();
            $order = $redboxx->order([
                'card_id' => $val->vendor_id,
                'name' => $val->name,
                'quantity' => 1,
                'email' => $val->email,
                'phone' => $val->phone,
                'phone_code' => $val->phone_code,
                'amount' => $val->amount,
            ]);

            if ($order['success'] == true) {
                $order = $order['data']['order'][0];
                $val->update([
                    'order_id' => $order['id'],
                ]);
            } else {
                $val->update([
                    'failed_order' => 1
                ]);
                $this->failedOrder($order);
            }
        }

        // //Test orders
        foreach (\App\Models\Orders::whereStatus('pending')->whereMode('test')->whereFailedOrder(0)->take(100)->whereNull('order_id')->get() as $val) {
            $val->update([
                'order_id' => Str::uuid(),
                'status' => 'success',
                'card_code' => ($val->type == 'giftcard') ? encryptRSA(generateRandomCode()) : null,
                'card_url' => ($val->type == 'giftcard') ? encryptRSA(url('/')) : null,
            ]);
            $this->sendWebhook($val);
        }
        $this->info('Processed Orders!!!');
    }
}
