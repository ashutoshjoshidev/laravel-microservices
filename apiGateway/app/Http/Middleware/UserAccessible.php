<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserAccessible
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->status != 1) {
            return response()->json(['error' => 'Unauthorized! Account is unapproved.'], 401);
        }
        return $next($request);
    }
}
