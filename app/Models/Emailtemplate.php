<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emailtemplate extends Model {
    protected $table = "email_template";
    protected $fillable = ['subject', 'body'];
}
