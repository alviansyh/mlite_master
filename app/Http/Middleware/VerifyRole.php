<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class VerifyRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            Auth::logout();
            return redirect(url('/'));
        }

        // if (! Auth::check() || Auth::user()->role !== $role) {
        //     // Optionally, you can redirect to a specific page or return a 403 response
        //     abort(403, 'Unauthorized action.');
        // }

        return $next($request);

        // dd(Auth::user());
        // if (Auth::user() && Auth::user()->hasRole('admin')) {
            // return $next($request);
        // }

        // abort(403, 'You are not allowed to access this page');
    }
}
