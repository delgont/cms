<?php

namespace Delgont\Cms\Services\Post;

use Delgont\Cms\Models\Post\Post;

class PostSearchService
{

    public function results($what)
    {
        return Post::with(['posttype'])->search($what)->paginate(10);
    }

    protected function searchAttributes()
    {
        if (property_exists($this, 'searchableAttributes')) {
            return $this->searchableAttributes;
        }
    }


}