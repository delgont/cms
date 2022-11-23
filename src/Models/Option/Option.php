<?php

namespace Delgont\Cms\Models\Option;

use Illuminate\Database\Eloquent\Model;
use Delgont\Cms\Models\Concerns\Iconable;


class Option extends Model
{
    use Iconable;
    
    protected $table = 'options';

    protected $fillable = ['option_key', 'option_value'];

   /**
    * Local Scope - Disabled 
    */
    public function scopeDisbled($query)
    {
        return $query->whereDisabled('1');
    }

}
