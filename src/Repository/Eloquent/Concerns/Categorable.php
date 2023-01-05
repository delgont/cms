<?php
namespace Delgont\Cms\Repository\Eloquent\Concerns;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Builder;

//Models
use Delgont\Cms\Models\Category\Category;


/**
 * Trait for model repositories that are categorable
 * 
 * @see Delgont\Cms\Models\Category\Categorable
 */
trait Categorable
{
    public function categories($categorable)
    {
        if($this->paginated){
            return $this->getPaginatedModelCategories($categorable);
        }
        return $this->getModelCategories($categorable);
    }

    /**
     * Get Paginated categories to which model belongs to
     * 
     * @param Model $categorable
     * 
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    private function getPaginatedModelCategories(Model $categorable) : ? LengthAwarePaginator
    {
        if($this->fromCache){
            $cached = Cache::get( $this->getCachePrefix().':categories:'.$categorable->id.':offset:'.$this->offset );
            if ($cached) {
                # Get the cached categories to which the model belongs to
                return $cached;
            } else {
                # code...
                $categories = $categorable->categories()->paginate( $this->perPage );
                ($categories) ? $this->storeLengthAwarePaginatorInCache( $categories, $this->getCachePrefix().':categories:'.$categorable->id.':offset:'.$this->offset ) : '';
                return $categories;
            }
            
        }
        return $categorable->categories()->paginate($this->perPage);
    }

     /**
     * Get categories to which model belongs to
     * 
     * @param Model $categorable
     * 
     * @return Illuminate\Database\Eloquent\Collection
     */
    private function getModelCategories( Model $categorable ): ? Collection
    {
        if($this->fromCache){
            $cached = Cache::get( $this->getCachePrefix().':categories:'.$categorable->id );
            if ($cached) {
                # Get the cached categories to which the model belongs to
                return $cached;
            } else {
                # code...
                $categories = $categorable->categories()->get();
                ($categories) ? $this->storeCollectionInCache( $categories, $this->getCachePrefix().':categories:'.$categorable->id ) : '';
                return $categories;
            }
            
        }
        return $categorable->categories()->get();
    }
    

}