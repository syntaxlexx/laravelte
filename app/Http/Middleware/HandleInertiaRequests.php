<?php

namespace App\Http\Middleware;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        $params = array_merge(parent::share($request), [
            'flash' => function () use ($request) {
                return [
                    'success' => $request->session()->get('success'),
                    'error' => $request->session()->get('error'),
                ];
            },
            'siteLogo' => config('app.logo'),
            'siteName' => config('app.name'),
            'systemVersion' => config('system.version'),
            'locale' => Session::get('locale') ?? App::getLocale(),
        ], $request->session()->get('flash_success_data') ?? []);

        $user = $request->user();

        if (! $user) {
            return array_merge($params, [
                'auth.user' => null,
            ]);
        }

        $newNotifications = Cache::remember('newNotifications', 600, function () use($user) {
            return (int) $user->unreadNotifications()->count();
        });

        return array_merge($params, [
            'new_notifications' => $newNotifications,
            'auth.user' => json_decode((new UserResource($user))->toJson()),
        ]);
    }
}
