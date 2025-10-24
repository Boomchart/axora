<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Services\Cachable\ModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Audit extends Model
{
    use Uuid, Cachable, SoftDeletes;
    protected $table = "audit_logs";
    protected $guarded = [];
    protected $fillable = [
        'user_id',
        'business_id',
        'trx',
        'log',
        'admin_id',
    ];
    
    public function staff()
    {
        return $this->belongsTo(Admin::class, 'admin_id')->withTrashed();
    }

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id', 'reference');
    }
}
