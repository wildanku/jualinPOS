<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class SetLocale
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
        $locale = $request->user()->language ?? 'en';
        $tz = $request->user()->timezone ?? 'UTC';
        
        App::SetLocale($locale);
        Carbon::setLocale($locale);
        date_default_timezone_set($tz);
        Config::set('app.timezone',$tz);

        $request->session()->put('locale',$locale);
        return $next($request);
    }
}
