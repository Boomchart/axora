<?php namespace Services\Cachable\ModelCaching;

use Services\Cachable\ModelCaching\Traits\Buildable;
use Services\Cachable\ModelCaching\Traits\BuilderCaching;
use Services\Cachable\ModelCaching\Traits\Caching;
use Illuminate\Database\Eloquent\Builder;

class CachedBuilder extends Builder
{
    use Buildable;
    use BuilderCaching;
    use Caching;
}
