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

function base64url_encode($data)
{
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function base64url_decode($data)
{
    return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
}

function format_body($body)
{
    $body = str_replace('&lt;&lt;', '<blockquote><i class="fas fa-quote-right"></i>', $body);
    $body = str_replace('&gt;&gt;', '<i class="fas fa-quote-left"></i></blockquote>', $body);

    return $body;
}
