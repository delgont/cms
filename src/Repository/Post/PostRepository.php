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

//Repository Concerns
use Delgont\Cms\Repository\Eloquent\Concerns\Categorable;

class PostRepository extends BaseRepository
{
    use Categorable;

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
     * Gets the template for a post
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
                    $template = Template::whereId($postModel->template_id)->first();
                    ($template) ? $this->storeInCache($template->path, $this->generateModelUnitCacheKey($this->template, 'path:'.$postModel->template_id)) : '';
                    return ($template) ? $template->path : null;
                }
            } else {
                $template = Template::whereId($postModel->template_id)->first();
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
                $template = Template::whereId($this->post->template_id)->first();
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
            $cached = Cache::get($this->getCachePrefix().':parent:'.$key);
            if($cached){
                $models = $this->model::hydrate([$cached]);
                return $model = $models[0] ?? null;
            }else{
                $parent = $this->model->where(($this->key) ? [$this->key => $key] : ['id' => $key])->firstOrFail()->parent;
                $this->storeModelInCache($parent, $this->getCachePrefix().':parent:'.$key);
                return $parent;
            }
        }
        $parent = $this->model->where(($this->key) ? [$this->key => $key] : ['id' => $key])->firstOrFail()->parent;
        return $parent;

    }

    public function children(Post $postModel = null, $offset = 1, $pagination = 3, array $attributes = ['*'], $relations = []) : ? LengthAwarePaginator
    {
        //return $this->generateModelUnitCacheKey($this->model, $this->post->id.':children:'.'1');
        if ($this->post) {
            if ($this->fromCache) {
                $cached = Cache::get($this->generateModelUnitCacheKey($this->model, $this->post->id.':children:offset:'.$offset));
                if ($cached) {
                    return $cached;
                } else {
                    $children = $this->post->children((count($relations) > 0) ? $relations : $this->with)->orderBy('created_at', 'desc')->paginate($pagination, $attributes, 'page', $offset);
                    $this->storeLengthAwarePaginatorInCache($children, $this->generateModelUnitCacheKey($this->model, $this->post->id.':children:offset:'.$offset));
                    return $children;
                }
            }
        }
        return null;
    }

    public function getChildren(Post $model = null, array $attributes = ['*'], $relations = []) 
    {
        if($this->paginated){
            return $this->getPaginatedChildren($model);
        }
        if ($this->fromCache) {
            $cached = Cache::get( $this->generateModelUnitCacheKey($this->model, $model->id.':children') );
            if ($cached) {
                return $cached;
            } else {
                $children = $model->children((count($relations) > 0) ? $relations : $this->with)->orderBy('created_at', 'desc')->get();
                $this->storeCollectionInCache($children, $this->generateModelUnitCacheKey($this->model, $model->id.':children') );
                return $children;
            }
        }
        return $children = $model->children((count($relations) > 0) ? $relations : $this->with)->orderBy('created_at', 'desc')->get();
    }

    public function getPaginatedChildren(Post $model = null, array $attributes = ['*'], $relations = []) 
    {
        if ($this->fromCache) {
            $cached = Cache::get( $this->generateModelUnitCacheKey($this->model, $model->id.':children:offset:'.$this->offset) );
            if ($cached) {
                return $cached;
            } else {
                $children = $model->children((count($relations) > 0) ? $relations : $this->with)->orderBy('created_at', 'desc')->paginate( $this->perPage );
                $this->storeLengthAwarePaginatorInCache($children, $this->generateModelUnitCacheKey($this->model, $model->id.':children:offset:'.$this->offset) );
                return $children;
            }
        }
        return $children = $model->children((count($relations) > 0) ? $relations : $this->with)->orderBy('created_at', 'desc')->paginate( $this->perPage );
    }
    
    /**
     * Get posts of a specific type
     * 
     * @param mixed $type
     * @param array $attributes
     * @param array $relations
     * @return Object LengthAwarePaginator
     */
    public function ofType($type = null, $offset = 1, $pagination = 3, array $attributes = ['*'], $relations = []) : ? LengthAwarePaginator
    {
        if ($type) {
            return $this->model->with((count($relations) > 0) ? $relations : $this->with)->ofTYpe($type)->paginate($pagination, $attributes);
        }
        if ($this->post) {
            if ($this->fromCache) {

                if ($this->post->postsOfType && $this->post->postsOfType->post_type_id) {
                    $cached = Cache::get($this->generateModelUnitCacheKey($this->model, $this->post->id.':postsOfType:'.$this->post->postsOfType->post_type_id.':offset:'.$offset));
                    if($cached){
                        return $cached;
                    }else{
                        $posts = $this->model->with((count($relations) > 0) ? $relations : $this->with)->ofTYpe($this->post->postsOfType->post_type_id)->orderBy('created_at', 'desc')->paginate($pagination, $attributes, 'page', $offset);
                        $this->storeLengthAwarePaginatorInCache($posts, $this->generateModelUnitCacheKey($this->model, $this->post->id.':postsOfType:'.$this->post->postsOfType->post_type_id.':offset:'.$offset));
                        return $posts;
                    }
                }
                return null;
            }
        }
        return null;
    }

    public function getPostsOfType( $type, array $attributes = ['*'], $relations = [] )
    {
        if ($this->paginated) {
            # code...
            return $this->getPaginatedPostsOfType($type);
        }
        if ($this->fromCache) {
            # code...
            $cached = Cache::get( $this->getCachePrefix().':oftype:'.$type );
            if ($cached) {
                # code...
                return $cached;
            } else {
                # code...
                $posts = $this->model::ofType($type)->get();
                ($posts) ? $this->storeCollectionInCache( $posts, $this->getCachePrefix().':oftype:'.$type ) : '';
                return $posts;
            }
            
        } 
        return $this->model::ofType($type)->get();
    }

    private function getPaginatedPostsOfType($type)
    {
        if($this->fromCache){
            $cached = Cache::get( $this->getCachePrefix().':oftype:'.$type.':offset:'.$this->offset );
            if ($cached) {
                # code...
                return $cached;
            } else {
                # code...
                $posts = $this->model::ofType($type)->paginate($this->perPage);
                ($posts) ? $this->storeLengthAwarePaginatorInCache( $posts, $this->getCachePrefix().':oftype:'.$type.':offset:'.$this->offset ) : '';
                return $posts;
            }
        }
        return $this->model::ofType($type)->paginate($this->perPage);
    }


    public function option(string $key, $post = null) : ? Model
    {
        return ($this->post) ? $this->post->options()->where('key', $key)->first() : $post->options()->where('key', $key)->first();
    }

    public function options($post = null) : ? Collection 
    {
        return ($this->post) ? $this->post->options()->get() : $post->options()->get();
    }

    public function ofCategory($category = null, $offset = 1, $pagination = 3, array $attributes = ['*'], $relations = []) : ? LengthAwarePaginator
    {
        if ($category) {
            return $this->model->with((count($relations) > 0) ? $relations : $this->with)->ofCategory($category)->orderBy('created_at', 'desc')->paginate($pagination, $attributes);
        }
        return null;
    }

    /**
     * Get posts of specific category
     * 
     * @param mixed $categpry
     * @param array $attributes
     * @param array $relations
     * 
     * @return Illuminate\Pagination\LengthAwarePaginator or
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getPostsOfCategory( $category, array $attributes = ['*'], $relations = [])
    {
        if ($this->paginated) {
            # code...
            return $this->getPaginatedPostsOfCategory($category);
        }
        if ($this->fromCache) {
            # code...
            $cached = Cache::get( $this->getCachePrefix().':ofcategory:'.$category );
            if ($cached) {
                # code...
                return $cached;
            } else {
                # code...
                $posts = $this->model::ofCategory($category)->get();
                ($posts) ? $this->storeCollectionInCache( $posts, $this->getCachePrefix().':ofcategory:'.$category ) : '';
                return $posts;
            }
            
        } 
        return $this->model::ofCategory( $category )->get();
    }

    private function getPaginatedPostsOfCategory($category)
    {
        if($this->fromCache){
            $cached = Cache::get( $this->getCachePrefix().':ofcategory:'.$category.':offset:'.$this->offset );
            if ($cached) {
                # code...
                return $cached;
            } else {
                # code...
                $posts = $this->model::ofCategory($category)->paginate($this->perPage);
                ($posts) ? $this->storeLengthAwarePaginatorInCache( $posts, $this->getCachePrefix().':ofcategory:'.$category.':offset:'.$this->offset ) : '';
                return $posts;
            }
        }
        return $this->model::ofCategory($category)->paginate($this->perPage);
    }
   
}