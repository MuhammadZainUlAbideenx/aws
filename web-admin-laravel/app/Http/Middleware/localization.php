<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class localization
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
      $default_language = defaultLanguage();
      if($request->cookie('i18n_redirected') || $request->header('i18n_redirected')){
        if($request->header('i18n_redirected')){
          $local = $request->header('i18n_redirected');
        }
        else{
          $local = $request->cookie('i18n_redirected');
        }
      }
      else{
        $local = $default_language->code;
      }
      session(['default_language' => $default_language]);
       // set laravel localization
       app()->setLocale($local);
      // continue request
      return $next($request);
    }
}
