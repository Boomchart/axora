<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuid;

class MonitorUsers extends Model
{
    use HasFactory, Uuid, SoftDeletes;

    protected $table = "monitor_users";

    protected $fillable = [
        'ip_address',
        'email',
        'first_name',
        'last_name',
        'phone',
        'country_id',
        'whitelist',
        'user_agent',
    ];

    public function getCountry()
    {
        return $this->belongsTo(CountryReg::class, 'country_id')->with(['real'])->withTrashed();
    }
}
