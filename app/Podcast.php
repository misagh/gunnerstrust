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

    public function getEmbedScriptAttribute()
    {
        return '<iframe class="shenotoIframe2" src="https://shenoto.com/iframe2/album/' . $this->embed . '" scrolling="no" style="min-width: 100%; height: 165px"></iframe>';
    }
}
