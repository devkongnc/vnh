<?php

namespace App\Http\Middleware;

use Closure;

class RedirectOldSitemap
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $sitemap = config('sitemap');
        $key = trim($request->getRequestUri(), '/');
        if (isset($sitemap[$key])) {
            return redirect()->to($sitemap[$key], 301);
        }
        return $next($request);
    }

}
