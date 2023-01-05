<?php
namespace Delgont\Cms\Repository\Option;

use Delgont\Cms\Repository\Eloquent\BaseRepository;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

use Delgont\Cms\Models\Option\Option;

use Illuminate\Support\Facades\Cache;


class OptionRepository extends BaseRepository
{
    public function __construct(Option $model){
        parent::__construct($model);
    }

    /**
     * Gets option value
     * @return string
     */
    public function value($option_key, $default = null) : ? string
    {
        if ($this->fromCache) {
            $cached = Cache::get($this->getCachePrefix().':value:'.$option_key);
            if ($cached) {
                return $cached;
            } else {
                $option = $this->model->whereOptionKey($option_key)->first();
                if ($option) {
                    $this->writeToCache($this->getCachePrefix().':value:'.$option_key, $option->value());
                } else {
                    return $default;
                }
            }
        }
        $option = $this->model->whereOptionKey($option_key)->first();
        return ($option) ? $option->value() : $default;
    }
    
}