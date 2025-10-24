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
use App\Models\User;
use App\Models\Transactions;
use App\Models\Emailtemplate;
use App\Models\Ticket;
use App\Models\Reply;
use App\Models\RFI;
use App\Mail\Transaction;
use App\Jobs\SendEmail;

class CustomEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $type;
    public $customer;
    public $reason;
    public $otp;

    public function __construct($type, $customer = null, $reason = null, $otp = null)
    {
        $this->type = $type;
        $this->customer = $customer;
        $this->reason = $reason;
        $this->otp = $otp;
    }

    /**
     * Execute the job.
     *
     * @return void
     */

    function customEmail($type, $id = null, $other = null, $otp = null)
    {
        $set = Settings::first();
        $currency = Settings::first()->real;
        $check = Emailtemplate::whereType($type)->whereSms(0)->first();
        if ($id != null) {
            if (in_array($check->type, ['deposit_request_decline', 'card_transaction', 'withdraw_request_decline', 'new_withdraw_request_admin', 'deposit_request_approve', 'withdraw_request_approve', 'transfer_credit', 'transfer_debit'])) {
                $val = Transactions::whereId($id)->first();
                $user = User::whereId($val->user_id)->first();
                $find = array("{{amount}}", "{{charge}}", "{{first_name}}", "{{last_name}}", "{{site_name}}", "{{reference}}", "{{reason}}");
                $replace = array($val->amount . $currency->currency, $val->charge . $currency->currency, $user->first_name, $user->last_name, $set->site_name, $val->ref_id, $val->decline_reason);
            } elseif (in_array($check->type, ['card_purchase_success', 'card_purchase_failed'])) {
                $val = Transactions::whereId($id)->withTrashed()->first();
                $user = User::whereId($val->user_id)->withTrashed()->first();
                $find = array("{{reason}}", "{{first_name}}", "{{last_name}}", "{{site_name}}", "{{card}}");
                $replace = array($other, $user->first_name, $user->last_name, $set->site_name, $val?->buyCardRate?->rateCountry?->buyGiftcard?->title . ' ' . $val?->buyCardRate?->rateCountry?->country?->currency_symbol . currencyFormat(number_format($val->buyCardRate?->amount, 2)));
            } elseif (in_array($check->type, ['card_sale_success', 'card_sale_failed'])) {
                $val = Transactions::whereId($id)->first();
                $user = User::whereId($val->user_id)->withTrashed()->first();
                $find = array("{{reason}}", "{{first_name}}", "{{last_name}}", "{{site_name}}", "{{card}}");
                $replace = array($other, $user->first_name, $user->last_name, $set->site_name, $val?->sellCategory?->name);
            } else if (in_array($check->type, ['ticket_close', 'ticket_new'])) {
                $ticket = Ticket::whereId($id)->first();
                $user = $ticket->user;
                $find = array("{{first_name}}", "{{last_name}}", "{{site_name}}", "{{token}}");
                $replace = array($ticket->user->first_name, $ticket->user->last_name, $set->site_name, $ticket->ticket_id);
            } else if (in_array($check->type, ['ticket_reply'])) {
                $reply = Reply::whereId($id)->first();
                $user = $reply->user;
                $find = array("{{first_name}}", "{{last_name}}", "{{site_name}}", "{{token}}", "{{staff}}", "{{reply}}");
                $replace = array($reply->user->first_name, $reply->user->last_name, $set->site_name, $reply->ticket->ticket_id, $reply?->staff?->first_name . ' ' . $reply?->staff?->last_name, $reply->message);
            } else if (in_array($check->type, ['rfi_add'])) {
                $rfi = RFI::whereId($id)->first();
                $user = $rfi->user;
                $find = array("{{first_name}}", "{{last_name}}", "{{site_name}}", "{{reference}}", "{{reason}}");
                $replace = array($rfi->user->first_name, $rfi->user->last_name, $set->site_name, $rfi?->transaction?->ref_id, trim($rfi->message));
            } else if (in_array($check->type, ['compliance_resubmit'])) {
                $user = User::whereId($id)->withTrashed()->first();
                $find = array("{{first_name}}", "{{last_name}}", "{{site_name}}", "{{reason}}");
                $replace = array($user->first_name, $user->last_name, $set->site_name, $other);
            } else if (in_array($check->type, ['compliance_approval'])) {
                $user = User::whereId($id)->withTrashed()->first();
                $find = array("{{first_name}}", "{{last_name}}", "{{site_name}}");
                $replace = array($user->first_name, $user->last_name, $set->site_name);
            } else if (in_array($check->type, ['otp', 'deactivation_email'])) {
                $user = User::whereId($id)->withTrashed()->first();
                $find = array("{{first_name}}", "{{last_name}}", "{{site_name}}", "{{token}}");
                $replace = array($user->first_name, $user->last_name, $set->site_name, $otp);
            } else if (in_array($check->type, ['verify_email', 'welcome_message'])) {
                $user = User::whereId($id)->withTrashed()->first();
                $find = array("{{first_name}}", "{{last_name}}", "{{site_name}}", "{{token}}");
                $replace = array($user->first_name, $user->last_name, $set->site_name, route('user.confirm-email', ['verify' => $user->email_auth]));
            }
        }
        $mail = [
            'email' => $user->email,
            'name' => $user->business->name,
            'subject' => str_replace($find, $replace, $check->subject),
            'message' => str_replace($find, $replace, $check->body)
        ];
        if (in_array($check->type, ['deactivation_email', 'verify_email', 'otp', 'ticket_close', 'ticket_new', 'ticket_reply', 'compliance_approval', 'compliance_resubmit', 'welcome_message'])) {
            dispatch(new SendEmail($mail['email'], $mail['name'], $mail['subject'], $mail['message'], null, null, 0));
        } else {
            if ($val->user_id) {
                $send = ($val->user->transaction_notification) ? true : false;
            } else {
                $send = true;
            }
            if ($send) {
                Mail::to($mail['email'], $mail['name'])->queue(new Transaction($mail['subject'], $mail['message'], Transactions::whereId($id)->first()));
            }
        }
    }

    public function handle()
    {
        $this->customEmail($this->type, $this->customer, $this->reason, $this->otp);
    }
}
