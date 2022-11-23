<?php

namespace Stephendevs\Pagman\Models\Navbar;

use Illuminate\Database\Eloquent\Model;

class Navbar extends Model
{


    public function menu()
    {
        return $this->hasOne('\Stephendevs\Pagman\Models\Navbar\Menu');
    }
}
