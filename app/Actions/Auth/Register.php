<?php

namespace App\Actions\Auth;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Traits\CustomControllerResponsesTrait;
use App\Traits\ThemesTrait;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class Register
{
    use AsAction;
    use ThemesTrait;
    use CustomControllerResponsesTrait;

    /**
     * Provide functions for formatting & detecting phone numbers
     *
     * @var UsersRepository
     */
    protected $usersRepo;

    public function asController(Request $request, UserRepository $usersRepo)
    {
        if($request->isMethod('get')) {
            $params = [
                'canRegister' => setting('allow_user_registrations'),
                'oauth_providers' => config('system.providers') ?? []
            ];

            return $this->generatePage('login', 'Auth/Register', $params);
        }

        $request->validate([
            'name' => 'nullable|string|max:255|unique:users,name',
            'email' => 'required|email|string|min:1|max:255|unique:users,email',
            'phone' => 'nullable|string|max:255|min:10|unique:users,phone|starts_with:+',
            'password' => 'required|string|confirmed|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255|min:1',
            'date_of_birth' => 'nullable|date|before:today',
        ]);

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

        $user = $usersRepo->create($data, User::ROLE_DEFAULT);

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
