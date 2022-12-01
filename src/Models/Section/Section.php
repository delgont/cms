<?php

namespace Delgont\Cms\Models\Section;


use Illuminate\Database\Eloquent\Model;


use Delgont\Cms\Models\Concerns;

class Section extends Model
{
    use Concerns\Searchable,
        Concerns\Categorable,
        Concerns\Groupable,
        Concerns\HasOptions,
        Concerns\Iconable,
        Concerns\HasOptions;

    protected $fillable = ['name', 'path', 'preview'];
    
}
