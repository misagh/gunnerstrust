<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Update extends Model {

    protected $guarded = [];
    protected $appends = ['title', 'summary'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function getTitleAttribute()
    {
        return get_limited($this->body, 8);
    }

    public function getSummaryAttribute()
    {
        return get_limited($this->body, 40);
    }
}
