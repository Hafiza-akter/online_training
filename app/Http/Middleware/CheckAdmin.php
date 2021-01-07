<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class CheckAdmin
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
        $user = Session::get('user');
        $is_admin = Session::get('is_admin');
        // dd($user->is_super_admin);
        if($is_admin == 1 || $is_admin == 2){
            return $next($request);
        }
        else{
            return redirect()->route('home');
        }
    }
}
