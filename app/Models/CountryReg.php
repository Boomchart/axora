<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class CountryReg extends Model
{
    use HasFactory, Uuid;
    protected $table = 'country_regs';
    protected $fillable = [
        'country_id',
        'iso2',
        'status',
        'sms_provider',
        'status',
        'name',
    ];

    public function real()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
