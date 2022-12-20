<?php
namespace Delgont\Cms\Repository\Concerns;

use Delgont\Cms\Repository\Eloquent\Contracts\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Builder;

trait CacheManager
{

    public function forget($keys)
    {
        if (is_array($keys)) {
            foreach ($keys as $key) {
                Cache::pull($key);
            }
        }else{
            Cache::pull($keys);
        }
        Cache::flush();
    }
    
    public function storeModelInCache( Model $model )
    {
        return $this->writeToCache( $this->generateUnitCacheKey($model), $model->toArray() );
    }

    public function storeCollectionInCache( Collection $collection, $cacheKey) : bool
    {
        return $this->writeToCache($cacheKey, $collection);
    }
   
    protected function storeInCache($key, $value)
    {
        return $this->writeToCache( $key, $value );
    }

    protected function writeToCache ( string $key, $value )
    {
        Cache::put($key, $value, now()->addMinutes(60));
        return true;
    }

}