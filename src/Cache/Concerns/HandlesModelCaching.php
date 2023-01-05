<?php
namespace Delgont\Cms\Cache\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;



trait HandlesModelCaching
{
    /**
     * The model column attribute to be used when finding model or setting cache key
     * By default uses id 
     * @var string
     */
    protected $key = 'id';

     /**
     * The prefix for the cache keys
     *
     * @var string
     */
    protected $cachePrefix = null;

    protected $model;


    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    public function getkey() : ? string
    {
        return $this->key;
    }


    public function setCachePrefix()
    {
        $this->cachePrefix = get_class($this->model);
        return $this;
    }

    public function getCachePrefix(Model $model = null)
    {
        return ($model) ? get_class($model) : $this->cachePrefix;
    }


    public function generateModelUnitCacheKey ( Model $model, $key = null ) : string 
    {
        return ($key) ? $this->getCachePrefix($model).':'.$key : $this->getCachePrefix($model).':'.$model->getKey();
    }


    public function storeModelInCache( Model $model, $key = null)
    {
        return $this->writeToCache( $this->generateModelUnitCacheKey($model, $key), $model->toArray() );
    }

    public function storeCollectionInCache( Collection $collection, $cacheKey) : bool
    {
        return $this->writeToCache($cacheKey, $collection);
    }

    public function storeLengthAwarePaginatorInCache( LengthAwarePaginator $data, $cacheKey) : bool
    {
        return $this->writeToCache($cacheKey, $data);
    }



    public function storeModelsInCache(array $models)
    {
        if (count($models) > 0) {
            
        }
    }

    protected function getModelFromCache($key, Model $model = null) : ? Model 
    {
        $cached = Cache::get($key);
        if($cached){
            $models = (!is_null($model)) ? $model::hydrate([$cached]) : $this->model::hydrate([$cached]);
            return $models[0] ?? null;
        }
        return null;
    }


    protected function writeToCache ( string $key, $value ) : ? bool
    {
        Cache::put($key, $value, now()->addMinutes(60));
        return true;
    }

}