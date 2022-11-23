<?php

namespace Delgont\Cms\Http\Controllers\Post;

use Delgont\Cms\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Delgont\Cms\Models\Category\Category;

use Delgont\Cms\Http\Requests\PostRequest;
use Delgont\Cms\Models\Post\PostType;

use Delgont\Cms\Services\Post\PostService;
use Delgont\Cms\Services\Image\ImageUploadService;

use Delgont\Cms\Services\Post\PostSearchService;



class PostController extends Controller
{
    private $postService, $imageUploadService;

    public function __construct(PostService $postService, ImageUploadService $imageUploadService){
        $this->postService = $postService;
        $this->imageUploadService = $imageUploadService;
    }

    /**
    * Display a listing of the posts by its type.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $posts = $this->postService->all();
        $postsTrashCount = $this->postService->countTrash();
        return (request()->expectsJson()) ? response()->json(['posts' =>$posts, 'postsTrashCount' => $postsTrashCount]) : view('delgont::posts.index', compact(['posts', 'postsTrashCount']));
    }

    public function create()
    {
        $posttypes = PostType::all();
        $categories = Category::all();
        return (request()->expectsJson()) ? response()->json($categories, $posttypes) : view('delgont::posts.create', compact(['categories', 'posttypes']));
    }

    public function duplicate($id)
    {
        $posttypes = PostType::all();
        $categories = Category::all();
        $duplicate = $this->postService->show($id);

        return (request()->expectsJson()) ? response()->json($categories, $posttypes) : view('delgont::posts.duplicate', compact(['categories', 'posttypes', 'duplicate']));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $request->validated();


        $post_type_id = ($request->post_type) ? PostType::firstOrCreate(['name' => $request->post_type])->id : null;
       
        $post = $this->postService->save([
            'post_title' => $request->post_title,
            'slug' => ($request->slug) ? $request->slug : $request->post_title,
            'post_type_id' => ($request->post_type_id) ? $request->post_type_id : $post_type_id,
            'extract_text' => $request->extract_text,
            'post_content' => $request->post_content,
            'template_id' => $request->template_id,
            'parent_id' => $request->parent_id,
            'post_featured_image' => ($request->hasFile('post_featured_image')) ? $this->imageUploadService->upload(request()->post_featured_image) : null
        ]);

        $this->postService->attachCategories($post, $request->category);
        
        return ($request->expectsJson()) ? response()->json(['success' => true,'message' => 'Post Created Successfully',], 200) : back()->withInput()->with('created', 'Post Created Successfully');
    }

    public function show($id)
    {
        $post = $this->postService->show($id);
        return (request()->expectsJson()) ? response()->json($post) : view('delgont::posts.show', compact(['post']));
    }

    public function edit($id)
    {
        $posttypes = PostType::all();
        $categories = Category::all();
        $post = $this->postService->show($id);
        return (request()->expectsJson()) ? response()->json($post, $posttypes) : view('delgont::posts.edit', compact(['posttypes', 'post', 'categories']));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'post_title' => 'required|unique:posts,post_title,'.$id,
            'slug' => 'nullable|unique:posts,slug,'.$id,
            'post_type_id' => 'nullable',
            'extract_text' => 'nullable|min:3|max:200',
            'post_featured_image' => 'nullable|mimes:jpeg,png,jpg|max:2048'
        ]);

        //return $request;

        $post_type_id = ($request->post_type) ? PostType::firstOrCreate(['name' => $request->post_type])->id : null;


        $post = $this->postService->find($id);

        $this->postService->update($id, [
            'post_title' => $request->post_title,
            'slug' => ($request->slug) ? str_replace(' ','-', $request->slug) : str_replace(' ','-', $request->post_title),
            'post_type_id' => ($request->post_type_id) ? $request->post_type_id : $post_type_id,
            'extract_text' => $request->extract_text,
            'post_content' => $request->post_content,
            'template_id' => $request->template_id,
            'menu_id' => $request->menu_id,
            'parent_id' => $request->parent_id,
            'post_featured_image' => ($request->hasFile('post_featured_image')) ? $this->imageUploadService->upload(request()->post_featured_image) : $post->post_featured_image,
            'updated_by' =>  auth()->user()->id
        ]);
        $this->postService->attachCategories($post, $request->category);
        $this->postService->attachPostPostType($post, $request->post_post_type_id);

        //return $this->postService->show($id);

        return ($request->expectsJson()) ? response()->json(['success' => true,'message' => 'Post Updated Successfully'], 200) : back()->withInput()->with('updated', 'Post Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->postService->delete($id);
        return back()->with('deleted', 'Post deleted successfully');
    }



    private function postTypes() : array
    {
        return config(config('delgont.web', 'web').'.post_types', []);
    }


    public function editFeaturedImage(Request $request)
    {
        return ($request->expectsJson()) ? response()->json(['hello']) : back()->withInput();
    }
   
    public function destroyFeaturedImage(Request $request, $id)
    {
        $this->postService->destroyFeaturedImage($id);
        return ($request->expectsJson()) ? response()->json(['hello']) : back()->withInput();
    }

    /**
    * Publish Post
    *
    * @return \Illuminate\Http\Response
    */

    public function publish($id)
    {
        $this->postService->publish($id);
        return (request()->expectsJson()) ? response()->json($id, 200) : back();
    }

    /**
    * UnPublish Post
    *
    * @return \Illuminate\Http\Response
    */

    public function unPublish($id)
    {
        $this->postService->unPublish($id);
        return (request()->expectsJson()) ? response()->json($id, 200) : back();
    }

    public function search(Request $request)
    {
        $posts = (new PostSearchService)->results($request->search_key);
        return view('delgont::posts.search', compact('posts'));
    }
    
}
