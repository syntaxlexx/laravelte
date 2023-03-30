<?php

namespace App\Actions\User;

use App\Traits\ThemesTrait;
use Lorisleiva\Actions\Concerns\AsAction;

class Dashboard
{
    use AsAction;
    use ThemesTrait;

    public function asController()
    {
        if(doe()->isAdmin) {
            return redirect()->route('admin.dashboard');
        }

        return $this->generateBackendPage('User/Dashboard', [
            'title' => "Welcome Back, " . doe()->full_name,
        ]);
    }
}
