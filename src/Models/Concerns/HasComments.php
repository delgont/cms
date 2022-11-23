<?php

namespace Delgont\Cms\Models\Concerns;

trait HasComments
{
    public function comments()
    {
        return $this->morphMany('Delgont\Cms\Models\Comment\Comment', 'commentable');
    }
}