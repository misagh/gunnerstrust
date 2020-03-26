<?php

function is_admin()
{
    $user = auth()->user();

    return $user ? $user->role === 'admin' : false;
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
