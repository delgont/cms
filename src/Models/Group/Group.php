<?php

namespace Delgont\Cms\Models\Group;


use Illuminate\Database\Eloquent\Model;
use Delgont\Cms\Models\Concerns\Iconable;

class Group extends Model
{
    use Iconable;
    
    protected $guarded = [];

    /**
     * Get groups for specific model type
     */
    public function scopeGroups($query, $model = null)
    {
        return ($model) ? $query->whereType(($model instanceof Model) ? get_class($model) : $model)->orWhere('type', null) : $query;
    }

}
