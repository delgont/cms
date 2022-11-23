<?php

namespace Delgont\Cms\Models\Download;


use Illuminate\Database\Eloquent\Model;

use Delgont\Cms\Models\Post\Post;

use Delgont\Cms\Models\Concerns\Categorable;
use Delgont\Cms\Models\Concerns\Iconable;



class Download extends Model
{
    use Categorable, Iconable;

    protected $with = ['categories', 'icon:id,url,icon_format,iconable_id'];


    public function posts()
    {
        return $this->morphedByMany(Post::class, 'attachedto', 'downloadables');
    }


}
