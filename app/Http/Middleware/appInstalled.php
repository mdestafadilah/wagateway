<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class appInstalled
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
        if(!$request->routeIs('home.install_app') && config('app.installed') !== true)
        {
          return redirect()->route('setting.install_app');
        }
        return $next($request);
    }
}
