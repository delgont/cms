<?php

namespace Delgont\Cms\Http\Controllers\Post;

use Delgont\Cms\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Delgont\Cms\Models\Post\Post;
use Delgont\Cms\Models\Category\Category;
use Delgont\Cms\Models\Comment\Comment;

use Delgont\Cms\Http\Requests\PostRequest;
use App\User;

class PostCommentController extends Controller
{
   public function index($id)
   {
         $post = Post::with([
            'comments' => function($q){
                $q->orderBy('created_at', 'desc')->paginate(10);
            }
        ])->findOrFail($id);
        return (request()->expectsJson()) ? response()->json($post) : view('delgont::posts.comments.index', compact('post'));
   }

   public function store(Request $request, $id)
   {
        $request->validate([
            'comment' => 'required'
        ]);

        Post::findOrFail($id)->comments()->create([
            'comment' => $request->comment,
            'commenter_id' => auth()->user()->id,
            'commenter_type' => User::class
        ]);
        return back()->withInput();
   }

   public function update(Request $request, $comment_id)
   {
        Comment::where('id', $comment_id)->update([
            'comment' => 'hellofgdfgff',
            'commenter_id' => auth()->user()->id,
            'commenter_type' => User::class
        ]);
        
        return back()->withInput();
   }
   

}
