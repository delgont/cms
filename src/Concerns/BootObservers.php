<?php

namespace Delgont\Cms\Concerns;

/**
 * Observers
 */
use Delgont\Cms\Observers\PostObserver;
use Delgont\Cms\Observers\OptionObserver;


/**
 * Models
 */
use Delgont\Cms\Models\Post\Post;
use Delgont\Cms\Models\Option\Option;

trait BootObservers
{
    private function bootObservers() : void
    {
        Post::observe(PostObserver::class);
        Option::observe(OptionObserver::class);
    }
}