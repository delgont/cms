<?php
namespace Delgont\Cms\Repository\Group;

use Delgont\Cms\Repository\Eloquent\BaseRepository;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;


//Models
use Delgont\Cms\Models\Group\Group;

//Facades
use Illuminate\Support\Facades\Cache;


class GroupRepository extends BaseRepository
{

    public function __construct(Group $model){
        parent::__construct($model);
    }
   
}