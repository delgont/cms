<?php

namespace Delgont\Cms\Http\Controllers;

use Delgont\Cms\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Delgont\Cms\Models\Category\Category;
use Delgont\Cms\Models\Post\Post;




class DashboardController extends Controller
{
    public function index()
    {
        $posts_count = Post::all()->count();
        $pages_count = '100';
        return view('delgont::index', compact(['posts_count', 'pages_count']));
    }
}
