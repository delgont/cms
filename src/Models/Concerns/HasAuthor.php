<?php
namespace Delgont\Cms\Models\Concerns;

trait HasAuthor {

    public function author()
    {
        return $this->belongsTo('App\User', 'created_by');
    }
}