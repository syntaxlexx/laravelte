<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckIfUserActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (! $user) {
            return $next($request);
        }

        if ($user->canLogin() || $user->isSudo) {
            return $next($request);
        } else {
            // return redirect()->back()->with('message', 'Your user account is deactivated!');
            abort(310, trans('auth.account_not_active'));
        }

        return $next($request);
    }
}
