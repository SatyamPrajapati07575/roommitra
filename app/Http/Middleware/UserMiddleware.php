<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('login.form')->with('error', 'Please login to continue');
        }
       
        // Check if user has 'user' role
        if (Auth::user()->role === 'user') {
            return $next($request);
        }
        
        // If owner, redirect to owner dashboard
        if (Auth::user()->role === 'owner') {
            return redirect()->route('owner.dashboard')->with('info', 'You are logged in as owner');
        }
        
        // If admin, redirect to admin dashboard  
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('info', 'You are logged in as admin');
        }
        
        // If none of the above, logout and redirect to login
        Auth::logout();
        return redirect()->route('login.form')->with('error', 'Invalid user role. Please contact support.');
    }
}
