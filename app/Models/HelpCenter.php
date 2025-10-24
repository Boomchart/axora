<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Services\Cachable\ModelCaching\Traits\Cachable;

class HelpCenter extends Model
{
    use HasFactory, Uuid, SoftDeletes, Cachable;

    protected $table = "help_center";
    protected $fillable = ['question', 'answer', 'cat_id', 'slug'];

    public function category()
    {
        return $this->belongsTo(category::class, 'cat_id')->whereType('faq')->withTrashed();
    }

    public function relatedArticles($limit)
    {
        return HelpCenter::where('id', '!=', $this->id)->take($limit)->whereCatId($this->cat_id)->get();
    }

    public function reactions()
    {
        return ArticleLikes::wherePostId($this->id)->count();
    }

    public function likes()
    {
        return ArticleLikes::wherePostId($this->id)->whereType(1)->count();
    }

    public function reacted()
    {
        if (ArticleLikes::wherePostId($this->id)->whereIp(request()->ip())->whereuserAgent(request()->userAgent())->count() > 0) {
            return true;
        }
        return false;
    }

    public function isLiked()
    {
        if (ArticleLikes::whereId($this->id)->whereType(1)->whereIp(request()->ip())->whereuserAgent(request()->userAgent())->count() > 0) {
            return true;
        }
        return false;
    }   
    public function disLiked()
    {
        if (ArticleLikes::whereId($this->id)->whereType(0)->whereIp(request()->ip())->whereuserAgent(request()->userAgent())->count() > 0) {
            return true;
        }
        return false;
    }

    public function removeLike()
    {
        if (ArticleLikes::whereId($this->id)->whereIp(request()->ip())->whereuserAgent(request()->userAgent())->count() > 0) {
            return ArticleLikes::whereId($this->id)->whereIp(request()->ip())->whereuserAgent(request()->userAgent())->update(['type' => 0]);
        }
        return false;
    }    
    
    public function addLike()
    {
        if (ArticleLikes::whereId($this->id)->whereIp(request()->ip())->whereuserAgent(request()->userAgent())->count() > 0) {
            return ArticleLikes::whereId($this->id)->whereIp(request()->ip())->whereuserAgent(request()->userAgent())->update(['type' => 1]);
        }
        return false;
    }
}
