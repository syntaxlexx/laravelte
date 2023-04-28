<?php

namespace App\Actions\Auth;

use App\Traits\CustomControllerResponsesTrait;
use App\Traits\ThemesTrait;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class ResetPassword
{
    use AsAction;
    use ThemesTrait;
    use CustomControllerResponsesTrait;

    public function asController(Request $request, $token = null)
    {
        if ($request->isMethod('get')) {
            return $this->generatePage('reset-password', 'Auth/ResetPassword', [
                'token' => $token,
                'title' => trans('Reset Password')
            ]);
        }

        return $request->wantsJson()
            ? response()->json([
                'message' => trans('Premium Feature!'),
                'errors' => trans('Premium Feature!'),
            ], 422)
            : back()->withErrors(['email' => trans('Premium Feature!')]);
    }
}
