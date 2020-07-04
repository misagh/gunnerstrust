<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model {

    public $timestamps = false;

    protected $guarded = [];
    protected $appends = ['logo'];

    public function stadium()
    {
        return $this->hasOne(Stadium::class);
    }

    public function getLogoAttribute()
    {
        $file = 'img/logos/' . $this->name_en . '.png';
        $path = public_path($file);

        return file_exists($path) ? asset($file) : null;
    }
}
