<?php

namespace Delgont\Cms\Models\Post;


use Illuminate\Database\Eloquent\Model;
use Delgont\Cms\Models\Concerns\Categorable;
use Delgont\Cms\Models\Concerns\Iconable;
use Delgont\Cms\Models\Concerns\Downloadable;
use Delgont\Cms\Models\Concerns\HasAuthor;
use Delgont\Cms\Models\Concerns\UpdatedBy;
use Delgont\Cms\Models\Concerns\HasComments;
use Delgont\Cms\Models\Concerns\HasPostsOfType;

use Delgont\Cms\Models\Concerns\HasLinks;

use Delgont\Cms\Models\Concerns\Searchable;

use Illuminate\Database\Eloquent\SoftDeletes;

use Delgont\Cms\Models\Post\PostType;

use Delgont\Cms\Models\Category\Category;
use Delgont\Cms\Models\Template\Template;
use Delgont\Cms\Models\Menu\Menu;

use Illuminate\Database\Eloquent\Concerns\HasEvents;


class Post extends Model
{
    use Categorable, Iconable, HasAuthor, UpdatedBy, SoftDeletes, HasComments, HasPostsOfType, Searchable, HasLinks, HasEvents;


    protected $fillable = [
        'post_key', 'post_type', 'post_title', 'post_content', 'post_featured_image', 'extract_text', 'slug', 'post_type_id', 'template_id'
    ];

    protected $searchable = ['post_title', 'extract_text', 'posttype.name'];

    protected $appends = ['url'];


    public function scopePages($query)
    {
        return $query->whereType('2');
    }

    public function getPublisedAttribute($value)
    {
        return bool($value);
    }

    /**
     * Local Scope to get posts of specific type
     * 
     * @param $query
     * @param string $type
     * @reurn Object
     */
    public function scopeOfType($query, $type) : object
    {
        return $query->whereHas('posttype', function($typeQuery) use($type){
            (is_array($type)) ? $typeQuery->where($type) : $typeQuery->whereName($type)->orWhere('id', $type);
        });
    }

    /**
     * Local Scope to get published posts
     * 
     * @param $query
     * @return Object
     */
    public function scopePublished($query) : object
    {
        return $query->wherePublished('1');
    }

    /**
     * Local Scope to get un published posts
     * 
     * @param $query
     * @return Object
     */
    public function scopeUnPublished($query) : object
    {
        return $query->wherePublished('0');
    }

    /**
     * Local Scope to get commentable posts
     * 
     * @param $query
     * @return Object
     */
    public function scopeCommentable($query) : object
    {
        return $query->whereCommentable('1');
    }

    /**
     * Each posts belongs to one type
     */
    public function posttype()
    {
        return $this->belongsTo(PostType::class, 'post_type_id');
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Post::class);
    }

    public function pagePosts()
    {
        return $this->hasMany(Post::class, 'parent_id');
    }



    public function children(array $relations = [])
    {
        return $this->hasMany(Post::class, 'parent_id')->with($relations);
    }

    public function setSlugAttribute($value)
    {
        return $this->attributes['slug'] = str_replace(' ', '-', $value);
    }

    public function getPostTitleAttribute($value)
    {
        return title_case($value);
    }

    public function getTypeAttribute()
    {
        if ($this->attribute['type'] == '2') {
            return 'page';
        }
        return 'post';
    }

    public function getUrlAttribute()
    {
        if ($this->slug) {
            return url($this->slug);
        }
        return null;
    }
   
  
}
