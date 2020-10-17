<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

    protected $guarded = [];
    protected $appends = ['emojies', 'own_comment', 'reaction_data', 'posted_at', 'edit', 'reply', 'replies_list'];

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

    public function commentable()
    {
        return $this->morphTo();
    }

    public function getPostedAtAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getEmojiesAttribute()
    {
        return false;
    }

    public function getEditAttribute()
    {
        return false;
    }

    public function getReplyAttribute()
    {
        return false;
    }

    public function getOwnCommentAttribute()
    {
        return $this->user_id === auth()->id();
    }

    public function getReactionDataAttribute()
    {
        $reactions = $this->reactions->groupBy('reaction');

        $count = [];

        foreach ($reactions as $reaction)
        {
            $user = $reaction->where('user_id', auth()->id())->first();

            $count[] = [
                'reaction' => $reaction->first()->reaction,
                'count'    => $reaction->count(),
                'user'     => ! empty($user),
            ];
        }

        return $count;
    }

    public function getRepliesListAttribute()
    {
        return $this->replies()->with('user')->orderByDesc('id')->get();
    }
}
