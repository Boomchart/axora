<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Services\Cachable\ModelCaching\Traits\Cachable;

class Devices extends Model
{
    use HasFactory, Uuid, SoftDeletes, Cachable;

    protected $fillable = [
        'user_id',
        'business_id',
        'userAgent',
        'deviceType',
        'browserName',
        'platformName',
        'deviceFamily',
        'ip_address',
        'browserFamily',
        'browserVersion',
        'platformFamily',
        'platformVersion',
        'deviceModel',
        'mobileGrade',
        'type',
        'mac_address',
        'last_login',
    ];
}
