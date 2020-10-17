<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discussion extends Model {

    protected $guarded = [];
    protected $appends = ['url'];

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function getUrlAttribute()
    {
        return route('discussions.view', $this->slug);
    }
}
