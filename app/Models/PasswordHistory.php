<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class PasswordHistory extends Model
{
    use HasFactory, Uuid, SoftDeletes;

    protected $table = 'password_histories';

    protected $fillable = [
        'email',
        'password'
    ];
}
