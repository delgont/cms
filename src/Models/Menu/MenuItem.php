<?php

namespace Delgont\Cms\Models\Menu;

use Illuminate\Database\Eloquent\Model;

use Delgont\Cms\Models\Post\Post;
use Delgont\Cms\Models\Menu\Menu;

class MenuItem extends Model
{

    //protected $with = ['menuable:id,slug,url'];

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

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->with(['menuItems', 'menuable:id,slug']);
    }


}
