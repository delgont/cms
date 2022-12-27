<?php
namespace Delgont\Cms\Repository\Template;

use Delgont\Cms\Repository\Eloquent\BaseRepository;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

use Delgont\Cms\Models\Template\Template;

use Illuminate\Support\Facades\Cache;


class TemplateRepository extends BaseRepository
{

    public function __construct(Template $model){
        parent::__construct($model);
    }


    public function storePathInCache($payLoad) : ? bool
    {
        if ($payLoad instanceof $this->model) {
            return $this->storeInCache($payLoad->path, $this->getCachePrefix($this->model).':path:'.$payLoad->id);
        }
        if (is_array($payLoad) && count($payLoad) > 0) {
            return $this->storeInCache($payLoad['path'], $this->getCachePrefix($this->model).':path:'.$payLoad['id']);
        }
        return false;
    }
   
}