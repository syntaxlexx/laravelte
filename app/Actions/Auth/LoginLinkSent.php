<?php

namespace App\Actions\Auth;

use App\Traits\CustomControllerResponsesTrait;
use App\Traits\ThemesTrait;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class LoginLinkSent
{
    use AsAction;
    use ThemesTrait;
    use CustomControllerResponsesTrait;

    public function asController(Request $request)
    {
        return $this->generatePage('login-link-sent', 'Auth/LoginLinkSent');
    }
}
