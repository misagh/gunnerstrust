<?php

namespace App\Http\Middleware;

use Closure;

class CheckUsername {

    public function handle($request, Closure $next)
    {
        $auth = auth()->user();

        if ($auth && empty($auth->username) && ! $request->routeIs('users.username'))
        {
            return redirect()->route('users.username');
        }

        if (in_array($request->path(), ['login', 'register']) || starts_with($request->path(), 'comments'))
        {
            $request->session()->keep('url_back');
        }
        else
        {
            $request->session()->flash('url_back', url($request->path()));
        }

        return $next($request);
    }
}
