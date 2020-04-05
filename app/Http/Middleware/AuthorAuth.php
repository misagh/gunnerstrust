<?php

namespace App\Http\Middleware;

use Closure;

class AuthorAuth {

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $auth = auth()->user();

        if (! (is_admin($auth) || is_author($auth)))
        {
            abort(404);
        }

        return $next($request);
    }
}
