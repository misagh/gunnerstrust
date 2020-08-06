<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interview extends Model {

    protected $guarded = [];
    protected $appends = ['score'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function scores()
    {
        return $this->morphMany(Score::class, 'scorable');
    }

    public function getScoreAttribute()
    {
        $avg = $this->scores()->avg('score');

        return $avg ? round($avg, 1) : null;
    }

    public function getUrlAttribute()
    {
        return route('interviews.view', $this->slug);
    }
}
