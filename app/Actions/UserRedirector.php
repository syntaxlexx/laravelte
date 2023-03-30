<?php

namespace App\Actions;

use Lorisleiva\Actions\Concerns\AsAction;

class UserRedirector
{
    use AsAction;

    public function handle()
    {
        if(doe()->isAdmin) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('user.dashboard');
    }
}
