<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\MonitorUsers;
use App\Models\Settings;
use App\Jobs\SendEmail;

class Firewall implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $ip_address;
    public $client;
    public function __construct($ip_address, $client)
    {
        $this->ip_address = $ip_address;
        $this->client = $client;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $set = Settings::find(1);
        foreach (MonitorUsers::all() as $val) {
            $route = route('user.manage', ['client'=> $this->client->business_id, 'type' => 'details']); 
            if ($val->ip_address == $this->ip_address) {
                $message = __("User Ip is associated with a blocked email domain, details needed to block user is below, ensure to add user email domain to blocked email domains");
                $message .= "<br/>";
                $message .= __("Here are the details").": ";
                $message .= "<br/>";
                $message .= __("Name").": ".$this->client->business->name;
                $message .= "<br/>";
                $message .= __("IP").": ".$this->client->ip_address;
                $message .= "<br/>";
                $message .= __("Email").": ".$this->client->email;
                $message .= "<br/>";
                $message .= __("Email Domain").": ".explode('@', $this->client->email)[1];
                $message .= "<br/>";
                $message .= __("ID").": ".$this->client->id;
                $message .= "<br/>";
                $message .= __("Link").": <a href=' . $route . '>' . $route . '</a>";

                dispatch(new SendEmail($set->site_email, $set->site_name, __('Firewall Monitoring System'), $message, null, null, 0));
            }
        }
    }
}
