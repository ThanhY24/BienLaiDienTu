<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            if(Auth::user()->role == "QTV"){
                return $next($request);
            }else{
                return redirect("/home")->with('message', 'Chức năng này chỉ dành cho quản trị viên.')->with('type', 'ERR');
            }
        }else{
            return redirect('/login');
        }
    }
}
