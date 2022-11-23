<?php
namespace Delgont\Cms\Models\Concerns;

use Delgont\Cms\Models\Media\Media;

trait Mediable {
    
    public function media()
    {
        return $this->morphToMany(Media::class, 'mediable');
    }

}