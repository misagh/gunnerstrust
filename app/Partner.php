<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model {

    public $timestamps = false;

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
