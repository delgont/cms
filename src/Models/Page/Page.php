<?php

namespace Delgont\Cms\Models\Page;


use Illuminate\Database\Eloquent\Model;

use Delgont\Cms\Models\Concerns\HasAuthor;
use Delgont\Cms\Models\Concerns\UpdatedBY;
use Delgont\Cms\Models\Concerns\Categorable;
use Delgont\Cms\Models\Concerns\Iconable;
use Delgont\Cms\Models\Concerns\Mediable;
use Illuminate\Database\Eloquent\SoftDeletes;

use Delgont\Cms\Models\Post\Post;
use Delgont\Cms\Models\Post\PostType;

class Page extends Model
{
    use HasAuthor, UpdatedBY, Categorable, Iconable, Mediable, SoftDeletes;

    protected $guarded = [];

    protected $with = ['author:id,name', 'updatedBy:id,name'];

    /**
     * Local Scope to get published Pages
     * 
     * @param $query
     * @return Object
     */
    public function scopePublished($query) : object
    {
        return $query->wherePublished('1');
    }

    /**
     * Local Scope to get un published Pages
     * 
     * @param $query
     * @return Object
     */
    public function scopeUnPublished($query) : object
    {
        return $query->wherePublished('0');
    }

    public function scopeCommentable($query)
    {
        return $query->whereCommentable('1');
    }

    /**
     * Local Scope to get Pages of a specific category
     * 
     * @param $query
     * @param string $category
     * @return Object
     */
    public function scopeOfCategory($query, $category) : Object
    {
        return $query->whereHas('categories', function($categoryQuery) use ($category){
            $categoryQuery->whereName($category);
        });
    }

    public function scopeParent($query)
    {
        return $query->whereNull('parent_id');
    }


    public function posts()
    {
        return $this->hasManyThrough(Post::class, PostType::class);
    }

    public function posttype()
    {
        return $this->hasOne(PostType::class);
    }

}
