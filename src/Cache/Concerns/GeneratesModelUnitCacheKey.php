<?php
namespace Delgont\Cms\Cache\Concerns;

use Illuminate\Database\Eloquent\Model;


trait GeneratesModelUnitCacheKey
{
    public function generateModelUnitCacheKey ( Model $model, $key = null ) : string 
    {
        if (property_exists($this, 'model')) {
            if ($model instanceof $this->model) {
                if (property_exists($this, 'key') && method_exists($this, 'getCachePrefix')) {
                    return ($this->key) ? $this->getCachePrefix().':'.$model->getAttribute($this->key) : $this->getCachePrefix().':'.$model->getKey();
                } else {
                    return get_class($this->model).':'.$key;
                }
            }
        }
        return get_class($model).':'.$key;
    }

    public function storeModelsInCache(array $models)
    {
        if (count($models) > 0) {
            
        }
    }

}