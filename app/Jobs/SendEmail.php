<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Settings;
use Illuminate\Support\Facades\Mail;
use App\Models\Admin;
use App\Models\SentEmail;
use Illuminate\Support\Facades\Storage;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $subject;
    public $message;
    public $to;
    public $name;
    public $attach;
    public $settings;
    public $contact;
    public $record;
    public $cc = [];

    public function __construct($to, $name, $subject, $message, $attach = null, $contact = null, $record = 0, $cc = [])
    {
        $this->subject = $subject;
        $this->message = $message;
        $this->to = $to;
        $this->name = $name;
        $this->attach = $attach;
        $this->contact = $contact;
        $this->cc = $cc;
        $this->record = $record;
        $this->settings = Settings::first();
    }

    /**
     * Execute the job.
     *
     * @return void
     */

    function sendEmail($to, $name, $subject, $body, $reason = null, $attach = null, $contact = null, $record = 0, $cc = [])
    {
        $set = Settings::first();
        $admin = Admin::whereRole('super')->first();
        $from = config('mail.from.address');
        $contact = ($contact) ? $contact : ((auth()->guard('user')->check()) ? auth()->guard('user')->user()->contact : null);

        if ($reason == null) {
            $text = str_replace("{{logo}}", '<img src="' . asset("asset/images/logo.png") . '" style="' . getUi()->email_light_css . '">', (str_replace("{{site_name}}", $set->site_name, str_replace("{{message}}", $body, $set->email_template))));
            if ($contact) {
                $text = str_replace("{{unsubscribe}}", route('unsubscribe', ['contact' => $contact->id]), $text);
            }
        } else {
            $text = str_replace("{{reason}}", $reason, str_replace("{{logo}}", '<img src=' . asset("asset/images/logo.png") . ' style=' . getUi()->email_light_css . '>', (str_replace("{{site_name}}", $set->site_name, str_replace("{{message}}", $body, $set->email_template)))));
        }

        Mail::send([], [], function ($message) use ($subject, $from, $set, $to, $text, $name, $attach, $record, $admin, $contact, $cc) {
            if ($attach == null) {
                $message->to($to, $name)->subject($subject)->from($from, $set->site_name)->html($text)->cc($cc);
            } else {
                $message->to($to, $name)->subject($subject)->from($from, $set->site_name)->html($text)->attach($attach)->cc($cc);
            }

            if ($record == 1 && $contact) {
                $htmlContent = $text;
                SentEmail::create([
                    'subject' => $subject,
                    'message' => $htmlContent,
                    'html' => 1,
                    'contact_id' => $contact->id,
                    'admin_id' => $admin->id,
                ]);
            }
        });
        if ($attach != null) {
            Storage::delete($attach);
        }
    }
    public function handle()
    {
        $this->sendEmail($this->to, $this->name, $this->subject, $this->message, null, $this->attach, $this->contact, $this->record, $this->cc);
    }
}
