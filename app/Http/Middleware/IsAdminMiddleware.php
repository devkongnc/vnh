<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class IsAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (!auth()->user()->can('manage-user')) {
            if ($request->ajax()) return response('Forbidden.', 403);
            else abort(403);
        }

        return $next($request);
    }
}
