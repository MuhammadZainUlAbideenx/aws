<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class dateFormat
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
      $date_format = dateFormat();
      if($date_format)
      {
        config(['custom.date_format' => $date_format]);
      }
      // continue request
      return $next($request);
    }
}
