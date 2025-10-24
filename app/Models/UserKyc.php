<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Services\Cachable\ModelCaching\Traits\Cachable;

class UserKyc extends Model
{
    use HasFactory, Uuid, SoftDeletes, cachable;
    protected $fillable = ['user_id', 'doc_id', 'value'];

    public function doc()
    {
        return $this->belongsTo(KycDoc::class,'doc_id')->withTrashed();
    }
}