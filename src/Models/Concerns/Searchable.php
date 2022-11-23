<?php

namespace Delgont\Cms\Models\Concerns;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Builder;

trait Searchable
{

    public function scopeSearch($query, $searchTerm, $attributes = [])
    {
        $searchAttributes = (count($attributes) > 0) ? $attributes : $this->searchableAttributes();

        return $query->where(function (Builder $query) use ($searchAttributes, $searchTerm) {
            foreach (Arr::wrap($searchAttributes) as $attribute) {
                $query->when(
                    str_contains($attribute, '.'),
                    function (Builder $query) use ($attribute, $searchTerm) {
                        [$relationName, $relationAttribute] = explode('.', $attribute);

                        $query->orWhereHas($relationName, function (Builder $query) use ($relationAttribute, $searchTerm) {
                            $query->where($relationAttribute, 'LIKE', '%'.$searchTerm.'%');
                        });
                    },
                    function (Builder $query) use ($attribute, $searchTerm) {
                        $query->orWhere($attribute, 'LIKE', '%'.$searchTerm.'%');
                    }
                );
            }
        });
    }

    /**
     * Get searchable columns
     *
     * @return array
     */
    public function searchableAttributes()
    {
        if(method_exists($this, 'searchable')){
            return $this->searchable();
        }

        return property_exists($this, 'searchable') ? $this->searchable : [];
    }

}