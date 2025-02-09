<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle(Request $request, Closure $next, $role): Response
    // {
    //     if (!Auth::check()) {
    //         return redirect('/');
    //     } else if (dd(Auth::user()->role) !== $role) {
    //         return redirect('/dashboard')->with('error', "You don't have access to this page");
    //     }
    //     return $next($request);
    // }
    public function handle(request $request, Closure $next, $role): Response
    {
        if (Auth::check()){
            return redirect('/');
        } else if (dd(Auth::user()->role) !== $role){
            return redirect('/dashboard');
        }
        return $next($request);
    }
}
