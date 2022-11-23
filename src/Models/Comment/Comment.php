<?php

namespace Delgont\Cms\Models\Comment;


use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [];

    protected $with = ['commenter:id,name','replies'];


    public function commentable()
    {
        return $this->morphTo();
    }

    public function commenter()
    {
        return $this->morphTo();
    }

    public function replies()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function replyReplies()
    {
        return $this->hasMany(self::class, 'parent_id')->with('replies');
    }
}
