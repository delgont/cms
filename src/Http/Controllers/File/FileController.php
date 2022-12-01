<?php

namespace Delgont\Cms\Http\Controllers\File;

use Delgont\Cms\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

use Delgont\Cms\Models\File\File;
use Delgont\Cms\Models\Group\Group;
use Delgont\Cms\Models\Category\Category;

use Delgont\Cms\Support\Image\Image;

use Delgont\Cms\FileRegistrar;

class FileController extends Controller
{
    
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $files =  File::orderBy('created_at', 'desc')->paginate(6);
        $groups = Group::where('type', File::class)->get();
        $categories = Category::where('type', File::class)->get();
        //return response()->json($files);
        return (request()->expectsJson()) ? response()->json($files) : view('delgont::files.index', compact(['files', 'groups', 'categories']));
    }
     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return 'not yet';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $request->validate([
        'file' => 'required|mimes:pdf,xlx,csv,jpeg,png,jpg,gif,svg,mp3,mp4,zip,doc,docx|max:2048',
        'icon' => 'nullable|mimes:jpeg,jpg,png|max:2048',
        'description' => 'nullable|min:3|max:50'
       ]);

       $file = new File();

       $file->url = ($request->hasFile('file')) ? 'storage/'.request()->file->store(config('delgont.media_dir', 'downloadables'), 'public') : null;
       $file->mime_type = $request->file->getClientMimeType();
       $file->description = $request->description;
       $file->save();

       if($request->hasFile('icon')){
        $file->icon()->create([
            'url' => 'storage/'.request()->icon->store(config('delgont.media_dir', 'icons'), 'public')
           ]);
       }
       $file->categories()->sync($request->category);


       return ($request->expectsJson()) ? response()->json(['success' => true,'message' => 'Download Uploaded Successfully',], 200) : back()->withInput()->with('created', 'Download Uploaded Successfully');
    }

    public function show($id)
    {
        $file = File::findOrFail($id);
        //return response()->json($file);
        return (request()->expectsJson()) ? response()->json($file) : view('delgont::files.show', compact(['file']));
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
    }

    public function update(Request $request, $id)
    {
       
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $file = File::destroy($id);

        return (request()->expectsJson()) ? response()->json(['success' => true, 'message' => 'Download Deleted Successfully']) : back()->with('deleted', 'Download deleted successfully');
    }

    public function search($query)
    {
        $files = File::search($query)->paginate(6);
        //return response()->json($files);
        return (request()->expectsJson()) ? response()->json($files) : view('delgont::files.index', compact(['files']));
    }

    public function ofCategory($category)
    {
        $files = File::ofCategory($category)->paginate(6);
        $groups = Group::where('type', File::class)->get();
        $categories = Category::where('type', File::class)->get();
        //return response()->json($files);
        return (request()->expectsJson()) ? response()->json($files) : view('delgont::files.index', compact(['files', 'groups', 'categories']));
    }

    public function ofGroup($group)
    {
        $files = File::ofGroup($group)->paginate(6);
        $groups = Group::where('type', File::class)->get();
        $categories = Category::where('type', File::class)->get();
        //return response()->json($files);
        return (request()->expectsJson()) ? response()->json($files) : view('delgont::files.index', compact(['files', 'groups', 'categories' ]));
    }

}
