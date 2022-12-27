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

    public function clearPostPosts( $postModel )
    {
        $post = $postModel->load('postsOfType');
        if($post->postsOfType && $post->postsOfType->post_type_id){
            for ($i=0; $i < 10; $i++) { 
                # code...
                $this->clear( $this->generateModelUnitCacheKey($this->model, $post->id.':postsOfType:'.$post->postsOfType->post_type_id.':offset:'.$i));
            }
        }else{
            if ($post->post_type_id) {
                for ($i=0; $i < 10; $i++) { 
                    # code...
                    $this->clear( $this->generateModelUnitCacheKey($this->model, $post->id.':postsOfType:'.$post->post_type_id.':offset:'.$i));
                }
            }
        }
        
    }

    public function clearChildrenFromCache( $postModel )
    {
        for ($i=0; $i < 10; $i++) { 
            # code...
            $this->clear( $this->generateModelUnitCacheKey($this->model, $postModel->id.':children:offset:'.$i));
        }
        
    }

    
}