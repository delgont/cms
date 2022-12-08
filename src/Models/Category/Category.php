<?php

namespace Delgont\Cms\Models\Category;


use Illuminate\Database\Eloquent\Model;
use Delgont\Cms\Models\Page\Page;
use Delgont\Cms\Models\Post\Post;
use Delgont\Cms\Models\Media\Media;
use Delgont\Cms\Models\Concerns\Iconable;




class Category extends Model
{
    use Iconable;
    
    protected $guarded = [];

    protected $casts = [
        'hidden' => 'boolean'
    ];

    public function scopePostCategories($query)
    {
        return $query->whereType(Post::class)->orWhereNull('type');
    }
    
    public function posts()
    {
        return $this->morphedByMany(Post::class, 'categorable');
    }

    public function pages()
    {        
        return $this->morphedByMany(Page::class, 'categorable');
    }

    public function media()
    {
        return $this->morphByMany(Media::class, 'mediable');
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->with('categories');
    }
  
}
