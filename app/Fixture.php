<?php

namespace App;

use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Model;

class Fixture extends Model {

    public $timestamps = false;

    protected $guarded = [];
    protected $dates = ['played_at'];
    protected $appends = ['title', 'url', 'comments_count'];

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function team1()
    {
        return $this->belongsTo(Team::class, 'team1_id');
    }

    public function team2()
    {
        return $this->belongsTo(Team::class, 'team2_id');
    }

    public function stadium()
    {
        return $this->belongsTo(Stadium::class);
    }

    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }

    public function getTitleAttribute()
    {
        return $this->team1->name_fa . ' و ' . $this->team2->name_fa . ' - ' . shamsi_format($this->played_at, 'l j F Y');
    }

    public function getSummaryAttribute()
    {
        $team1 = $this->team1->name_fa;
        $team2 = $this->team2->name_fa;
        $stadium = $this->stadium->name_fa;
        $competition = $this->competition->name_fa;
        $date = shamsi_format($this->played_at, 'l j F Y');
        $time = shamsi_format($this->played_at, 'H:i');
        $season = Verta::persianNumbers($this->getFullSeason());

        return "جزییات، آمار و اخبار دیدار بین دو تیم {$team1} و {$team2} در چهارچوب رقابت های {$competition} فصل {$season} در تاریخ {$date} ساعت {$time} در ورزشگاه {$stadium}";
    }

    public function getUrlAttribute()
    {
        return route('fixtures.view', $this->slug);
    }

    public function getCommentsCountAttribute()
    {
        return $this->comments()->count();
    }

    private function getFullSeason($sep = '/')
    {
        return $this->season . $sep . ($this->season + 1);
    }
}
