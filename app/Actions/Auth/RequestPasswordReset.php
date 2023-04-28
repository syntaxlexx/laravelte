<?php

namespace App\Actions\Auth;

use App\Traits\CustomControllerResponsesTrait;
use App\Traits\ThemesTrait;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class RequestPasswordReset
{
    use AsAction;
    use ThemesTrait;
    use CustomControllerResponsesTrait;

    public function asController(Request $request)
    {
        if ($request->isMethod('get')) {
            return $this->generatePage('forgot-password', 'Auth/ForgotPassword', [
                'title' => 'Request Password Reset'
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
