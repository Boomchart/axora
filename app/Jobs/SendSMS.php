<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Country;
use App\Models\CountryReg;
use App\Models\Settings;
use Twilio\Rest\Client;
use Propaganistas\LaravelPhone\PhoneNumber;
use Curl\Curl;
use App\Models\Emailtemplate;

class SendSMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $phone;
    public $message;
    public $settings;
    public $recipient;

    public function __construct($phone, $message, $recipient)
    {
        $this->phone = $phone;
        $this->message = $message;
        $this->recipient = $recipient;
        $this->settings = Settings::find(1);
    }

    /**
     * Execute the job.
     *
     * @return void
     */

    public function handle()
    {
        $iso2 = PhoneNumber::make($this->phone)->getCountry();
        $vendor = CountryReg::whereCountryId(Country::whereIso2($iso2)->first()->id);
        $check = Emailtemplate::whereType($this->message)->whereSms(1)->first();
        $find = ["{{site_name}}", "{{token}}"];
        $replace = [$this->settings->site_name, $this->recipient->mobile_code];
        $data = str_replace($find, $replace, $check->body);
        if($vendor->exists()){
                if($vendor->first()->sms_provider == 'twilio'){
                    try {
                        $client = new Client($this->settings->twilio_account_sid, $this->settings->twilio_auth_token);
                        $client->messages->create(
                            $this->phone,
                            [
                                'from' => $this->settings->twilio_number, // From a valid Twilio number
                                'body' => $data
                            ]
                        );
                    } catch (\Twilio\Exceptions\ConfigurationException $e) {
                        return back()->with('alert', $e->getMessage());
                    }
                }else{
                    $curl = new Curl();
                    $curl->setHeaders([
                        'content-type' => 'application/json',
                        'accept' => 'application/json',
                    ]);
                    $curl->post('https://api.ng.termii.com/api/sms/send', [
                        'to' => $this->phone,
                        'from' => 'N-Alert',
                        'sms' => $data,
                        'type' => 'plain',
                        'channel' => 'dnd',
                        'api_key' => $this->settings->termii_api_key
                    ]);
                    $curl->close();
                }
        }else{
            return back()->with('alert', $iso2.__(' is not currently supported'));
        }
    }
}
