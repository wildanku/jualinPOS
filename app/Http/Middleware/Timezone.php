<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class Timezone
{
    /**
     * The current logged in user instance
     * @var [type]
     */
    protected $user;

    /**
     * creates an instance of the middleware
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->user = $auth->user();
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        $this->setTimeZone($request);
        return $this->addTimeZoneCookie($request, $next($request));
    }

    /**
     * sets the time zone from cookie or from the user setting
     * @param Illuminate\Http\Request $request
     */
    public function setTimeZone($request)
    {
        if($this->user)
        {
            return date_default_timezone_set($this->user->timezone);
        }
    
        $timeZone = $request->cookie('time_zone');

        if($timeZone)
        {
            return date_default_timezone_set($timeZone);
        }
        return;
    }

    /**
     * adds the cookie to response
     * @param Illuminate\Http\Request $request
     * @param Illuminate\Http\Response $response
     */
    public function addTimeZoneCookie($request, $response)
    {
        if(! $request->cookie('time_zone') && ! is_null($this->user))
        {
            return $response->withCookie(cookie('time_zone', $this->user->timezone, 120));
        }
        return $response;
    }
}
