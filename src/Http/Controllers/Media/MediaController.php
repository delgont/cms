<?php

namespace Stephendevs\Pagman\Http\Controllers\Media;

use Stephendevs\Pagman\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stephendevs\Pagman\Models\Media\Media;


class MediaController extends Controller
{
    public function index()
    {
        $media = Media::orderBy('created_at', 'desc')->paginate(12);
        return (request()->expectsJson()) ? response()->json($media) : view('pagman::media.index', compact(['media']));
    }

    public function store(Request $request)
    {
        $request->validate([
            'media' => 'required|mimes:jpeg,png,jpg|max:2048'
        ]);
        $media = new Media();
        $media->url = ($request->hasFile('media')) ? 'storage/'.request()->media->store(config('pagman.media_dir', 'media'), 'public') : null;
        $media->save();

        return (request()->expectsJson()) ? response()->json($media) : back()->withInput();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'description' => 'required'
        ]);
       $media = Media::findOrFail($id);
       $media->description = $request->description;
       $media->save();
       return ($request->expectsJson()) ? response()->json(['success' => true,'message' => 'Media Alt Text Updated Successfully'], 200) : back()->withInput()->with('updated', 'Media Alt Text Updated Successfully');
    }

    public function show($id)
    {
        $mediaItem = Media::findOrFail($id);
        return (request()->expectsJson()) ? response()->json($mediaItem) : view('pagman::media.show', compact(['mediaItem']));

    }

    public function destroy($id)
    {
        $media = Media::findOrFail($id);
        if(\File::exists($media->url)){
            \File::delete($media->url);
            $media->delete();
        }else{
            $media->delete();
        }
        return (request()->expectsJson()) ? response()->json(['success' => true]) : back();
    }

   

}
