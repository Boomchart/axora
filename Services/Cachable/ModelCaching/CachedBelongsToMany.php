<?php namespace Services\Cachable\ModelCaching;

use Services\Cachable\PivotEvents\Traits\FiresPivotEventsTrait;
use Services\Cachable\ModelCaching\Traits\Buildable;
use Services\Cachable\ModelCaching\Traits\BuilderCaching;
use Services\Cachable\ModelCaching\Traits\Caching;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CachedBelongsToMany extends BelongsToMany
{
    use Buildable;
    use BuilderCaching;
    use Caching;
    use FiresPivotEventsTrait;
}
