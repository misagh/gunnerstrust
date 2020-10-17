<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model {

    protected $guarded = [];

    public $timestamps = false;

    public function discussion()
    {
        return $this->belongsTo(Discussion::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}
