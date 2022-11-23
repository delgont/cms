<?php

namespace Delgont\Cms\Http\Controllers\Page;

use Delgont\Cms\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Delgont\Cms\Http\Requests\PageRequest;


use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;

use Delgont\Cms\Models\Post\Post;
use Delgont\Cms\Models\Category\Category;
use Delgont\Cms\Models\Post\PostType;

use Delgont\Cms\Services\Page\PageService;



class PageController extends Controller
{

    private $pageService;

    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }
    
     /**
     * Display a listing of pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Post::pages()->get();
        $pages =  Page::with('posttype')->orderBy('updated_at', 'desc')->paginate(10);
        return (request()->expectsJson()) ? response()->json(['pages' => $pages]) : view('delgont::pages.index', compact(['pages']));
    }
     /**
     * Show the form for creating a new page.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_keys = $this->pageKeys();
        $categories = Category::all();
        $postTypes = PostType::where('page_id', NULL)->get();
        return view('delgont::pages.create', compact(['page_keys', 'categories', 'postTypes']));
    }

    /**
     * Store a newly created page in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PageRequest $request)
    {
        
        $request->validated();

        $page = new Page();
        $page->page_title = $request->page_title;
        $page->page_key = ($request->page_key !== 'ignored') ? $request->page_key : str_replace(' ', '-', $request->page_title);
        $page->extract_text = $request->extract_text;
        $page->page_content = $request->page_content;
        $page->created_by = auth()->user()->id;
        $page->updated_by = auth()->user()->id;
        
        //dertermine if request has file
        $page->page_featured_image = ($request->hasFile('page_featured_image')) ? 'storage/'.request()->page_featured_image->store(config('delgont.media_dir', 'media/featuredimages'), 'public') : null;
        $page->save();
        $page->categories()->sync($request->category);

        if($request->has('post_type_id') && $request->post_type_id > 0){
            PostType::where('id', $request->post_type_id)->update(['page_id' => $page->id]);
        }

        # Check if request has icon
        if($request->hasFile('page_icon')){
            $page->icon()->create([
                'icon' => 'storage/'.request()->page_icon->store(config('delgont.media_dir', 'media'), 'public')
            ]);
        }

        return ($request->expectsJson()) ? response()->json(['success' => true,'message' => 'Page Created Successfully',], 200) : back()->withInput()->with('created', 'Post Created Successfully');
    }

    public function show($id)
    {
        $page = Page::with(['icon:id,name,url'])->findOrFail($id);
        return (request()->expectsJson()) ? response()->json($page) : view('delgont::pages.show', compact(['page']));
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        $page = Page::with(['icon:id,name,url','categories:id','posttype'])->findOrfail($id);
        $page_keys = $this->pageKeys();
        $categories = Category::all();
        $postTypes = PostType::where('page_id', NULL)->get();
        return view('delgont::pages.edit', compact(['page', 'page_keys', 'categories', 'postTypes']));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'page_title' => 'required|unique:pages,page_title,'.$id,
            'page_key' => 'nullable|unique:pages,page_key,'.$id,
            'extract_text' => 'nullable|min:3|max:200',
            'page_featured_image' => 'nullable|mimes:jpeg,png,jpg|max:2048'
        ]);

       $page = Page::with(['icon:id,name,url','categories:id','posttype'])->findOrfail($id);


        $page->page_title = $request->page_title;
        $page->extract_text = $request->extract_text;
        $page->page_content = (is_array($request->page_content)) ? json_encode($request->page_content) : $request->page_content;
        $page->updated_by = auth()->user()->id;

        //dertermine if request has file
        ($request->hasFile('page_featured_image'))
        ? $page->page_featured_image = 'storage/'.request()->page_featured_image->store(config('delgont.media_dir', 'media/featuredimages'), 'public')
        : '';

        $page->save();

        if($page->posttype && $request->has('post_type_id')){
            if($request->post_type_id != $page->posttype->id){
                PostType::where('id', $page->posttype->id)->update(['page_id' => NULL]);
                PostType::where('id', $request->post_type_id)->update(['page_id' => $page->id]);
            }
        }else{
            if($request->has('post_type_id') && $request->post_type_id > 0){
                PostType::where('id', $request->post_type_id)->update(['page_id' => $page->id]);
            }
        }




        $page->categories()->sync($request->category);
        //check if request has icon
        if($request->hasFile('page_icon')){
            $page->icon()->updateOrCreate([
                'url' => 'storage/'.request()->page_icon->store(config('delgont.media_dir', 'media'), 'public')
            ]);
        }


        return ($request->expectsJson()) ? response()->json(['success' => true,'message' => 'Page Updated Successfully'], 200) : back()->withInput()->with('updated', 'Page Updated Successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Page::destroy($id);
        return (request()->expectsJson()) ? response()->json(['message' => 'Page deleted successfully']) : back()->with('deleted', 'Page deleted successfully');
    }


    public function menu()
    {
        $menus = Menu::with(['pages'])->get();
        $pages = Page::with(['menus'])->get();
        return response()->json(['pages' => $pages]);
    }

    private function pageKeys() : array
    {
        return config(config('delgont.web', 'web').'.pages', []);
    }

    private function postTypes() : array
    {
        return config(config('delgont.web', 'web').'.post_types', []);
    }

    /**
    * Publish Post
    *
    * @return \Illuminate\Http\Response
    */
    public function publish($id)
    {
        $this->pageService->publish($id);
        return (request()->expectsJson()) ? response()->json($id, 200) : back();
    }

    /**
    * UnPublish Post
    *
    * @return \Illuminate\Http\Response
    */
    public function unPublish($id)
    {
        $this->pageService->unPublish($id);
        return (request()->expectsJson()) ? response()->json($id, 200) : back();
    }

}
