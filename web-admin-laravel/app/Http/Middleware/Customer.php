<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Customer
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
      if (auth('customer-api')->check() && auth('customer-api')->user()->tokenCan('customer')) {
        return $next($request);
      }
      else{
        return response()->json(['message' => 'unauthenticated'],401);
      }
    }
}
