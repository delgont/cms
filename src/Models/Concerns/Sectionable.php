<?php
namespace Delgont\Cms\Models\Concerns;

use Delgont\Cms\Models\Section\Section;

trait Sectionable {

    public function sections()
    {
        return $this->morphToMany(Section::class, 'sectionable');
    }

}