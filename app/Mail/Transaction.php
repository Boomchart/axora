<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Settings;

class Transaction extends Mailable
{
    use Queueable, SerializesModels;

    public $sbj;
    public $msg;
    public $transaction;
    public $set;
    public $currency;
    public function __construct($sbj, $msg, $transaction)
    {
        $this->subject = $sbj;
        $this->msg = $msg;
        $this->transaction = $transaction;
        $this->set = Settings::first();
        $this->currency = Settings::first()->real;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {;
        $data = [
            'subject' => $this->subject,
            'message' => $this->msg,
        ];
        return $this->markdown('emails.transaction')
            ->subject($data['subject'])
            ->with([
                'content' => $data['message'],
                'website' => $this->set->site_name,
                'url' => route('home'),
                'transaction' => $this->transaction,
                'currency' => $this->currency,
                'logo' => asset('asset/images/logo.png'),
            ]);
    }
}
