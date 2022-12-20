<?php

namespace Delgont\Cms\Models\Category;


use Illuminate\Database\Eloquent\Model;
use Delgont\Cms\Models\Category\Category;


class Categorable extends Model
{

    public function categories()
    {
        return $this->belongsTo(Category::class);
    }
   
}
