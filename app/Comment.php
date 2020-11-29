<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

    protected $guarded = [];
    protected $appends = ['own_comment', 'like_data', 'posted_at', 'edit', 'reply', 'replies_list', 'force_reply_open', 'short'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'reply_id');
    }

    public function reactions()
    {
        return $this->morphMany(Reaction::class, 'reactionable');
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function getPostedAtAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getEditAttribute()
    {
        return false;
    }

    public function getReplyAttribute()
    {
        return false;
    }

    public function getForceReplyOpenAttribute()
    {
        return false;
    }

    public function getOwnCommentAttribute()
    {
        return $this->user_id === auth()->id();
    }

    public function getLikeDataAttribute()
    {
        $likes = $this->likes;

        $user = $likes->where('user_id', auth()->id())->first();

        return [
            'count' => $likes->count(),
            'user'  => ! empty($user),
        ];
    }

    public function getRepliesListAttribute()
    {
        return $this->replies()->with('user')->orderByDesc('id')->get();
    }

    public function getShortAttribute()
    {
        return route('comments.view', [$this->id . '-' . $this->user_id]);
    }

    public function getTitleAttribute()
    {
        return $this->user->username . ': ' . get_limited($this->body, 8);
    }

    public function getSummaryAttribute()
    {
        return get_limited($this->body, 40);
    }
}
