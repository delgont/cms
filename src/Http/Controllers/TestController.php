<?php

namespace Delgont\Cms\Http\Controllers;

use Delgont\Cms\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Delgont\Cms\Repository\Post\PostRepository;




class TestController extends Controller
{

   

    public function index()
    {
        return app(PostRepository::class)->find(1);
    }
}
