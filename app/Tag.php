<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model {

    protected $guarded = [];

    public function articles()
    {
        return $this->morphedByMany(Article::class, 'taggable');
    }

    public function updates()
    {
        return $this->morphedByMany(Update::class, 'taggable');
    }
}
