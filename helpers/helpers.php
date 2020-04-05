<?php

function is_admin($auth = null)
{
    $user = $auth ?: auth()->user();

    return $user ? $user->role === 'admin' : false;
}

function is_author($auth = null)
{
    $user = $auth ?: auth()->user();

    return $user ? $user->role === 'author' : false;
}

function remove_extra_space($str)
{
    return preg_replace('/\s+/', ' ', $str);
}

function get_cover($img)
{
    $path = substr($img, 0, 2);

    return asset('img/covers/' . $path . '/' . $img);
}

function user_avatar($avatar)
{
    if (! empty($avatar))
    {
        $dir = substr($avatar, 0, 2);

        return asset('img/avatars/' . $dir . '/' . $avatar . '.png');
    }

    return asset('img/default_avatar.png');
}
