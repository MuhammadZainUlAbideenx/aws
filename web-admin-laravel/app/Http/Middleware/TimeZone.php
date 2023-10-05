<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Timezone
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
      $timezone = timezone();
      if($timezone)
      {
        config(['app.timezone' => $timezone]);
      }
      date_default_timezone_set($timezone);
      // continue request
      return $next($request);
    }
}
