<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Coordinator;
use Illuminate\Support\Facades\Auth;

class isCoordinator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $coordinator = Coordinator::where('user_id',  Auth::user()->id)->exists();
        if(Auth::check() AND $coordinator){
            return $next($request);
        }
        return redirect()->route('dashboard')->with('error', 'Forbidden');
    }
}
