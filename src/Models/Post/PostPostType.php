<?php

namespace Delgont\Cms\Models\Post;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Delgont\Cms\Models\Post\PostType;
use Delgont\Cms\Models\Post\Post;


class PostPostType extends Model
{
    
    protected $table = 'post_post_type';

    protected $guarded = [];

    protected $with = ['postType'];



    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function postType()
    {
        return $this->belongsTo(PostType::class, 'post_type_id');
    }
}
