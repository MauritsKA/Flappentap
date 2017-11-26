<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Company;

class Checkcompany
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
         if (Auth::user()->balances->find($request->balance->id) != null )
		{
			return $next($request);
		}
        
        return redirect('/');
    }
}
