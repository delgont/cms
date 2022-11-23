<?php

namespace Delgont\Cms\Http\Controllers\Post;

use Delgont\Cms\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Delgont\Cms\Models\Post\Post;
use Delgont\Cms\Models\Category\Category;

use Delgont\Cms\Services\Post\PostTrashService as Trash;


class PostTrashController extends Controller
{
    private $trash;

    public function __construct(Trash $trash){
        $this->trash = $trash;
    }
    
    public function index()
    {
        $posts = $this->trash->get();
        return (request()->expectsJson()) ? response()->json($posts) : view('delgont::posts.trash.index', compact(['posts']));
    }

    public function show($id)
    {
        return Post::onlyTrashed()->findOrFail($id);
    }

    /**
     * Permanently delete post
     */
    public function destroy($id)
    {
        $this->trash->destroy($id);
        return back()->with('deleted', 'Post deleted permanently');

    }

    /**
     * Restore deleted post
     * 
     * @param int $id
     */

     public function restore($id)
     {
        $this->trash->restore($id);
        return back();
     }

}
