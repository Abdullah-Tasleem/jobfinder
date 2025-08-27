<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() ) {
            if(auth()->user()->type === 'user' || auth()->user()->type === 'admin') {
            return $next($request);
        }
        }
        // If the user is not authenticated or not a 'user', abort with a 403
        abort(403, 'Unauthorized access.');
        // return to_route('login');
    }
}
