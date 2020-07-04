<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stadium extends Model {

    public $timestamps = false;

    protected $table = 'stadiums';
    protected $guarded = [];
    protected $appends = ['logo'];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function getLogoAttribute()
    {
        $file = 'img/logos/' . $this->name_en . '.jpg';
        $path = public_path($file);

        return file_exists($path) ? asset($file) : null;
    }
}
