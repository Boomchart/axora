<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\MonitorUsers;
use App\Models\User;

class BlackList implements ShouldQueue
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
        $Ips = [];
        foreach (MonitorUsers::whereWhitelist(0)->select('ip_address')->get() as $dd) {
            $Ips[] = $dd->ip_address;
        }
        cache()->forget('blockedIps');
        cache()->put('blockedIps', $Ips);

        $bannedEmails = [];
        foreach (User::whereBan(1)->select('email')->withTrashed()->get() as $dd) {
            if (MonitorUsers::whereEmail($dd->email)->whereWhitelist(0)->exists() == true) {
                $bannedEmails[] = str_replace('@deleted', '', $dd->email);
            }
        }
        cache()->forget('bannedEmails');
        cache()->put('bannedEmails', $bannedEmails);

        $bannedPhones = [];
        foreach (User::whereBan(1)->select('phone')->withTrashed()->get() as $dd) {
            if (MonitorUsers::whereEmail($dd->phone)->whereWhitelist(0)->exists() == true) {
                $bannedPhones[] = str_replace('@deleted', '', $dd->phone);
            }
        }
        cache()->forget('bannedPhones');
        cache()->put('bannedPhones', $bannedPhones);
    }
}
