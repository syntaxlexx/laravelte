<?php

namespace App\Actions\Auth;

use App\Events\UserLoggedIn;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\CustomControllerResponsesTrait;
use App\Traits\ThemesTrait;
use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Login
{
    use AsAction;
    use ThemesTrait;
    use CustomControllerResponsesTrait;

    /**
     * Login username to be used by the controller.
     *
     * @var string
     */
    protected $username;

    public function asController(Request $request)
    {
        if ($request->isMethod('get')) {
            $params = [
                'canRegister' => setting('allow_user_registrations'),
                'canResetPassword' => setting('allow_user_reset_password'),
                'oauth_providers' => config('system.providers') ?? []
            ];

            if ($request->is_demo) {
                $params = array_merge([
                    'username' => config('system.defaults.demo_username'),
                    'password' => config('system.defaults.demo_password'),
                    'is_demo' => true
                ], $params);
            }

            return $this->generatePage('login', 'Auth/Login', $params);
        }

        $this->username = $this->findUsername();
        $request->validate($this->loginRules(), $this->getValidationMessages());

        $user = User::where($this->username(), $request->username)->first();
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return $this->respValidationError([
                'username' => [trans('auth.failed')],
            ]);
        }

        if(! $request->wantsJson() && setting('restrict_non_admin_users_to_login_via_mobile_app') && !($user->isAdmin || $user->isSudo)) {
            return $this->respValidationError([
                'username' => [trans('auth.use_mobile_app')],
            ]);
        }

        // verify is user is active, + other checks
        if(! $user->canLogin()) {
            return $this->respValidationError([
                'username' => [trans('auth.account_not_active')],
            ]);
        }

        $loggedInStatus = Auth::loginUsingId($user->id);

        if(! $loggedInStatus) {
            return $this->sendFailedLoginResponse($request);
        }

        $deviceName = $request->device_name ?? $user->name . ' device';

        event(new UserLoggedIn([
            'ip' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'referer' => $request->header('Referer'),
            'host' => $request->header('Host'),
            'url' => $request->root(),
            'device_name' => $deviceName,
        ], $user));

        if($request->wantsJson())
        {
            // specifically target mobile devices - LARAVEL SANCTUM
            // since we are targeting only login authentication,
            // we can delete existing tokens for the user
            // before creating a new one, to minify table records size

            // Revoke all tokens...
            $user->tokens()->delete();

            return response()->json([
                'message' => 'Login Successful',
                'errors' => false,
                'auth' => true,
                'user' => new UserResource($user),
                'access_token' => $user->createToken($deviceName)->plainTextToken,
                // 'refresh_token' => $token->refresh_token,
            ]);
        }

        $request->session()->regenerate();

        if($user->isAdmin || $user->isSudo) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('user.dashboard');

    }


    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function findUsername()
    {
        $login = request()->input('username');
        $fieldType = 'name';

        if(filter_var($login, FILTER_VALIDATE_EMAIL))
            $fieldType = 'email';

        request()->merge([$fieldType => $login]);

        return $fieldType;
    }

    /**
     * Get username property.
     *
     * @return string
     */
    public function username()
    {
        return $this->username;
    }


    /**
     * Get the login validation rules.
     *
     * @return array
     */
    public function loginRules() : array
    {
        $deviceRules = [];

        // ensure mobile devices provide the device name attr
        if(request()->wantsJson()) {
            $deviceRules = [
                'device_name' => 'required|string|max:255|min:1',
            ];
        }

        if($this->username() == 'email')
            return array_merge([
                'username' => 'required|email',
                'password' => 'required|min:4|max:255|string',
            ], $deviceRules);


        return array_merge([
            'username' => 'required|string',
            'password' => 'required|min:4|max:255|string',
        ], $deviceRules);
    }


    /**
     * Get the login validation error messages.
     *
     * @return array
     */
    public function getValidationMessages()
    {
        return [
            'name.required' => 'The username field is required. Provide either the email,username, or phone',
            'name.string' => 'The username field should be a string'
        ];
    }


    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        return $this->respValidationError([
            $this->username() => trans('auth.failed'),
        ]);
    }


}
