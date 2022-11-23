<?php
namespace Delgont\Cms\Models\Concerns;

trait UpdatedBy {

    public function updatedBy()
    {
        return $this->belongsTo('App\User', 'updated_by');
    }
}