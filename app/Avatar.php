<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Avatar extends Model {

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
