<?php

namespace Delgont\Cms\Models\Option;

use Illuminate\Database\Eloquent\Model;

class ModelOption extends Model
{
    protected $guarded = [];


    public function getValueAttribute($value)
    {
        return $value;
    }



}
