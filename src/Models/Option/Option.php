<?php

namespace Delgont\Cms\Models\Option;

use Illuminate\Database\Eloquent\Model;

//Model Traits
use Delgont\Cms\Models\Concerns\Iconable;
use Delgont\Cms\Models\Concerns\Categorable;
use Delgont\Cms\Models\Concerns\Groupable;



class Option extends Model
{
    use Iconable, Categorable, Groupable;
    
    protected $table = 'options';

    protected $fillable = ['option_key', 'option_value'];

   /**
    * Get disabled options
    */
    public function scopeDisbled($query)
    {
        return $query->whereDisabled('1');
    }

    /**
     * Set or Set and Get the option value
     */
    public function value($value = null) : ? string
    {
        if ($value) {
            $this->{$this->getTable().'.'.'option_value'} = $value;
            $this->save();
            return $value;
        }
        return $this->{'option_value'};
    }

}
