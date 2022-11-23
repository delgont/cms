<?php

namespace Delgont\Cms\Models\Concerns;

trait HasLinks
{
    public function links()
    {
        return $this->morphMany('Delgont\Cms\Models\Link\Link', 'linkable');
    }
}