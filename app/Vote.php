<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model {

    protected $guarded = [];

    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
