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

    /**
     * Store template path in cache
     * @param mixed $payload
     */
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

    /**
     * Get Template Path
     * 
     * @param int $id
     * @return string
     */
    public function getTemplatePath( $id ) : ? string
    {
        if ($this->fromCache) {
            //Get template path from cache
            $cached = Cache::get($this->getCachePrefix().':path:'.$id);
            if ($cached) {
                # code...
                return $cached;
            }else{
                $model = $this->model->whereId($id)->first();
                ($model) ? $this->storePathInCache($model) : '';
                return ($model) ? $model->path : null;
            }
        }
        $model = $this->model->whereId($id)->first();
        return ($model) ? $model->path : null;
    }
   
}