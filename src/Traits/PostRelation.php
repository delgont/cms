<?php
namespace Stephendevs\Pagman\Traits;

trait PostRelation {

    public function author()
    {
        return $this->belongsTo('App\User');
    }
 
    public function updatedby()
    {
        return $this->belongsTo('App\User');
    }
 
}