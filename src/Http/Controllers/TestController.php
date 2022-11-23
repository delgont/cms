<?php

namespace Delgont\Cms\Http\Controllers;

use Delgont\Cms\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Delgont\Cms\Services\Post\PostSearchService;

use Delgont\Cms\Models\Post\Post;

use Delgont\Cms\Models\Menu\Menu;



class TestController extends Controller
{
    private $postSearchService;

    public function __construct(PostSearchService $postSearchService){
        $this->PostSearchService = $postSearchService;
    }


    public function index(Request $request)
    {
        $posts = (new PostSearchService)->results($request->key);
        return view('delgont::posts.search', compact('posts'));
    }
}
