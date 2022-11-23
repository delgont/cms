<?php
namespace Delgont\Cms\Models\Concerns;

use Delgont\Cms\Models\Icon\Icon;
use Delgont\Cms\Models\Post\PostPostType;
use Delgont\Cms\Models\Post\Post;


trait HasPostsOfType {

    public function postsOfType()
    {
        return $this->hasOne(PostPostType::class);
    }
}