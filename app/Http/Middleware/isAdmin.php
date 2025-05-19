<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;
use Illuminate\Support\Facades\Auth;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $admin = Admin::where('user_id',  Auth::user()->id)->exists();
        if(Auth::check() AND $admin){
            return $next($request);
        }
        return redirect()->route('dashboard')->with('error', 'Forbidden');
    }
}
