<?php

namespace App\Actions\Auth\Pages;

use App\Traits\CustomControllerResponsesTrait;
use App\Traits\ThemesTrait;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class ResetPassword
{
    use AsAction;
    use CustomControllerResponsesTrait;
    use ThemesTrait;

    public function asController(Request $request, $token)
    {
        return $this->generatePage('login', 'Auth/ResetPassword', [
            'token' => $token,
            'title' => 'Reset Password'
        ]);
    }
}
