<?php
namespace App\Http\Responses;

use Filament\Http\Responses\Auth\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Support\Facades\Auth;

class LoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $user = Auth::user();

        if ($user->hasAnyRole(['sysadmin', 'admin'])) {
            return redirect()->intended(url('/adm'));
        } elseif ($user->hasAnyRole(['manager', 'employee', 'guest'])) {
            return redirect()->intended(url('/mar'));
        }

        Auth::logout();
        return redirect()->intended(url('/app'));
    }
}
