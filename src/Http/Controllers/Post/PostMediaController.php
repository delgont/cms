<?php

namespace Stephendevs\Pagman\Http\Controllers\Post;

use Stephendevs\Pagman\Http\Controllers\Controller;
use Illuminate\Http\Request;

use  Stephendevs\Pagman\Models\Post\Post;
use  Stephendevs\Pagman\Models\Media\Media;


class PostMediaController extends Controller
{

    public function add($media_id, $post_id)
    {
        $post = Post::findOrFail($post_id);
        $media = Media::findOrFail($media_id);

        $post->media()->attach([$media->id]);

        return response()->json(['success' => true, 'message' => 'Media attached to post successfully']);
        
    }

}
