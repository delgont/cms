<?php
namespace Delgont\Cms\Models\Concerns;

use Delgont\Cms\Models\Group\Group;

trait Groupable {

    public function groups()
    {
        return $this->morphToMany(Group::class, 'groupable')->where('type', self::class);
    }

    /**
     * Local Scope to get models of a specific group
     * 
     * @param $query
     * @param string $category
     * @return Object
     */
    public function scopeOfGroup($query, $group) : Object
    {
        return $query->whereHas('groups', function($groupQuery) use ($group){
            (is_array($group)) ? $groupQuery->where($group) : $groupQuery->whereName($group)->orWhere('id', $group);;
        });
    }
}