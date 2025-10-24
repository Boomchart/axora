<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Services\Cachable\ModelCaching\Traits\Cachable;

class ApiLogs extends Model
{
    use HasFactory, Cachable, Uuid;

    protected $guarded = [];
    protected $fillable = [
        'business_id',
        'url',
        'status_code',
        'mode',
        'method',
        'ip_address',
        'message'
    ];

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id', 'reference');
    }
}
