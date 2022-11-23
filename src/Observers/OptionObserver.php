<?php

namespace Delgont\Cms\Observers;

use Delgont\Cms\Models\Option\Option;
use Illuminate\Support\Facades\Cache;

class OptionObserver
{
    /**
     * Handle the option "created" event.
     *
     * @param  \App\Option  $option
     * @return void
     */  
    public function created(Option $option)
    {
        Cache::forever($option->option_key, $option->option_value);
    }

    /**
     * Handle the option "updated" event.
     *
     * @param  \App\Option  $option
     * @return void
     */
    public function updated(Option $option)
    {
        Cache::forever($option->option_key, $option->option_value);
    }

    /**
     * Handle the option "deleted" event.
     *
     * @param  \App\Option  $option
     * @return void
     */
    public function deleted(Option $option)
    {
        Cache::forget($option->option_key, $option->option_value);
    }

    /**
     * Handle the option "restored" event.
     *
     * @param  \App\Option  $option
     * @return void
     */
    public function restored(Option $option)
    {
        Cache::forever($option->option_key, $option->option_value);
    }

    /**
     * Handle the option "force deleted" event.
     *
     * @param  \App\Option  $option
     * @return void
     */
    public function forceDeleted(Option $option)
    {
        Cache::forget($option->option_key, $option->option_value);
    }
}
