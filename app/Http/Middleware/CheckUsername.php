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

        return $next($request);
    }
}
