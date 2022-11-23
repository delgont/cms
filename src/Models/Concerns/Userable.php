<?php
namespace Delgont\Cms\Models\Concerns;

trait Userable {

    public function user()
    {
        return $this->morphOne('App\User', 'userable');
    }

    public function scopeWithUser($query)
    {
        return $query->with(['user']);
    }
}