<?php

namespace Delgont\Cms\Models\Concerns;

use Delgont\Cms\Models\Icon\Icon;

trait HasAvator
{
    public function avator()
    {
        return $this->morphOne(Icon::class, 'iconable');
    }


}