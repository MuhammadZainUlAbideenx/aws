<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\CMSModels\Setting;
use Illuminate\Support\Facades\App;

class verifyApplicationAuthenticated
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
      if(App::environment() == 'production'){
        $consumer_key = $request->header('Consumer-Key');
        $consumer_secret = $request->header('Consumer-Secret');
        $key = "thankyou";
        $settings =  Setting::whereIn('name',['consumer_key','consumer_secret'])->select('name','value')->pluck('value','name')->toArray();
        $db_consumer_key = hash_hmac('sha256',md5($settings['consumer_key']),$key);
        $db_consumer_secret = hash_hmac('sha256',md5($settings['consumer_secret']),$key);
          if($db_consumer_key == $consumer_key && $db_consumer_secret == $consumer_secret){
            return $next($request);
          }
          else{
            return response()->json(['message' => 'invalid client'],403);
          }
      }
      return $next($request);

      // continue request
    }
}
