<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Podcast extends Model {

    protected $guarded = [];

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function getUrlAttribute()
    {
        return route('podcasts.view', $this->slug);
    }
}
