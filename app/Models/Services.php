<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class Services extends Model {
    use Uuid;
    protected $table = "services";
    protected $fillable = ['title', 'details', 'image'];
}
