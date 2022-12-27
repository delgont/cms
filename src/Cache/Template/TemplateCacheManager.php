<?php

namespace Delgont\Cms\Cache\Template;

use Delgont\Cms\Cache\ModelCacheManager;

use Delgont\Cms\Models\Template\Template;



class TemplateCacheManager extends ModelCacheManager
{
    public function __construct(Template $model)
    {
        parent::__construct($model);
    }

    public function storePathInCache($payLoad) : ? bool
    {
        if ( $payLoad instanceof $this->model ) {
            return $this->writeToCache( $this->getCachePrefix($this->model).':path:'.$payLoad->id, $payLoad->path );
        }
        if ( is_array($payLoad) && count($payLoad) > 0 ) {
            return $this->writeToCache( $this->getCachePrefix($this->model).':path:'.$payLoad['id'], $payLoad['path'] );
        }
        return false;
    }
    

    
}