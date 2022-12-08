<?php
namespace Delgont\Cms\Repository\Post;

use Delgont\Cms\Repository\Eloquent\BaseRepository;
use Delgont\Cms\Models\Post\Post;

class PostRepository extends BaseRepository
{
    protected $model;

    public function __construct(Post $model){
        $this->model = $model;
    }

}