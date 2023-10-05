<?php

namespace App\Http\Controllers\Auth\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\Vendor\LoginRequest;
use App\Http\Requests\Auth\Vendor\SocialLoginRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Auth\VendorResource;
use App\Models\Vendor;
use Hash;
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
        $this->middleware('auth:vendor-api')->only('logout');
        // $this->middleware('scope:vendor');
    }

    public function login(LoginRequest $request){
      $vendor = Vendor::where('email', $request->email)->first();
      if ($vendor) {
          if (auth()->guard('vendor')->attempt($request->only(['email','password']))) {
            $vendor = auth()->guard('vendor')->user();
            $success['user'] =new VendorResource($vendor);
            $success['token'] =  $vendor->createToken('MyApp',['vendor'])->accessToken;
            $response = generateResponse($success,true,'successfully logged in',[],'object');
            return response()->json($response, 200);
          } else {
            $response = generateResponse([],false,'given data was invalid',['password' => ["Password mismatch"]],'object');
              return response()->json($response, 422);
          }
      } else {
        $response = generateResponse([],false,'invalid login credentials',['email' => ['User does not exist for this email or user is inactive']],'object');
          return response()->json($response, 422);
      }
    }

    public function socialLogin(SocialLoginRequest $request)
    {
        if($request->social_type == 'google')
        {
            $vendor = Vendor::where('email', $request->email)->where('google_id', $request->google_id)->first();
            if ($vendor)
            {
                $success['user'] =new VendorResource($vendor);
                $success['token'] =  $vendor->createToken('MyApp',['vendor'])->accessToken;
                // dd($success['token']);
                $response = generateResponse($success,true,'successfully logged in',[],'object');
                return response()->json($response, 200);
            }
            else
            {
                $vendor = Vendor::create(['name' => $request->name,
                'email' => $request->email,
                'google_id' => $request->google_id ]);
                if($vendor)
                {
                   $success['user'] =new VendorResource($vendor);
                   $success['token'] =  $vendor->createToken('MyApp',['vendor'])->accessToken;
                   $response = generateResponse($success,true,'successfully logged in',[],'object');
                   return response()->json($response, 200);
                }
            }
        }
        if($request->social_type == 'facebook')
        {
            $vendor = Vendor::where('email', $request->email)->where('facebook_id', $request->facebook_id)->first();
            if ($vendor)
            {
                $success['user'] =new VendorResource($vendor);
                $success['token'] =  $vendor->createToken('MyApp',['vendor'])->accessToken;
                // dd($success['token']);
                $response = generateResponse($success,true,'successfully logged in',[],'object');
                return response()->json($response, 200);
            }
            else
            {
                $vendor = Vendor::create(['name' => $request->name,
                'email' => $request->email,
                'facebook_id' => $request->facebook_id ]);
                if($vendor)
                {
                   $success['user'] =new VendorResource($vendor);
                   $success['token'] =  $vendor->createToken('MyApp',['vendor'])->accessToken;
                   $response = generateResponse($success,true,'successfully logged in',[],'object');
                   return response()->json($response, 200);
                }
            }
        }
        else
        {
            $response = generateResponse(false,'Invalid Social Type',[],'object');
            return response()->json($response, 200);
        }

    }

    public function logout(){
        Auth::guard('vendor-api')->user()->token()->revoke();
        $response = generateResponse([],true,'user successfully logged out',[],'object');
          return response()->json($response, 200);

    }
}
