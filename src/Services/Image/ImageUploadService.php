<?php

namespace Delgont\Cms\Services\Image;


class ImageUploadService
{
    public function upload($image, $dir = null) : string
    {
        return (is_null($dir)) ? 'storage/'.$image->store(config('delgont.media_dir', 'media'), 'public') : $image->store($dir, 'public');
    }
}