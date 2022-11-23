<?php

namespace Delgont\Cms\Models\Group;


use Illuminate\Database\Eloquent\Model;
use Delgont\Cms\Models\Concerns\Iconable;
use Delgont\Cms\Models\Concerns\HasOptions;

class Group extends Model
{
    use Iconable, HasOptions;
    
    protected $guarded = [];


    

}
