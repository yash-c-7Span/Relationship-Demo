<?php

namespace App\Http\Middleware;

use App\Exceptions\CustomException;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $auth = auth()->user();
        if(!empty($auth) && $auth->role == User::ADMIN_ROLE){
            return $next($request);
        } 
        throw new CustomException("Page Not Found.");
    }
}
