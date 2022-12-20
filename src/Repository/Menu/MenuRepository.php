<?php
namespace Delgont\Cms\Repository\Menu;

use Delgont\Cms\Repository\Eloquent\BaseRepository;

use Delgont\Cms\Models\Menu\Menu;
use Delgont\Cms\Models\Menu\MenuItem;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Cache;


class MenuRepository extends BaseRepository
{
    protected $model;

    public function __construct(Menu $model){
        $this->model = $model;
    }

    public function menu ( string $menu_key, $maxLevel = 0, $parentOrder = 'asc' ) : ? Model
    {
        if ( $this->fromCache ) {
            $cached = Cache::get($this->cachePrefix().':'.$menu_key );
            if( $cached ) {
                $models = $this->model::hydrate([$cached]);
                return $model = $models[0] ?? null;
            }else{
                $model = $this->model->withMenuItems($maxLevel)->where(($this->cacheAttribute) ? [$this->cacheAttribute => $menu_key] : ['id' => $menu_key])->firstOrFail();
                $this->storeModelInCache($model);
                return $model;
            }
        }
    }
    public function menuItems( string $menu_key_or_id, $maxLevel = 0, $parentOrder = 'asc' )
    {
        return MenuItem::ofMenu('hello');
    }

    

}