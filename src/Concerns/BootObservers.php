<?php

namespace Delgont\Cms\Concerns;

/**
 * Observers
 */
use Delgont\Cms\Observers\PostObserver;
use Delgont\Cms\Observers\OptionObserver;

use Delgont\Cms\Observers\TemplateObserver;


/**
 * Models
 */
use Delgont\Cms\Models\Post\Post;
use Delgont\Cms\Models\Option\Option;
use Delgont\Cms\Models\Template\Template;

trait BootObservers
{
    private function bootObservers() : void
    {
        Post::observe(PostObserver::class);
        Template::observe(TemplateObserver::class);
        Option::observe(OptionObserver::class);
    }
}