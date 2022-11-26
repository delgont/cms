<?php

namespace Delgont\Cms\Services\Post;

use Delgont\Cms\Models\Post\Post;


class PostService
{
    const POSTS_ATTRIBUTES = ['id', 'post_title', 'slug', 'url', 'created_at', 'updated_at', 'post_type_id', 'template_id', 'created_by', 'updated_by'];
    const POST_ATTRIBUTES = ['id', 'post_title'];

    public function all($paginated = true, $attributes = self::POSTS_ATTRIBUTES)
    {
        return Post::with([
            'author:id,name',
            'updatedBy:id,name',
            'posttype:id,name',
            'categories:id,name'
        ])->orderBy('created_at', config('delgont.order_posts_in', 'desc'))->paginate(6, $attributes);
    }

    public function get()
    {
        return Post::withCount(['comments'])
        ->orderBy('created_at', config('delgont.order_posts_in', 'desc'))
        ->paginate(config('delgont.posts_per_page', 6), self::ATTRIBUTES);
    }

    public function save($columns) : object
    {
        $post = new Post();
        $post->post_title = (array_key_exists('post_title', $columns)) ? $columns['post_title'] : null;
        $post->slug = (array_key_exists('slug', $columns)) ? $columns['slug'] : null;
        $post->post_type_id = (array_key_exists('post_type_id', $columns)) ? $columns['post_type_id'] : null;
        $post->extract_text = (array_key_exists('extract_text', $columns)) ? $columns['extract_text'] : null;
        $post->post_content = (array_key_exists('post_content', $columns)) ? $columns['post_content'] : null;
        $post->template_id = (array_key_exists('template_id', $columns)) ? $columns['template_id'] : null;
        $post->parent_id = (array_key_exists('parent_id', $columns)) ? $columns['parent_id'] : null;
        $post->post_featured_image = (array_key_exists('post_featured_image', $columns)) ? $columns['post_featured_image'] : null;
        $post->created_by = auth()->user()->id;
        $post->updated_by = auth()->user()->id;
        $post->save();
        return $post;
    }

    public function create($columns)
    {
        Post::create($columns);
    }


    public function update($id, $columns)
    {
        return Post::whereId($id)->update($columns);
    }

    public function delete($id)
    {
        return Post::whereId($id)->delete();
    }

    /**
     * Get published posts
     *
     * @return array
     */
    public function published() : object
    {
        return Post::wherePublished('1')->get();
    }

    /**
     * Get un published posts.
     *
     * @return array
     */
    public function unPublished() : object
    {
        return Post::wherePublished('0')->get();
    }

    /**
     * Publish a post.
     *
     * @return boolean
     */
    public function publish($id) : bool
    {
        $done = Post::where('id', $id)->update(['published' => '1']);
        return ($done) ? true : false;
    }

    /**
     * Unpublish a post.
     *
     * @return boolean
     */
    public function unPublish($id) : bool
    {
        $done = Post::where('id', $id)->update(['published' => '0']);
        return ($done) ? true : false;
    }


    public function show($id, $attributes = self::POST_ATTRIBUTES)
    {
        //return Post::with('comments')->findOrFail($id)->comments()->get();

        return $post = Post::with([
            'author:id,name',
            'updatedBy:id,name',
            'categories:id,name',
            'posttype:id,name',
            'icon:id,url,iconable_id',
            'template',
            'parent:id,post_title',
            'menu',
            'postsOfType',
            'comments' => function($q){
                $q->orderBy('created_at', 'desc')->limit(4);
            }
        ])->withCount(['comments'])->findOrFail($id);


        return (is_null($key)) ? Post::with(['categories','icon', 'downloadables', 'parent'])->findOrFail($value) : Post::with(['categories','icon', 'downloadables','parent'])->where($key, $value)->firstOrFail();
    }

    public function find($value, $key = null)
    {
        return (is_null($key)) ? Post::findOrFail($value) : Post::firstOrFail();
    }

    public function addIcon($post, $url) : void
    {
        $post->icon()->create([
            'icon' => $url
        ]);
    }

    public function attachCategories($post, $categories)
    {
        return $post->categories()->sync($categories);
    }

    public function detachCategories($post, $categories) 
    {
        return $post->categories()->detach($categories);
 
    }

    public function attachPostPostType($post, $post_type_id = null)
    {
       if (!is_null($post_type_id)) {
        return $post->postsOfType()->updateOrCreate(['post_id' => $post->id],[
            'post_id' => $post->id,
            'post_type_id' => $post_type_id
        ]);
       }
       return null;
    }

    public function trash()
    {
        return Post::onlyTrashed()->get();
    }

    /**
     * Count posts in the trash
     */
    public function countTrash()
    {
        return Post::onlyTrashed()->count();
    }

    public function destroyFeaturedImage($id)
    {
        Post::where('id', $id)->update(['post_featured_image' => NULL]);
    }
    
}
