<?php

namespace Delgont\Cms\Cache\Post;

use Delgont\Cms\Cache\ModelCacheManager;

use Delgont\Cms\Models\Post\Post;



class PostCacheManager extends ModelCacheManager
{
    public function __construct(Post $model)
    {
        parent::__construct($model);
    }

    public function clearCategories($post_id) : ? bool
    {
        return $this->clear($this->getCachePrefix().':categories:'.$post_id);
    }

    
}