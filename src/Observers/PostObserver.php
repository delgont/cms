<?php

namespace Delgont\Cms\Observers;

use Delgont\Cms\Models\Post\Post;
use Illuminate\Support\Facades\Cache;

use Delgont\Cms\Cache\Post\PostCacheManager;



class PostObserver
{

    protected $postCacheManger;

    public function __construct()
    {
        $this->postCacheManger = app(PostCacheManager::class);
    }

    /**
     * Handle the option "created" event.
     *
     * @param  \App\Option  $option
     * @return void
     */  
    public function created(Post $post)
    {
    }

    /**
     * Handle the option "updated" event.
     *
     * @param  \App\Option  $option
     * @return void
     */
    public function updated(Post $post)
    {
        $this->postCacheManger->clearModelFromCache($post->slug);
        $this->postCacheManger->clearCategories($post->id);
    }

    /**
     * Handle the option "deleted" event.
     *
     * @param  \App\Option  $option
     * @return void
     */
    public function deleted(Option $option)
    {
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
    }
}
