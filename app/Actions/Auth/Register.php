<?php

namespace App\Actions\Auth;

use App\Events\CRUDErrorOccurred;
use App\Events\UserWasRegistered;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
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

    /**
     * Provide functions for formatting & detecting phone numbers
     *
     * @var UsersRepository
     */
    protected $usersRepo;

    public function asController(RegisterRequest $request, UserRepository $usersRepo)
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
