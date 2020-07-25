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

    public function getEmbedScriptAttribute()
    {
        if (empty($this->embed))
        {
            return null;
        }

        $embed = explode('-', $this->embed);

        return '<div id="' . $embed[0] . '"><p class="text-center py-5 text-muted font-weight-bold font-italic">در حال بارگذاری ویدئو...</p><script type="text/JavaScript" src="https://www.aparat.com/embed/' . @$embed[1] . '?data[rnddiv]=' . $embed[0] . '&data[responsive]=yes" defer async></script></div>';
    }
}
