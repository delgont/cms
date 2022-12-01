<?php
namespace Delgont\Cms\Http\Controllers\Post;

use Delgont\Cms\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Delgont\Cms\Models\Post\Post;

use Delgont\Cms\Models\Category\Category;


class PostCategoryController extends Controller
{
    /**
    * Display a listing of the posts by its type.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $categories = Category::postCategories()->withCount('posts')->paginate(6);
        return (request()->expectsJson()) ? response()->json(['categories' => $categories]) : view('delgont::posts.categories.index', compact(['categories']));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:post_types,name'
        ]);

        $posttype = new PostType();
        $posttype->name = $request->name;

        $posttype->parent_id = ($request->has('parent_id') && $request->parent_id > 0) ?  $request->parent_id : null;

        $posttype->save();
        
        return back()->withInput();
    }


    public function destroy($id)
    {
        PostType::destroy($id);
        return back()->with('deleted', 'Post Type deleted successfully');

    }
   

}
