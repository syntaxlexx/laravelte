<?php

namespace App\Actions\Auth\Pages;

use App\Traits\CustomControllerResponsesTrait;
use App\Traits\ThemesTrait;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class ForgotPassword
{
    use AsAction;
    use CustomControllerResponsesTrait;
    use ThemesTrait;

    public function asController(Request $request)
    {
        return $this->generatePage('login', 'Auth/ForgotPassword', [
            'title' => 'Request Password Reset'
        ]);
    }
}
