<?php

namespace App\Actions\Frontend;

use App\Traits\ThemesTrait;
use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Foundation\Application;

class Home
{
    use AsAction;
    use ThemesTrait;

    public function asController()
    {
        return $this->generatePage('home', 'Home', [
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }
}
