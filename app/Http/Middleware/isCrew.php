<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Crew;
use Illuminate\Support\Facades\Auth;

class isCrew
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $crew = Crew::where('user_id',  Auth::user()->id)->exists();
        if(Auth::check() AND $crew){
            return $next($request);
        }
        return redirect()->route('dashboard')->with('error', 'Forbidden');
    }
}
