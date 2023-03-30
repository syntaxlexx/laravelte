<?php

namespace App\Actions\Frontend;

use App\Traits\ThemesTrait;
use Lorisleiva\Actions\Concerns\AsAction;

class About
{
    use AsAction;
    use ThemesTrait;

    public function asController()
    {
        return $this->generatePage('about', 'About');
    }
}
