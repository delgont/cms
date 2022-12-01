<?php

namespace Delgont\Cms\Support\Image;

class Image
{
    
    public function __construct(string $pathToImage)
    {
    }

    public static function load(string $pathToImage)
    {
        return new static($pathToImage);
    }

    public function getWidth(): int
    {
        //return InterventionImage::make($this->pathToImage)->width();
        return '2';
    }

}
