<?php
namespace Delgont\Cms\Models\Concerns;

use Delgont\Cms\Models\Group\Group;

use Illuminate\Database\Eloquent\Collection;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait Groupable {

    public function groups() : MorphToMany
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

    /**
     * Attach groups to a model without detaching
     * @param mixed $groups
     * @return $this
     */
    public function attachGroups($groups)
    {
        $this->groups()->syncWithoutDetaching(($groups instanceof Collection) ? collect($groups)->pluck('id') : $groups);
        return $this;
    }

    /**
     * Attach groups to a model with detaching
     * @param mixed $groups
     * @return $this
     */
    public function syncGroups($groups)
    {
        $this->groups()->sync(($groups instanceof Collection) ? collect($groups)->pluck('id') : $groups);
        return $this;
    }

    
}