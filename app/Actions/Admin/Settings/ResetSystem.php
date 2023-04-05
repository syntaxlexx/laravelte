<?php

namespace App\Actions\Admin\Settings;

use App\Repositories\SystemInfoRepository;
use App\Traits\CustomControllerResponsesTrait;
use App\Traits\ThemesTrait;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Lorisleiva\Actions\Concerns\AsAction;

class ResetSystem
{
    use AsAction;
    use ThemesTrait;
    use CustomControllerResponsesTrait;

    public function asController(Request $request)
    {
        $actions = [
            [
                'text' => 'Clear Redis',
                'action' => 'redis',
            ],
            [
                'text' => 'Clear Cached Views',
                'action' => 'views',
            ],
            [
                'text' => 'Refresh Configurations (Settings)',
                'action' => 'configurations',
            ],
            [
                'text' => 'Update Configurations (Settings)',
                'action' => 'update-configurations',
            ],
            [
                'text' => 'Truncate & Reset Configurations (Settings)',
                'action' => 'reset-configurations',
            ],
            [
                'text' => 'Run Seeder',
                'action' => 'run-seeder',
            ],
            [
                'text' => 'Seed Demo Data',
                'action' => 'seed-demo-data',
            ],
        ];

        if($request->isMethod('get')) {

            return $this->generateBackendPage('Admin/Settings/ResetSystem', [
                'actions' => $actions,
            ]);
        }

        $request->validate([
            'action' => [
                'required',
                'string',
                Rule::in(collect($actions)->pluck('action')->toArray()),
            ]
        ]);

        $repo = resolve(SystemInfoRepository::class);
        $status = $repo->reset($request->action);

        if($status) {
            // TODO: event
            return $this->respSuccess();
        }

        return $this->respError();
    }
}
