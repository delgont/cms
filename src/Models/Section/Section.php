<?php

namespace Delgont\Cms\Models\Section;


use Illuminate\Database\Eloquent\Model;

use Delgont\Cms\Models\Category\Category;





class Section extends Model
{
    protected $fillable = ['name', 'path', 'preview'];
    
}
