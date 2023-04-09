<?php

namespace App\Actions\Admin\Settings;

use App\Models\Configuration;
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
        $data = Configuration::get();

        if($request->isMethod('get')) {
            return $this->generateBackendPage('Settings/Configurations', [
                'configurations' => $data,
            ]);
        }

        $request->validate([
            'name' => 'required|string',
            'id' => 'required|integer',
        ]);

        $config = Configuration::findOrFail($request->id);
        $resp = $config->update([
            'value' => $request->value,
        ]);

        if($resp) {
            // refresh redis
            resetRedis('update-configurations');
        }

        return $this->respJuicer($resp);
    }
}
