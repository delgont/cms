<?php

namespace Delgont\Cms\Concerns;

trait HasRoles
{
    public function roles()
    {
        return $this->morphMany('Delgont\Cms\Models\Role\Role', 'assigned_to');
    }
}