<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Balance;

class Checkbalance
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        if($request->balance == null){
            return $next($request);
        }
        
        if (Auth::user()->balances->find($request->balance->id) != null){
            if(Auth::user()->balances->find($request->balance->id)->pivot->archived == 0){
			     return $next($request);
            }
		}
        
        return redirect('/');
    }
}
