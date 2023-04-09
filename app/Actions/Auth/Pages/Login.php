<?php

namespace App\Actions\Auth\Pages;

use App\Traits\CustomControllerResponsesTrait;
use App\Traits\ThemesTrait;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class Login
{
    use AsAction;
    use ThemesTrait;
    use CustomControllerResponsesTrait;

    public function asController(Request $request)
    {
        $params = [
            'canRegister' => setting('allow_user_registrations'),
            'canResetPassword' => setting('allow_user_reset_password'),
            'oauth_providers' => config('system.providers') ?? []
        ];

        if($request->is_demo) {
            $params = array_merge([
                'username' => config('system.defaults.demo_username'),
                'password' => config('system.defaults.demo_password'),
                'is_demo' => true
            ], $params);
        }

        return $this->generatePage('login', 'Auth/Login', $params);
    }
}
