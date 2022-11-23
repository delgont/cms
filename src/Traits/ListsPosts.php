<?php
namespace Stephendevs\Pagman\Traits;

use Stephendevs\Pagman\Models\Post\Post;


trait ListsPosts {

    protected function posts()
    {
        return Post::all();
    }

    protected function listPostsResponse()
    {
        $posts = $this->posts();
        return (request()->expectsJson()) ? response()->json($this->posts()) : $this->listPostsView($posts);
    }

    protected function listPostsView($posts)
    {
        return view('pagman::posts.index', compact(['posts']));
    }

}