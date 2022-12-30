<?php

namespace Delgont\Cms\Models\Category;


use Illuminate\Database\Eloquent\Model;
use Delgont\Cms\Models\Page\Page;
use Delgont\Cms\Models\Post\Post;
use Delgont\Cms\Models\Media\Media;
use Delgont\Cms\Models\Concerns\Iconable;
use Delgont\Cms\Models\Category\Categorable;




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

    public function categorables()
    {
        return $this->hasMany(Categorable::class);
    }

    public function scopeHidden($query)
    {
        return $query->where('hidden', '1');
    }

    public function hide()
    {
        $this->{$this->getTable().'.'.'hidden'} = '1';
        $this->save();
    }

    public function unHide()
    {
        $this->{$this->getTable().'.'.'hidden'} = '0';
        $this->save();
    }

    public function hidden() : ? bool
    {
        return ($this->{$this->getTable().'.'.'hidden'}) ? true : false;
    }
    
  
}
