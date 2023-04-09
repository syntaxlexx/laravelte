<?php

namespace App\Actions\Admin;

use App\Traits\ThemesTrait;
use Lorisleiva\Actions\Concerns\AsAction;

class Dashboard
{
    use AsAction;
    use ThemesTrait;

    public function asController()
    {
        if(! (doe()->isAdmin || doe()->isSudo)) {
            return redirect()->route('user.dashboard');
        }

        return $this->generateBackendPage('Dashboard', [
            'title' => "Welcome Back, " . doe()->full_name,
        ]);
    }
}
