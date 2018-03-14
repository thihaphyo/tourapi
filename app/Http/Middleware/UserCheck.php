<?php

namespace App\Http\Middleware;

use Closure;

class UserCheck
{
    /**
     * Handle an Route Skip.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(count(\Session::get('User')) == 0)
        {   
            return redirect('/');

        }else{
            return $next($request);
        }    
        
    }
}
