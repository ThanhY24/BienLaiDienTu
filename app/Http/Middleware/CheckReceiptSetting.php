<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; 

class CheckReceiptSetting
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->link_services != "" &&
            Auth::user()->link_lookup != "" &&
            Auth::user()->username_services != "" &&
            Auth::user()->password_services != ""
        ) {
            return $next($request);
        }else{
            return redirect("/home")->with('message', 'Bạn phải cấu hình thông tin trước mới vào được biên lai.')->with('type', 'ERR');
        }
    }
}
