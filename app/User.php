<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {

    use Notifiable;

    protected $fillable = ['name', 'username', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime'];
    protected $appends = ['avatar', 'title'];

    public static $titles = [
        'admin'   => 'مدیر سایت',
        'author'  => 'مترجم سایت',
        'partner' => 'همکار سایت',
        'user'    => 'کاربر سایت',
    ];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

    public function avatars()
    {
        return $this->hasMany(Avatar::class);
    }

    public function points()
    {
        return $this->hasMany(Point::class);
    }

    public function details()
    {
        return $this->hasOne(Detail::class);
    }

    public function getAvatarAttribute()
    {
        $file = null;

        if ($avatar = $this->avatars->first())
        {
            $file = $avatar->file_name;
        }

        return user_avatar($file);
    }

    public function getTitleAttribute()
    {
        return @static::$titles[$this->role];
    }

    public function touchSeen()
    {
        $this->seen_at = now();
        $this->save();
    }
}
