<?php

namespace Delgont\Cms\Http\Composers;

use Illuminate\View\View;

use Delgont\Cms\Models\Post\Post;

class PostsComposer
{

    public function compose(View $view)
    {
        $view->with('posts', Post::orderBy('created_at', 'desc')->paginate(30));
    }
}
