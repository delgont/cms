<?php

namespace Delgont\Cms\Models\Template;


use Illuminate\Database\Eloquent\Model;


use Delgont\Cms\Models\Post\Post;

use Delgont\Cms\Models\Concerns;


class Template extends Model
{
    use Concerns\Sectionable,
        Concerns\Searchable,
        Concerns\Categorable,
        Concerns\Groupable,
        Concerns\HasOptions,
        Concerns\Iconable,
        Concerns\HasOptions;



    protected $fillable = ['name', 'path', 'preview'];

    protected $with = ['sections'];

    public function scopeEnabled($query)
    {
        return $query->whereDisabled('0');
    }

    public function scopeDisabled($query)
    {
        return $query->whereDisabled('1');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

}
