<?php

namespace Delgont\Cms\Models\Menu;

use Delgont\Cms\Models\Post\Post;

use Illuminate\Database\Eloquent\Model;

use Delgont\Cms\Models\Concerns\Children;


class Menu extends Model
{
    use Children;
    
    protected $guarded = [];

    public function menus()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'menu_id');
    }


    public function menuItems()
    {
        return $this->hasMany('Delgont\Cms\Models\Menu\MenuItem')->with('menuable:id,slug')->whereNull('parent_id');
    }

    public function levelOneMenuItems()
    {
        return $this->hasMany('Delgont\Cms\Models\Menu\MenuItem')->whereNull('parent_id')->orderBy('sort', 'asc')->with(['children', 'menuable:id,slug']);
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

    public function scopeWithMenuItems($query, $maxLevel = 0, $parentOrder = 'asc')
    {
            switch ($maxLevel) {
                case 1:
                    return $query->with(['menuItems' => function($levelOneMenuItemQuery) use($parentOrder){
                        $levelOneMenuItemQuery->orderBy('sort', $parentOrder);
                    }]);
                    break;
                case 2:
                    return $query->with(['menuItems' => function($levelTwoMenuItemQuery) use($parentOrder){
                        $levelTwoMenuItemQuery->with([
                            'children'
                        ])->orderBy('sort', $parentOrder);
                    }]);
                    break;
                case 3:
                    return $query->with(['menuItems' => function($levelTwoMenuItemQuery) use($parentOrder){
                        $levelTwoMenuItemQuery->with([
                            'children' => function($levelThreeMenuItemQuery){
                                $levelThreeMenuItemQuery->with(['children']);
                            }
                        ])->orderBy('sort', $parentOrder);
                    }]);
                    break;
                case 4:
                    return $query->with(['menuItems' => function($levelTwoMenuItemQuery) use($parentOrder){
                        $levelTwoMenuItemQuery->with([
                            'children' => function($levelThreeMenuItemQuery){
                                $levelThreeMenuItemQuery->with([
                                    'children' => function($levelFourMenuItemQuery){
                                        $levelFourMenuItemQuery->with('children');
                                    }
                                ]);
                            }
                        ])->orderBy('sort', $parentOrder);
                    }]);
                    break;
                case 5:
                    return $query->with(['menuItems' => function($levelTwoMenuItemQuery) use($parentOrder){
                        $levelTwoMenuItemQuery->with([
                            'children' => function($levelThreeMenuItemQuery){
                                $levelThreeMenuItemQuery->with([
                                    'children' => function($levelFourMenuItemQuery){
                                        $levelFourMenuItemQuery->with([
                                            'children' => function($levelFiveMenuItemQuery){
                                                $levelFiveMenuItemQuery->with('children');
                                            }
                                        ]);
                                    }
                                ]);
                            }
                        ])->orderBy('sort', $parentOrder);
                    }]);
                    break;
                default:
                    return $query->with(['menuItems' => function($menuItemQuery) use($parentOrder){
                        $menuItemQuery->orderBy('sort', $parentOrder);
                    }]);
                    break;
            }
        return $query;
    }
}
