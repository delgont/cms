<?php

namespace Delgont\Cms\Services\Post;

use Delgont\Cms\Models\Post\Post;


class PostTrashService
{
    /**
     * Get all posts in the trash
     */
    public function all()
    {
        return Post::orderBy('deleted_at', 'desc')->onlyTrashed()->get();
    }

    /**
     * Get paginated posts
     */
    public function get()
    {
        return Post::orderBy('deleted_at', 'desc')->onlyTrashed()->paginate();
    }


    /**
     * Count posts in the trash
     */
    public function countTrash()
    {
        return Post::onlyTrashed()->count();
    }

    /**
     * Permanently delete trashed post
     * 
     * @param int $id
     */
    public function destroy($id)
    {
        return Post::onlyTrashed()->whereId($id)->forceDelete();
    }

    /**
     * Restore deleted post
     * 
     * @param int $id
     */
    public function restore($id)
    {
        return Post::onlyTrashed()->whereId($id)->restore();
    }

    /**
     * Empty trash
     * 
     */
    public function empty()
    {
        return Post::onlyTrashed()->forceDelete();
    }
    
}
