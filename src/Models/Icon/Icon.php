<?php

namespace Delgont\Cms\Models\Icon;


use Illuminate\Database\Eloquent\Model;



class Icon extends Model
{
    protected $guarded = [];

   public function iconable()
   {
       return $this->morphT();
   }
  
}
