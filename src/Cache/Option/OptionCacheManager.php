<?php

namespace Delgont\Cms\Cache\Option;

use Delgont\Cms\Cache\ModelCacheManager;

use Delgont\Cms\Models\Option\Option;



class OptionCacheManager extends ModelCacheManager
{
    public function __construct(Option $model)
    {
        parent::__construct($model);
    }

    /**
     * Clear | Remove option cached value from cache
     */
    public function clearValueFromCache($key) : ? bool
    {
        return $this->clear($this->getCachePrefix().':value:'.$key);
    }
}