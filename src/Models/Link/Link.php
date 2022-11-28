<?php

namespace Delgont\Cms\Models\Link;

use Delgont\Cms\Models\Concerns\Iconable;
use Delgont\Cms\Models\Concerns\Categorable;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
   use Iconable, Categorable;
  
}
