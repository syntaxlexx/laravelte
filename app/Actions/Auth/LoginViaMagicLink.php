<?php

namespace App\Actions\Auth;

use App\Events\CRUDErrorOccurred;
use App\Models\User;
use App\Traits\CustomControllerResponsesTrait;
use App\Traits\ThemesTrait;
use Exception;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class LoginViaMagicLink
{
    use AsAction;
    use ThemesTrait;
    use CustomControllerResponsesTrait;

    public function asController(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            try {
                $user->sendLoginLink();
            } catch (Exception $e) {
                ddOnError($e);

                event(new CRUDErrorOccurred($e->getMessage()));

                return $this->respError(trans('An error occurred while sending the login link'));
            }
        }

        return redirect()->route('login-link-sent')
            ->withSuccess(trans('We have sent a magic link to the email. If the account exists, you shall receive an email.'));
    }
}
