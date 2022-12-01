<?php
namespace Delgont\Cms\Models\Concerns;

use Delgont\Cms\Models\Option\ModelOption;

trait HasOptions {

    public function options()
    {
        return $this->morphMany(ModelOption::class, 'model');
    }

    public function scopeWithOptions($query, $options = null)
    {
        if (!is_null($options)) {
            if (is_string($options)) {
                return $query
                ->with(['options' => function($q) use ($options){
                    $q->where('key', $options);
                }]);
            }
            if (is_array($options)) {
                return $query
                ->with(['options' => function($q) use ($options) {
                    $q->whereIn('key', $options);
                }]);
            }
        }
        return $query->with('options');
    }
    
}