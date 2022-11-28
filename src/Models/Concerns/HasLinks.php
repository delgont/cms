<?php

namespace Delgont\Cms\Models\Concerns;

trait HasLinks
{
    public function links()
    {
        $relation = $this->morphToMany(
            'Delgont\Cms\Models\Link\Link',
            'model',
            'model_has_links',
            'model_id',
            'link_id'
        );
        return $relation;
    }
}