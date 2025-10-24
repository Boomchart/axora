<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Services\Cachable\ModelCaching\Traits\Cachable;

class Reply extends Model {
    use Uuid, SoftDeletes, Cachable;
    protected $table = "reply_support";
    protected $guarded = [];
    protected $fillable = ['user_id', 'business_id', 'ticket_id', 'reply', 'status', 'staff_id', 'seen', 'files'];

    public function ticket()
    {
        return $this->belongsTo(ticket::class, 'ticket_id');
    }  

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }
    
    public function staff()
    {
        return $this->belongsTo(Admin::class, 'staff_id')->withTrashed();
    }
}
