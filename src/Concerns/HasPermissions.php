<?php

namespace Delgont\Cms\Concerns;

trait HasPermissions
{
    public function permissions()
    {
        return $this->morphMany('Delgont\Cms\Models\Permission\Permission', 'assigned_to');
    }
}