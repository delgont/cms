<?php

namespace Delgont\Cms\Models\Role;


use Illuminate\Database\Eloquent\Model;
use Delgont\Cms\Concerns\HasPermissions;

class Role extends Model
{
  use HasPermissions;

    public function assigned_to()
    {
        return $this->morphTo();
    }

    public function scopeWithPermissions($query)
    {
      return $this->query->with['permissions'];
    }
}
