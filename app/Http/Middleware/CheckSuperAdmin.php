<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSuperAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        foreach ($user->roles as $role) {
            if ($role->name == 'super_admin') {
                return $next($request);
            }
        }
        Auth::logout($user);
        return redirect('/')->with('error', 'Unauthorized access to admin panel');
    }
}
