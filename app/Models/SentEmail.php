<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Services\Cachable\ModelCaching\Traits\Cachable;

class SentEmail extends Model
{
    use HasFactory, Uuid, SoftDeletes, Cachable;

    protected $fillable = ['subject', 'message', 'html', 'admin_id', 'contact_id'];

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id')->withTrashed();
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
