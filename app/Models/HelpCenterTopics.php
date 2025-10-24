<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Services\Cachable\ModelCaching\Traits\Cachable;

class HelpCenterTopics extends Model
{
    use HasFactory, Uuid, SoftDeletes, Cachable;

    protected $table = "help_center_topics";
    protected $fillable = ['name', 'description', 'icon', 'slug'];

    public function articles()
    {
        return $this->hasMany(HelpCenter::class, 'cat_id');
    }
}
