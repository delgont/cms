<?php

namespace Delgont\Cms\Models\Menu;

use Illuminate\Database\Eloquent\Model;

use Delgont\Cms\Models\Concerns\Children;


use Delgont\Cms\Models\Menu\Menu;

class MenuItem extends Model
{
    use Children;

    protected $guarded = [];

    public function menuable()
    {
        return $this->morphTo();
    }

    public function menu()
    {
        return $this->belongsTo('Delgont\Cms\Models\Menu\Menu');
    }

    public function menuItems()
    {
        return $this->hasMany(self::class, 'parent_id')->with('menuable:id,slug');
    }


    public function getChildrenWith()
    {
        return ['menuItems', 'menuable:id,slug'];
    }


}
