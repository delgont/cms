<?php

namespace Delgont\Cms\Models\Post;

use Delgont\Cms\Models\Post\Post;


use Illuminate\Database\Eloquent\Model;

class PostType extends Model
{
    
    protected $guarded = [];


    
    public function posts()
    {
        return $this->hasMany(Post::class, 'post_type_id');
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
