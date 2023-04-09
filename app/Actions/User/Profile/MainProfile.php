<?php

namespace App\Actions\User\Profile;

use App\Traits\CustomControllerResponsesTrait;
use App\Traits\ThemesTrait;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class MainProfile
{
    use AsAction;
    use ThemesTrait;
    use CustomControllerResponsesTrait;

    public function asController(Request $request)
    {
        return $this->generateBackendPage('Profile/MainProfile', [
            'title' => doe()->full_name . ' Profile',
        ]);
    }
}
