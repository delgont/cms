<?php

namespace Delgont\Cms\Models\Concerns;

trait CanComment
{
    public function comments()
    {
        return $this->morphMany('Delgont\Cms\Models\Comment\Comment', 'commenter');
    }

    public function comment($comment, $commentable)
    {
        return $this->comments()->create([
            'comment' => $comment,
            'commentable_id' => $commentable['id'],
            'commentable_type' => $commentable['type']
        ]);

    }

}