<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Services\Cachable\ModelCaching\Traits\Cachable;

class Blog extends Model
{
    use Uuid, SoftDeletes, Cachable;

    protected $table = "trending";
    protected $fillable = ['title', 'details', 'image', 'cat_id', 'views', 'status', 'slug', 'created_at', 'edited_by'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'cat_id')->whereType('blog')->withTrashed();
    }

    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by')->withTrashed();
    }

    public function editedBy()
    {
        return $this->belongsTo(Admin::class, 'edited_by')->withTrashed();
    }
}
