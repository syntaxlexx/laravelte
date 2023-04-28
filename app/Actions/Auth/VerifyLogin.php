<?php

namespace App\Actions\Auth;

use App\Events\UserLoggedIn;
use App\Models\LoginToken;
use App\Traits\CustomControllerResponsesTrait;
use App\Traits\ThemesTrait;
use Auth;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class VerifyLogin
{
    use AsAction;
    use ThemesTrait;
    use CustomControllerResponsesTrait;

    public function asController(Request $request, $token)
    {
        $token = LoginToken::whereToken(md5($token))->firstOrFail();

        abort_unless($request->hasValidSignature() && $token->isValid(), 401);

        $token->consume();

        $user = $token->user;

        // verify is user is active, + other checks
        if (!$user->canLogin()) {
            return redirect()->route('login')->withErrors([
                'username' => [trans('auth.account_not_active')],
            ]);
        }

        Auth::login($user);

        $deviceName = $request->device_name ?? $user->name . ' web device';

        event(new UserLoggedIn([
            'ip' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'referer' => $request->header('Referer'),
            'host' => $request->header('Host'),
            'url' => $request->root(),
            'device_name' => $deviceName,
        ], $user));

        $request->session()->regenerate();

        if ($user->isAdmin || $user->isSudo) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('user.dashboard');
    }
}
