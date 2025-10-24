<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuid;

class LeaderShip extends Model
{
    use Uuid, HasFactory, SoftDeletes;
    protected $fillable = ['name', 'image', 'position', 'status', 'linkedin', 'twitter'];
}
