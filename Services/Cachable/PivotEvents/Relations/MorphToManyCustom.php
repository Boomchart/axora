<?php namespace Services\Cachable\PivotEvents\Relations;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Services\Cachable\PivotEvents\Traits\FiresPivotEventsTrait;

class MorphToManyCustom extends MorphToMany
{
    use FiresPivotEventsTrait;
}
