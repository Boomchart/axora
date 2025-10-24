<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Services\Cachable\ModelCaching\Traits\Cachable;

class Messages extends Model {
    use Uuid, SoftDeletes, Cachable;
    protected $table = "messages";
    protected $fillable = ['first_name', 'last_name', 'mobile', 'email', 'subject', 'message', 'seen', 'admin_id', 'contact_id'];

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id')->withTrashed();
    }    
    
    public function user()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
