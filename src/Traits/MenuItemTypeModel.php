<?php
namespace Stephendevs\Pagman\Traits;

use Stephendevs\Pagman\Models\Post\Post;


trait MenuItemTypeModel {
    
    public function menuItems()
    {
        return $this->morphMany('Stephendevs\Pagman\Models\Menu\MenuItem', 'menu_item');
    }

}