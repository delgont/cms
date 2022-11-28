<?php
namespace Delgont\Cms\Models\Concerns;

use Delgont\Cms\Models\Post\Post;


trait HasPost {

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}