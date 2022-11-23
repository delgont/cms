<?php
namespace Delgont\Cms\Models\Concerns;

use Delgont\Cms\Models\Icon\Icon;

trait Iconable {

    public function icon()
    {
        return $this->morphOne(Icon::class, 'iconable');
    }
    
}