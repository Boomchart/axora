<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Services\Cachable\ModelCaching\Traits\Cachable;


class ArticleLikes extends Model
{
    use HasFactory, Uuid, SoftDeletes, Cachable;
    protected $table = "article_likes";
    protected $fillable = ['ip', 'user_agent', 'type', 'post_id'];
}
