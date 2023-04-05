<?php

namespace App\Actions\Auth;

use App\Events\CRUDErrorOccurred;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\CustomControllerResponsesTrait;
use App\Traits\ThemesTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Lorisleiva\Actions\Concerns\AsAction;

class Register
{
    use AsAction;
    use ThemesTrait;
    use CustomControllerResponsesTrait;

    public function asController(RegisterRequest $request)
    {
        if (!setting('allow_user_registrations')) {
            return $this->respError(trans('auth.registration_closed'));
        }

        if (!$request->wantsJson() && setting('restrict_users_to_register_via_mobile_app')) {
            return $this->respError(trans('auth.use_mobile_app'));
        }

        $data = $request->only([
            'password',
            'name',
            'email',
            'phone',
            'first_name',
            'last_name',
        ]);

        $data = collect($data)->filter(function ($value) {
            return !empty($value);
        })->toArray();

        try {
            DB::beginTransaction();

            $role = User::ROLE_DEFAULT;
            $theRole = 'ROLE_' . strtoupper($role);
            $data['role'] = constant("App\Models\User::$theRole");

            isset($data['date_of_birth']) ? $data['date_of_birth'] = Carbon::parse(request('date_of_birth')) : '';
            $data['password'] = bcrypt($data['password']);

            // set an appropriate (user)name if not provided
            if (!isset($data['name']) || empty($data['name'])) {
                if (isset($data['first_name'])) {
                    $data['name'] = Str::slug($data['first_name'] . '-' . Str::random(5));
                } else if (isset($data['email'])) {
                    $data['name'] = Str::slug(explode('@', $data['email'])[0] . '-' . Str::random(5));
                } else {
                    $data['name'] = Str::slug(Str::random(10));
                }
            }

            $user = User::create($data);
        } catch (Exception $e) {
            DB::rollBack();

            debugOn() ? dde($e->getMessage()) : '';

            event(new CRUDErrorOccurred($e->getMessage()));

            return false;
        }

        // TODO: event
        // event(new UserWasCreated($user->fresh(), doe()));

        if ($user) {
            if ($request->wantsJson())
                return response()->json([
                    'user' => new UserResource($user),
                    'message' => trans('auth.registration_success'),
                ]);

            return redirect()->route('login')->withSuccess(trans('auth.registration_success'));
        }

        return $this->respError(trans('auth.registration_error'));
    }
}
