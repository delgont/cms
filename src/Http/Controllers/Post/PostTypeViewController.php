<?php

namespace Stephendevs\Pagman\Http\Controllers\Post;

use Stephendevs\Pagman\Http\Controllers\Controller;
use Illuminate\Http\Request;


class PostTypeViewController extends Controller
{
    
     public function index($view)
     {
         return view('pagman::core.includes.posttypeviews.'.$view);
     }

}
