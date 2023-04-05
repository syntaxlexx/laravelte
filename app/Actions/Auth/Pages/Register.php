<?php

namespace App\Actions\Auth\Pages;

use App\Traits\CustomControllerResponsesTrait;
use App\Traits\ThemesTrait;
use Lorisleiva\Actions\Concerns\AsAction;

class Register
{
    use AsAction;
    use ThemesTrait;
    use CustomControllerResponsesTrait;

    public function asController()
    {
        $params = [
            'canRegister' => setting('allow_user_registrations'),
            'oauth_providers' => config('system.providers') ?? []
        ];

        return $this->generatePage('login', 'Auth/Register', $params);
    }
}
