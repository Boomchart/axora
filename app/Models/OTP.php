<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuid;

class OTP extends Model
{
    use Uuid, HasFactory, SoftDeletes;

    protected $table = 'o_t_p_s';

    protected $fillable = [
        'business_id',
        'code',
        'status',
        'expiry_time',
    ];

    protected $dates = [
        'expiry_time'
    ];

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id')->withTrashed();
    }
}
