<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Services\Cachable\ModelCaching\Traits\Cachable;

class Contact extends Model {
    use Uuid, SoftDeletes, Cachable;
    protected $table = "contact";
    protected $fillable = ['first_name', 'last_name', 'mobile', 'email', 'user_id', 'contact_id', 'subscribed'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }    
    
    public function contact()
    {
        return $this->belongsTo(Messages::class, 'contact_id')->withTrashed();
    }
}
