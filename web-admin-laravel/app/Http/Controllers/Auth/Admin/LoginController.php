<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\Admin\LoginRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Auth\AdminResource;
use App\Models\CMSModels\Admin;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth:admin-api')->only('logout');
    }

    public function login(LoginRequest $request){

      $admin = Admin::where('email', $request->email)->where('is_active',1)->first();
      if ($admin && (($admin->role && $admin->role->is_active) || $admin->hasRole('super_admin'))) {
          if (auth()->guard('admin')->attempt($request->only(['email','password']))) {
            $admin = auth()->guard('admin')->user();
            $success['user'] =new AdminResource($admin);
            $success['token'] =  $admin->createToken('MyApp',['admin'])->accessToken;
            $response = generateResponse($success,true,trans('messages.response.web.logged_in'),[],'object');
            return response()->json($response, 200);
          } else {
            $response = generateResponse([],false,trans('messages.response.web.given_data_invalid'),['password' => [trans('messages.response.web.password_mismatch')]],'object');
              return response()->json($response, 422);
          }
      } else {
        $response = generateResponse([],false,trans('messages.response.web.invalid_login_credentials'),['email' => [trans('messages.response.web.user_does_not_exist')]],'object');
          return response()->json($response, 422);
      }
    }
    public function logout(){
        Auth::guard('admin-api')->user()->token()->revoke();
        $response = generateResponse([],true,trans('messages.response.web.user_logout'),[],'object');
          return response()->json($response, 200);

    }
}
