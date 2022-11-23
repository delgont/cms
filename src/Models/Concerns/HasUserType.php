<?php
namespace Delgont\Cms\Models\Concerns;

trait HasUserType {



    public function userable()
    {
        return $this->morphTo();
    }

    public function scopeWithUserable($query)
    {
        return $query->with(['userable']);
    }

    public function getTypeAttribute()
    {
        $type = explode('\\', $this->userable_type);
        return end($type);
    }


}