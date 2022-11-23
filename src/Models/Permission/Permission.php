<?php

namespace Delgont\Cms\Models\Permission;


use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{

    public function assigned_to()
    {
        return $this->morphTo();
    }


}
