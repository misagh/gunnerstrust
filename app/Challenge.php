<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Challenge extends Model {

    protected $guarded = [];
    protected $dates = ['started_at', 'finished_at'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
