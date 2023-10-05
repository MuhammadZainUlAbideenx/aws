<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaravelController
{
    public function index(Request $request){
      if(config('custom.mode') == 'spa'){
        return file_get_contents(public_path('_nuxt/index.html'));
      }
      else{
          return response()->json(['msg' => 'not spa']);
      }
    }
}
