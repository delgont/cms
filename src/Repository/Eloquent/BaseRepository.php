<?php
namespace Delgont\Cms\Repository\Eloquent;

use Delgont\Cms\Repository\Eloquent\Contracts\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Builder;

use Delgont\Cms\Cache\Concerns\HandlesModelCaching;


class BaseRepository implements EloquentRepositoryInterface
{
    use HandlesModelCaching;
     

    /**
     * Indicates wheather to get data from the cache storage
     *
     * @var bool
     */
    protected $fromCache = false;
    
    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [];


    protected $pagination = 6;

    protected $remember = false;
    protected $cache = false;
    protected $cacheDuration = null;
    protected $cacheKey = null;

    public function __construct( Model $model)
    {
        $this->model = $model;
        $this->cachePrefix = get_class($this->model);
    }

    public function fromCache( )
    {
        $this->fromCache = true;
        return $this;
    }

    public function remember( )
    {
        $this->remember = true;
        return $this;
    }

    public function cache( )
    {
        $this->cache = true;
        return $this;
    }


    public function all(array $attributes = ['*'], array $relations = []) : Collection
    {
        if ($this->fromCache) {
            $cached = Cache::get( $this->cachePrefix );
            if ($cached) {
                return $cached;
            } else {
                $collection = $this->load( $attributes, $relations )->orderBy('created_at', 'desc')->get();
                $this->storeCollectionInCache($collection, $this->cachePrefix);
                return $collection;
            }
        }
        return $this->load( $attributes, $relations )->get();
    }

    public function paginate(array $attributes = ['*'], array $relations = []) : LengthAwarePaginator
    {
        $collection = $this->load( $attributes, $relations )->orderBy('updated_at', 'desc')->paginate($this->pagination);
        return $collection;
    }

    public function find($id, array $attributes = ['*'], $relations = []) : ? Model
    {
        if($this->fromCache){
            $cached = Cache::get( $this->getCachePrefix().':'.$id );
            if( $cached ) {
                $models = $this->model::hydrate([$cached]);
                return $model = $models[0] ?? null;
            }else{
                $model = $this->load($attributes, $relations)->where(($this->key) ? [$this->key => $id] : ['id' => $id])->firstOrFail();
                $this->storeModelInCache($model);
                return $model;
            }
        }
        if($this->remember){
            $model = $this->load($attributes, $relations)->where(($this->key) ? [$this->key => $id] : ['id' => $id])->firstOrFail();
            $this->storeModelInCache($model);
            return $model;
        }
        return $this->load($attributes, $relations)->where(($this->key) ? [$this->key => $id] : ['id' => $id])->firstOrFail();
    }

    public function create(array $payload) : ? Model
    {
        $model = new $this->model;

        if (count($payload) > 0) {
            foreach ($payload as $key => $value) {
                $model->$key = $value;
            }
            $model->save();
            return $model;
        }
        return null;
    }

    public function update($id, array $payload) : ? bool
    {
        $model = $this->model::findOrFail($id);
        if (count($payload) > 0) {
            foreach ($payload as $key => $value) {
                $model->$key = $value;
            }
            $model->save();
            return true;
        }
        return false;
        //return $this->model->whereId($id)->update($payload);
    }

    
    public function save ( Model $model ) : bool {
        if($this->cache){
            if ( $model->save() ) {
                $this->storeModelInCache( $model );
                return true;
            }
        }

        if ( $model->save() ) {
            //$this->storeModelInCache( $model );
            return true;
        }
        return false;   
    }

    public function delete ( Model $model ) : bool {

        if ( $this->fromCache ) {
            //deleted from cache
            return true;
        }
        else if ( $model->delete() ) {
            return true;
        }

        return false;
    }


  

    protected function storeInCache($value, $key)
    {
        return $this->writeToCache( $key, $value );
    }

    public function generateUnitCacheKey ( Model $model, $key = null ) : string 
    {
        if ($model instanceof $this->model) {
            return ($this->key) ? $this->cachePrefix.':'.$model->getAttribute($this->key) : $this->cachePrefix.':'.$model->getKey();
        }
        return $this->cachePrefix($model).':'.$key;
    }

    
    private function load( array $attributes = ['*'], array $relations = [] ) : ? Builder
    {
        return $this->model->select( $attributes )->with( $relations );
    }
   
}