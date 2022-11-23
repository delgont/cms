<?php

namespace Delgont\Cms\Models\Media;


use Illuminate\Database\Eloquent\Model;
use Delgont\Cms\Models\Post\Post;
use Delgont\Cms\Concerns\Categorable;




class Media extends Model
{
    use Categorable;
    
    public function posts()
    {
        return $this->morphByMany(Post::class, 'mediable');
    }
  
}
