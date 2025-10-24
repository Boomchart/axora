<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Webhook extends Model
{
    protected $table = "webhook_logs";
    protected $guarded = [];
    protected $dates = ['resend_time'];
    protected $fillable = [
        'uuid',
        'url',
        'payload',
        'response',
        'headers',
        'response_status_code',
        'attempts',
        'business_id',
        'reference',
        'mode',
        'status',
        'resend_time'
    ];

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id', 'reference')->withTrashed();
    }
}
