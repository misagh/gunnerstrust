<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model {

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fixture()
    {
        return $this->belongsTo(Fixture::class);
    }

    public function isWin()
    {
        return $this->score1 > $this->score2;
    }

    public function isLost()
    {
        return $this->score1 < $this->score2;
    }

    public function isDraw()
    {
        return $this->score1 === $this->score2;
    }
}
