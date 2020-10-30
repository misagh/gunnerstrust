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

function fixture_title($fixture, $mid = 'vs')
{
    $team1 = $fixture->team1->name_en . ' ' . $fixture->score1;
    $team2 = $fixture->score2 . ' ' . $fixture->team2->name_en;

    $mid = is_null($fixture->score1) ? $mid : '-';

    return trim($team1) . " {$mid} " . trim($team2);
}

function yesterday()
{
    return today()->subDay();
}

function tomorrow()
{
    return today()->addDay();
}

function shamsi($date)
{
    return verta(Carbon\Carbon::parse($date)->timezone('Asia/Tehran')->toDateTimeString(), 'Asia/Tehran');
}

function shamsi_format($date, $format)
{
    return \Hekmatinasser\Verta\Verta::persianNumbers(shamsi($date)->format($format));
}

function shamsi_human_diff($date)
{
    return \Hekmatinasser\Verta\Verta::persianNumbers($date->diffForHumans());
}

function remove_br($text)
{
    return str_ireplace(["<br />", "<br>", "<br/>"], "", $text);
}

function month_name($month)
{
    $months = [
        1  => 'ژانویه',
        2  => 'فوریه',
        3  => 'مارچ',
        4  => 'آپریل',
        5  => 'می',
        6  => 'جون',
        7  => 'جولای',
        8  => 'آگوست',
        9  => 'سپتامبر',
        10 => 'اکتبر',
        11 => 'نوامبر',
        12 => 'دسامبر',
    ];

    return $months[$month] ?? '';
}
