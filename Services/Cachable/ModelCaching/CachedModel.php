<?php namespace Services\Cachable\ModelCaching;

use Services\Cachable\ModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

abstract class CachedModel extends Model
{
    use Cachable;
}
