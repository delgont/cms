<?php

namespace Delgont\Cms\Models\Option;

use Illuminate\Database\Eloquent\Model;

class ModelOption extends Model
{
    protected $guarded = [];


    public function getValueAttribute($value)
    {
        //return $this->attributes['cast'];

        if($this->attributes['cast'] != null){
            switch ($this->attributes['cast']) {
                case 'array':
                    return json_decode($value);
                    break;
                
                default:
                    return $value;
                    break;
            }
        }
        return $value;
    }


}
