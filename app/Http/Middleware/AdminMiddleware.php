<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (auth()->check() && auth()->user()->type === 'admin') {

            return $next($request);

        }

        else if (auth()->check() && auth()->user()->type === 'company') {

            return $next($request);

        }

        // return redirect()->route('login');
        abort(403, 'Unauthorized access.');
    }
}
