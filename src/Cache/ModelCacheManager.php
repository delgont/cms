<?php

namespace Delgont\Cms\Cache;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;

use Delgont\Cms\Cache\Concerns\HandlesModelCaching;


class ModelCacheManager
{
    use HandlesModelCaching;

    
    public function __construct( Model $model)
    {
        $this->model = $model;
        $this->cachePrefix = get_class($this->model);
    }

    protected function clear($key) : ? bool
    {
        Cache::forget($key);
        return true;
    }

    public function flush()
    {
        Artisan::call('cache:clear');
        return true;
    }

    /**
     * Clear model from cache
     */
    public function clearModelFromCache($key) : ? bool
    {
        return $this->clear($this->getCachePrefix().':'.$key);
    }

    public function getModelCacheKey(Model $model = null, $key = null) : ? string 
    {
        return $this->generateModelUnitCacheKey($model, $key);
    }



}