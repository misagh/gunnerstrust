<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model {

    protected $guarded = [];
    protected $appends = ['url'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function reactions()
    {
        return $this->morphMany(Reaction::class, 'reactionable');
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function getUrlAttribute()
    {
        return route('articles.view', $this->slug);
    }

    public function setPin($pin)
    {
        $this->pinned = $pin;
        $this->saveOrFail();
    }
}
