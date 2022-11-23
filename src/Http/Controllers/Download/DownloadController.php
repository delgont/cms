<?php

namespace Delgont\Cms\Http\Controllers\Download;

use Delgont\Cms\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use File;

use Delgont\Cms\Models\Download\Download;
use Delgont\Cms\Models\Category\Category;


class DownloadController extends Controller
{
    
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $downloads = Download::orderBy('created_at', 'desc')->paginate(6);
        $categories = Category::all();

        return (request()->expectsJson()) ? response()->json($downloads) : view('delgont::downloads.index', compact(['downloads','categories']));
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
        'download' => 'required|mimes:pdf,xlx,csv,jpeg,png,jpg,gif,svg,mp3,mp4,zip,doc,docx|max:2048',
        'icon' => 'nullable|mimes:jpeg,jpg,png|max:2048',
        'description' => 'nullable|min:3|max:50'
       ]);

       $download = new Download();

       $download->url = ($request->hasFile('download')) ? 'storage/'.request()->download->store(config('delgont.media_dir', 'downloadables'), 'public') : null;
       $download->mime_type = $request->download->getClientMimeType();
       $download->description = $request->description;
       $download->save();

       if($request->hasFile('icon')){
        $download->icon()->create([
            'icon' => 'storage/'.request()->icon->store(config('delgont.media_dir', 'icons'), 'public')
           ]);
       }
       $download->categories()->sync($request->category);


       return ($request->expectsJson()) ? response()->json(['success' => true,'message' => 'Download Uploaded Successfully',], 200) : back()->withInput()->with('created', 'Download Uploaded Successfully');
    }

    public function show($id)
    {
        $download = Download::with(['posts'])->findOrFail($id);
        return (request()->expectsJson()) ? response()->json($download) : view('delgont::downloads.show', compact(['download']));
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

        $download = Download::findOrFail($id);
        if(File::exists(public_path($download->url))){
            File::delete(public_path($download->url));
            $download->delete();
        }else{
            dd('File does not exists.');
        }

        return (request()->expectsJson()) ? response()->json(['success' => true, 'message' => 'Download Deleted Successfully']) : back()->with('deleted', 'Download deleted successfully');
    }

    public function download($id)
    {
        $download = Download::findOrFail($id);

        return Response::download($download->url);

    }


}
