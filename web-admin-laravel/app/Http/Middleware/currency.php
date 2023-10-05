<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class currency
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
      $default_currency = defaultCurrency();
      if($request->cookie('currency') || $request->header('currency')){
        if($request->header('currency')){
          $local = $request->header('currency');
        }
        else{
          $local = $request->cookie('currency');
        }
        $current_currency = currentCurrency($local);
        if(!$current_currency){
          $current_currency = $default_currency;
        }
      }
      else{
        $current_currency = $default_currency;
        $local = $default_currency->code;
      }
      session(['default_currency' => $default_currency]);
      session(['current_currency' => $current_currency]);

       // set laravel currency
       config(['custom.currency' => $local]);
      // continue request
      return $next($request);
    }
}
