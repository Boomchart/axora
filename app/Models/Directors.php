<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class Directors extends Model
{
    use HasFactory, Uuid, SoftDeletes;

    protected $table = "directors";

    protected $fillable = [
        'user_id',
        'business_id',
        'position',
        'email',
        'first_name',
        'last_name',
        'phone',
        'ownership',
        'birthday',
        'country',
        'state',
        'city',
        'postal_code',
        'street',
        'doc_type',
        'doc_number',
        'doc_front',
        'doc_back',
        'gender',
        'passport'
    ];

    protected function fullname(): Attribute
    {
        return new Attribute(
            get: fn () => $this->first_name .' ' . $this->last_name
        );
    }

    public function business(){
        return $this->belongsTo(Business::class, 'business_id', 'reference')->withTrashed();
    }
}
