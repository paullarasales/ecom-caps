<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class User
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //if not loggen in
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = Auth::user()->usertype;

        //ADMIN
        if ($userRole == "admin") {
            return redirect()->route('admindashboard');
        }

        //MANAGER
        elseif ($userRole == "manager") {
            return redirect()->route('managerdashboard');
        }

        //MANAGER
        elseif ($userRole == "owner") {
            return redirect()->route('ownerdashboard');
        }

        elseif ($userRole == "user") {
            return $next($request);
        }
    }
}
