<?php

namespace App\Actions\Auth;

use App\Traits\ThemesTrait;
use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Http\Request;

class Register
{
    use AsAction;
    use ThemesTrait;

    public function handle(Request $request)
    {
        if($request->isMethod('get')) {
            return $this->generatePage('register', 'Auth/Register', [
                'canRegister' => setting('allow_user_registrations') && ! setting('restrict_users_to_register_via_mobile_app'),
                'oauth_providers' => config('system.providers'),
            ]);
        }
    }
}
