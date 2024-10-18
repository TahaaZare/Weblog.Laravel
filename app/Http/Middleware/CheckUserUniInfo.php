<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserUniInfo
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user->roles != null) {
            foreach ($user->roles as $role) {
                if ($role->name == 'super_admin' || $role->name == 'panel_user') {
                    return $next($request);
                }
            }
        }

        Auth::logout($user);
        return redirect('/')->with('error', 'Unauthorized access to admin panel');

    }
}
