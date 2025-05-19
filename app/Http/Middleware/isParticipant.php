<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Participant;
use Illuminate\Support\Facades\Auth;

class isParticipant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $participant = Participant::where('user_id',  Auth::user()->id)->exists();
        if(Auth::check() AND $participant){
            return $next($request);
        }
        return redirect()->route('dashboard')->with('error', 'Forbidden');
    }
}
