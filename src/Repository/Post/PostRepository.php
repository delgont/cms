<?php
namespace Delgont\Cms\Repository\Post;

use Delgont\Cms\Repository\Eloquent\BaseRepository;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

use Delgont\Cms\Models\Post\Post;
use Delgont\Cms\Models\Template\Template;
use Delgont\Cms\Models\Menu\Menu;
use Delgont\Cms\Models\Category\Category;

use Illuminate\Support\Facades\Cache;


class PostRepository extends BaseRepository
{

    protected $post;
    protected $template;

    public function __construct(Post $model){
        parent::__construct($model);
        $this->template = app(Template::class);
    }

    public function setPost(Post $model)
    {
        $this->post = $model;
    }

    public function setWith($with = [])
    {
        $this->with = $with;
    }

    public function getWith()
    {
        return $this->with ?? [];
    }

   

    /**
     * Gets the emplate for a post
     * 
     * @param string $key
     * @return Template
     */
    public function template(Post $postModel = null) 
    {
        //return $this->generateUnitCacheKey($this->template, $postModel->template_id);
        if(is_null($postModel) && is_null($this->post)){
            //Post model not set exception
            return null;
        }

        if($postModel){
            if ($this->fromCache) {
                $cached = $this->getModelFromCache($this->generateModelUnitCacheKey($this->template, $postModel->template_id), $this->template);
                if($cached){
                    return $cached;
                }else{
                    $template = ($postModel->template_id) ? Template::whereId($postModel->template_id)->first() : null;
                    ($postModel->template_id) ? $this->storeModelInCache($template, $postModel->template_id) : '';
                    return $template;
                }
            } 
            return ($postModel->template_id) ? Template::whereId($postModel->template_id)->first() : null;
        }

        if ($this->post) {
            if ($this->fromCache) {
                $cached = $this->getModelFromCache($this->getCachePrefix($this->template).':'.$this->post->template_id, $this->template);
                if($cached){
                   return $cached;
                }else{
                    $template = ($this->post->template_id) ? Template::whereId($this->post->template_id)->first() : null;
                    ($this->post->template_id) ? $this->storeModelInCache($template, $this->post->template_id) : '';
                    return $template;
                }
            } 
            return ($this->post->template_id) ? Template::whereId($this->post->template_id)->first() : null;
        }
        return null;
    }

    
    /**
     * Gets the template path for a post
     * 
     * @param Post $post
     * @return String
     */
    public function templatePath(Post $postModel = null) : ? string
    {
        if(is_null($postModel) && is_null($this->post)){
            //Post model not set exception
            return null;
        }

        if($postModel){

           if ($this->fromCache) {
                $cached = Cache::get($this->generateModelUnitCacheKey($this->template, 'path:'.$postModel->template_id));
                if($cached){
                    return $cached;
                }else{
                    $template = Template::whereId($postModel->template_id)->firstOrFail();
                    ($template) ? $this->storeInCache($template->path, $this->generateModelUnitCacheKey($this->template, 'path:'.$postModel->template_id)) : '';
                    return ($template) ? $template->path : null;
                }
            } else {
                $template = Template::whereId($postModel->template_id)->firstOrFail();
                return ($template) ? $template->path : null;
            }
        }

        if($this->post){
            if ($this->fromCache) {
                $cached = Cache::get($this->generateModelUnitCacheKey($this->template, 'path:'.$this->post->template_id));
                if($cached){
                    return $cached;
                }else{
                    $template = Template::whereId($this->post->template_id)->first();
                    ($template) ? $this->storeInCache($template->path, $this->generateModelUnitCacheKey($this->template, 'path:'.$this->post->template_id)) : '';
                    return ($template) ? $template->path : null;
                }
            } else {
                $template = Template::whereId($this->post->template_id)->firstOrFail();
                return ($template) ? $template->path : null;
            }
        }
        return null;
    }

    public function menu(Post $postModel = null) : ? Menu
    {
        return Menu::whereId($this->post->menu_id)->first();
    }

    public function parent($key) : ? Model
    {
        if($this->fromCache){
            $cached = Cache::get($this->cachePrefix.':parent'.$key);
            if($cached){
                $models = $this->model::hydrate([$cached]);
                return $model = $models[0] ?? null;
            }else{
                $parent = $this->model->where(($this->key) ? [$this->key => $key] : ['id' => $key])->firstOrFail()->parent;
                $this->storeModelInCache($parent, $this->cachePrefix.':parent:'.$key);
                return $parent;
            }
        }
        $parent = $this->model->where(($this->key) ? [$this->key => $key] : ['id' => $key])->firstOrFail()->parent;
        return $parent;

    }

    public function categories(Post $postModel = null)
    {
        $id = ($postModel) ? $postModel->id : $this->post->id;
        if ($this->fromCache) {
            $cached = Cache::get($this->getCachePrefix().':categories:'.$id);
            if ($cached) {
                return $cached;
            }else{
                $categories = Category::whereHas('categorables', function($query) use ($id){
                    $query->whereCategorableId($id);
                })->get();
                $this->storeCollectionInCache($categories, $this->getCachePrefix().':categories:'.$id);
                return $categories;
            }
        }
        $categories = Category::whereHas('categorables', function($query) use ($id){
            $query->whereCategorableId($id);
        })->get();
        return $categories;
    }

    public function children(Post $postModel = null, array $attributes = ['*'], $relations = []) : ? LengthAwarePaginator
    {
        if ($this->post) {
            return $this->post->children((count($relations) > 0) ? $relations : $this->with)->paginate(6, $attributes);
        }
        return $this->model;
    }
    
    /**
     * Get posts of a specific type
     * 
     * @param mixed $type
     * @param array $attributes
     * @param array $relations
     * @return Object LengthAwarePaginator
     */
    public function ofType($type = null, array $attributes = ['*'], $relations = []) : ? LengthAwarePaginator
    {
        if ($type) {
            return $this->model->with((count($relations) > 0) ? $relations : $this->with)->ofTYpe($type)->get($attributes);
        }
        if ($this->post) {
            if ($this->post->postsOfType) {
                return ($this->post->postsOfType->post_type_id) ? $this->model->with((count($relations) > 0) ? $relations : $this->with)->ofTYpe($this->post->postsOfType->post_type_id)->paginate(4, $attributes) : null;
            }
        }
        return null;
    }

   
}