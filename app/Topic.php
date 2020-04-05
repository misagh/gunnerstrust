<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model {

    protected $guarded = [];
    protected $appends = ['url'];

    public $timestamps = false;

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function getUrlAttribute()
    {
        return route('topics.view', $this->slug);
    }
}
