<?php

namespace App\Actions\Auth;

use App\Events\UserLoggedOut;
use App\Traits\CustomControllerResponsesTrait;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class Logout
{
    use AsAction;
    use CustomControllerResponsesTrait;

    public function asController(Request $request)
    {
        $user = doe();

        // TODO: logout event
        // event(new UserLoggedOut($user->id));

        if($request->wantsJson())
        {
            $request->user()->currentAccessToken()->delete();

            return new JsonResponse([
                'message' => 'Logout Success'
            ], 204);
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->to('/');
    }
}
