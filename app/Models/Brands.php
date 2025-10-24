<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class Brands extends Model {
    use Uuid;
    protected $table = "brands";
    protected $fillable = ['title', 'status', 'image'];
}
