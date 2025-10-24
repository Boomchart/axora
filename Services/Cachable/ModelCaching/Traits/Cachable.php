<?php namespace Services\Cachable\ModelCaching\Traits;

use Services\Cachable\PivotEvents\Traits\PivotEventTrait;

trait Cachable
{
    use Caching;
    use ModelCaching;
    use PivotEventTrait {
        ModelCaching::newBelongsToMany insteadof PivotEventTrait;
    }
}
