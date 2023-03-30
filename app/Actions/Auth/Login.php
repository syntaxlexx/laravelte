<?php

namespace App\Actions\Auth;

use App\Traits\ThemesTrait;
use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Http\Request;

class Login
{
    use AsAction;
    use ThemesTrait;

    public function handle(Request $request)
    {
        if($request->isMethod('get')) {
            $params = [
                'canRegister' => setting('allow_user_registrations'),
                'canResetPassword' => setting('allow_user_reset_password'),
                'oauth_providers' => config('system.providers') ?? []
            ];

            if(isDemo()) {
                $params = array_merge([
                    'username' => config('system.defaults.demo_username'),
                    'password' => config('system.defaults.demo_password'),
                ], $params);
            }

            return $this->generatePage('login', 'Auth/Login', $params);
        }
    }
}
