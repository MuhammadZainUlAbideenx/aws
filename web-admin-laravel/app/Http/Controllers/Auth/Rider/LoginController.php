<?php

namespace App\Http\Controllers\Auth\Rider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\Rider\LoginRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Auth\RiderResource;
use App\Models\Rider;
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
        $this->middleware('auth:rider-api')->only('logout');
    }

    public function login(LoginRequest $request){
      $rider = Rider::where('email', $request->email)->where('is_active',1)->WithAll()->first();
      if ($rider) {
          if (auth()->guard('rider')->attempt($request->only(['email','password']))) {
            // $rider = auth()->guard('rider')->user();
            $success['user'] =new RiderResource($rider);
            $success['token'] =  $rider->createToken('MyApp',['rider'])->accessToken;
            $response = generateResponse($success,true,trans('messages.response.web.logged_in'),[],'object');
            return response()->json($response, 200);
          } else {
            $response = generateResponse([],false,trans('messages.response.web.given_data_invalid'),['password' => ["Password mismatch"]],'object');
              return response()->json($response, 422);
          }
      } else {
        $response = generateResponse([],false,trans('messages.response.web.invalid_login_credentials'),['email' => ['User does not exist for this email or user is inactive']],'object');
          return response()->json($response, 422);
      }
    }

    public function updateRiderPassword (Request $request){
        // dd('ssd');
        $rules = [
            'password' => 'required|min:8',
        ];

        $validator = Validator::make($request->all(),$rules);
        $vendor = Auth::user();
    //    $vendor = Vendor::find(auth()->user()->id);
    //    $vendor = Vendor::find(Auth::guard('vendor-api')->user()->id);
    //    dd($vendor);
           $hashed_pass = Hash::make($request->password);
           $data['password'] = $hashed_pass;

        $vendor = $vendor->update($data);
        $message = trans('messages.response.web.password_successfully_updated');
        $response = generateResponse('',true,$message,[],'object');
        return $response;
      }


    public function logout(){
        Auth::guard('rider-api')->user()->token()->revoke();
        $response = generateResponse([],true,trans('messages.response.web.logged_in'),[],'object');
          return response()->json($response, 200);

    }
}
