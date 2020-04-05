<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model {

    protected $guarded = [];

    public function userFrom()
    {
        return $this->belongsTo(User::class, 'user_from_id');
    }

    public function userTo()
    {
        return $this->belongsTo(User::class, 'user_to_id');
    }

    public function markAsRead()
    {
        $this->read_at = now();
        $this->saveOrFail();
    }
}
