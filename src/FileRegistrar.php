<?php

namespace Delgont\Cms;

use Illuminate\Cache\CacheManager;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Database\Eloquent\Collection;

use Delgont\Cms\MOdels\File\File;

class FileRegistrar
{
    /** @var \Illuminate\Contracts\Cache\Repository */
    protected $cache;


    /** @var \Illuminate\Cache\CacheManager */
    protected $cacheManager;

    /** @var string */
    public static $cacheKey;

    /** @var \DateInterval|int */
    public static $cacheExpirationTime;

    /**
     * FileRegistrar constructor.
     *
     * @param \Illuminate\Cache\CacheManager $cacheManager
     */
    public function __construct(CacheManager $cacheManager)
    {
        $this->cacheManager = $cacheManager;
        $this->initializeCache();
    }

    public function initializeCache()
    {
        self::$cacheKey = config('file.cache.key', 'files');
        self::$cacheExpirationTime = \DateInterval::createFromDateString('24 hours');

        $this->cache = $this->cacheManager->store();
    }

    public function loadFiles()
    {
        $this->cache->remember(self::$cacheKey, self::$cacheExpirationTime, function(){
            return $this->getSerializedFilessForCache();
        });
    }



    private function getSerializedFilessForCache()
    {
        $files = File::select('id', 'label', 'mime_type')->with(['categories:id,name', 'icon:id,url', 'groups:id,name'])->get();
        return compact('files');
    }

    public function getCachedFiles()
    {
        return $this->cache->get(self::$cacheKey);
    }

    /**
     * Flush the cache.
     */
    public function forgetCached()
    {
        return $this->cache->forget(self::$cacheKey);
    }


}