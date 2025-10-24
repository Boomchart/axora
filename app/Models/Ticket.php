<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuid;
use Services\Cachable\ModelCaching\Traits\Cachable;

class Ticket extends Model
{
    use SoftDeletes, Uuid, Cachable;
    protected $table = "support";
    protected $guarded = [];
    protected $fillable = ['user_id', 'business_id', 'subject', 'message', 'ticket_id', 'files', 'ref_no', 'priority', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    public function reply()
    {
        return $this->hasMany(Reply::class, 'ticket_id')->orderBy('created_at', 'asc');
    }    
    
    public function unread()
    {
        return $this->hasMany(Reply::class, 'ticket_id')->whereSeen(0)->orderBy('created_at', 'desc');
    }
    
    public function business(){
        return $this->belongsTo(Business::class, 'business_id', 'reference');
    } 
}
