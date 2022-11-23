<?php
namespace Delgont\Cms\Models\Concerns;

use Delgont\Cms\Models\Download\Download;

trait HasDownloadables {

    public function downloadables()
    {
        return $this->morphToMany(Download::class, 'attachedto', 'downloadables');
    }

}