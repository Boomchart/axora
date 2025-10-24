<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class Page extends Model {
    use Uuid;
    protected $table = "pages";
    protected $fillable = ['title', 'slug', 'details', 'status'];
}
