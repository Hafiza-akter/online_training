<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class CheckLogin
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
            
            return $next($request);
        }
        else{

            if(Session::get('user_type') === 'trainer'){
                return redirect()->route('trainerLogin');
            }
            if(Session::get('user_type') === 'trainee'){
                return redirect()->route('traineeLogin');
            }
        }    
    }
}
