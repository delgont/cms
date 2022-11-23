<?php
namespace Delgont\Cms\Models\Concerns;

use Delgont\Cms\Models\Option\Option;

trait HasOptions {

    public function options()
    {
        return $this->hasMany(Option::class, 'group_id');
    }
    
}