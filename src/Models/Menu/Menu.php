<?php

namespace Delgont\Cms\Models\Menu;

use Delgont\Cms\Models\Post\Post;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    
    protected $guarded = [];

    public function menus()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'menu_id');
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->with('menus');
    }
   
    public function menuItems()
    {
        return $this->hasMany('Delgont\Cms\Models\Menu\MenuItem');
    }

    public function navMenuItems()
    {
        return $this->hasMany('Delgont\Cms\Models\Menu\MenuItem')->whereNull('parent_id')->orderBy('sort', 'asc')->with(['children', 'menuable:id,slug']);
    }

    public function scopeWithOrganisedMenuItems($query)
    {
        return $query->with(['navMenuItems.children' => function($q){
            $q->orderBy('sort', 'asc');
        }]);
    }

    public function scopeWithSimpleMenuItems($query)
    {
        return $query->with('navMenuItems');
    }

}
