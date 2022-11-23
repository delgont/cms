<?php

namespace Delgont\Cms\Models\Concerns;

trait HasSocialLinks
{
    public function socialLinks()
    {
        return $this->morphMany('Delgont\Cms\Models\Link\Link', 'linkable');
    }
}