<?php namespace Services\Cachable\PivotEvents\Relations;

use Services\Cachable\PivotEvents\Traits\FiresPivotEventsTrait;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BelongsToManyCustom extends BelongsToMany
{
    use FiresPivotEventsTrait;
}
