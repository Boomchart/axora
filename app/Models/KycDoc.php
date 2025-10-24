<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Services\Cachable\ModelCaching\Traits\Cachable;

class KycDoc extends Model
{
    use HasFactory, Uuid, SoftDeletes, cachable;

    protected $fillable = [
        'title',
        'type',
        'min',
        'max',
        'status',
        'reg_id',
        'doc',
        'slug',
        'placeholder',
        'select_options'
    ];
}
