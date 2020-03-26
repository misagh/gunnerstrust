<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reaction extends Model {

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reactionable()
    {
        return $this->morphTo();
    }
}
