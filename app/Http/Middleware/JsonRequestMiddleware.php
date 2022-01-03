<?php

namespace App\Http\Middleware;

use \Illuminate\Http\Request;
use Closure;

class JsonRequestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (is_array($requestContent = json_decode($request->getContent(), true))) {
            $request->merge($requestContent);
        }

        return $next($request);
    }
}