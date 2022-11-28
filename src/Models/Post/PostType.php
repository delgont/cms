<?php

namespace Delgont\Cms\Models\Post;

use Delgont\Cms\Models\Post\Post;

use Delgont\Cms\Models\Concerns\Children;



use Illuminate\Database\Eloquent\Model;

class PostType extends Model
{
    use Children;
    
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
