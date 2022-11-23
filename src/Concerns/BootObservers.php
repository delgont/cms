<?php

namespace Delgont\Cms\Concerns;

/**
 * Observers
 */
use Delgont\Cms\Observers\OptionObserver;

/**
 * Models
 */
use Delgont\Cms\Models\Option\Option;

trait BootObservers
{
    private function bootObservers() : void
    {
        Option::observe(OptionObserver::class);
    }
}