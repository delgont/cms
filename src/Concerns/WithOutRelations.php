<?php

namespace Delgont\Cms\Concerns;

trait WithOutRelations
{
    public function scopeWithOutRelations($query)
    {
        return $query->withOut($this->with);
    }
}