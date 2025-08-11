<?php
namespace App\Http\Responses;

use Filament\Facades\Filament;
use Filament\Http\Responses\Auth\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
            return redirect()->to(Filament::getPanel('adm')->getUrl());
        } elseif ($user->hasAnyRole(['manager', 'employee', 'guest'])) {
            return redirect()->to(Filament::getPanel('wrh')->getUrl());
        } else {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            Session::flush();
            return redirect()->to(Filament::getPanel('app')->getUrl());
        }
        
    }
}
