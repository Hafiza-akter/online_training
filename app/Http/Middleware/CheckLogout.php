<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class CheckLogout
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
        if(Session::get('user')){
            // dd(Session::get('user_type'));
            if(Session::get('user_type') === 'trainer'){
                return redirect()->route('trainerView');
            }
            if(Session::get('user_type') === 'trainee'){
                return redirect()->route('trainerView');
            }
        }
        else{
            return $next($request);
        }
    }
}
