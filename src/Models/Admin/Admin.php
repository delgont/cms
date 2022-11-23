<?php

namespace Delgont\Cms\Models\Admin;


use Illuminate\Database\Eloquent\Model;
use Delgont\Cms\Models\Concerns\Userable;


class Admin extends Model
{
    use Userable;
    
    protected $guarded = [];

    
}
