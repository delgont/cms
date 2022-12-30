<?php

namespace Delgont\Cms\Observers;

use Delgont\Cms\Models\Option\Option;
use Illuminate\Support\Facades\Cache;

use Delgont\Cms\Cache\Option\OptionCacheManager;


class OptionObserver
{

    protected $cacheManger;

    public function __construct()
    {
        $this->cacheManger = app(OptionCacheManager::class);
    }

    /**
     * Handle the option "created" event.
     *
     * @param  \App\Option  $option
     * @return void
     */  
    public function created(Option $option)
    {
        $this->cacheManger->storeModelInCache($option, 'option_key');
    }

    /**
     * Handle the option "updated" event.
     *
     * @param  \App\Option  $option
     * @return void
     */
    public function updated(Option $option)
    {
        $this->cacheManger->clearValueFromCache($option->option_key);
        $this->cacheManger->clearModelFromCache($option->option_key);
    }

    /**
     * Handle the option "deleted" event.
     *
     * @param  \App\Option  $option
     * @return void
     */
    public function deleted(Option $option)
    {
        $this->cacheManger->clearValueFromCache($option->option_key);
        $this->cacheManger->clearModelFromCache($option->option_key);
    }

    /**
     * Handle the option "restored" event.
     *
     * @param  \App\Option  $option
     * @return void
     */
    public function restored(Option $option)
    {
    }

    /**
     * Handle the option "force deleted" event.
     *
     * @param  \App\Option  $option
     * @return void
     */
    public function forceDeleted(Option $option)
    {
        $this->cacheManger->clearValueFromCache($option->option_key);
        $this->cacheManger->clearModelFromCache($option->option_key);
    }
}
