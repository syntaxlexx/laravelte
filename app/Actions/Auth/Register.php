<?php

namespace App\Actions\Auth;

use App\Traits\ThemesTrait;
use Lorisleiva\Actions\Concerns\AsAction;

class Register
{
    use AsAction;
    use ThemesTrait;

    public function asController()
    {
        return $this->generatePage('register', 'Auth/Register');
    }
}
