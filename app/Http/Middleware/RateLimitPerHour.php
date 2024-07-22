<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RateLimitPerHour
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        $executed = RateLimiter::attempt(
            $user->id,
            $user::RATELIMIT_ATTEMPT,
            function () {
            },
            $user::RATELIMIT_DURATION_IN_SECONDS,
        );

        if (!$executed) {
            abort(429, 'Too Many Requests',);
        }

        return $next($request);
    }
}
