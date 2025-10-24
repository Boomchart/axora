<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class Review extends Model {
    use Uuid;
    
    protected $table = "review";
    protected $fillable = ['name', 'occupation', 'review', 'status', 'image'];
}
