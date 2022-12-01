<?php
namespace Delgont\Cms\Models\Concerns;

use Delgont\Cms\Models\Category\Category;

trait Categorable {

    public function categories()
    {
        return $this->morphToMany(Category::class, 'categorable')->Where('type', self::class);
    }

    /**
     * Local Scope to get models of a specific category
     * 
     * @param $query
     * @param string $category
     * @return Object
     */
    public function scopeOfCategory($query, $category) : Object
    {
        return $query->whereHas('categories', function($categoryQuery) use ($category){
            (is_array($category)) ? $categoryQuery->where($category) : $categoryQuery->whereName($category)->orWhere('id', $category);;
        });
    }

}