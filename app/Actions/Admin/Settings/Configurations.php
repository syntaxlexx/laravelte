<?php

namespace App\Actions\Admin\Settings;

use App\Traits\CustomControllerResponsesTrait;
use App\Traits\ThemesTrait;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class Configurations
{
    use AsAction;
    use ThemesTrait;
    use CustomControllerResponsesTrait;

    public function asController(Request $request)
    {
        $data = redis()->get('configurations');

        if($request->isMethod('get')) {
            return $this->generateBackendPage('Admin/Settings/Configurations', [
                'configurations' => $data,
            ]);
        }
    }
}
