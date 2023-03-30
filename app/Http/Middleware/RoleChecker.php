<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoleChecker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string  $roles
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $roles)
    {
        $user = $request->user();

        if(! $user) {
            return deny();
        }

        $roles = str_replace(' ', '', $roles);
        $roles = Str::contains($roles, ',') ? explode(',', $roles) : explode('|', $roles);

        if (! in_array($user->role, $roles)) {
            return deny();
        }

        return $next($request);
    }
}
