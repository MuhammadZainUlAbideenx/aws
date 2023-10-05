<?php

namespace App\Http\Controllers\Auth\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\Customer\LoginRequest;
use App\Http\Requests\Auth\Customer\SocialLoginRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Auth\CustomerResource;
use App\Models\CMSModels\Customer;
use Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\CMSModels\Cart;
use Illuminate\Support\Facades\Http;

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
    public $headers;
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth:customer-api')->only('logout');
    }

    public function login(LoginRequest $request){
        // $response = generateResponse($request->cookie('session_token'),false,'successfully logged in',[],'object');
        // return response()->json($response, 422);
      $customer = Customer::where('email', $request->email)->where('is_active',1)->first();
      if ($customer && $customer->is_active) {
          if (auth()->guard('customer')->attempt($request->only(['email','password']))) {
            $customer = auth()->guard('customer')->user();
            // local cart merge with customer cart
            $session_token = $request->cookie('session_token');
            $cart_items = Cart::where('session_token',$session_token)->where('is_ordered',0)->get();
            if($cart_items){
              if($customer->cartItems){
                foreach ($cart_items as $item) {
                  $customer_cart_item = $customer->cartItems()->where('is_ordered',0)->where('product_id',$item->product_id)->where('variant',$item->variant)->first();
                  if($customer_cart_item){
                    $customer_cart_item->attribute_value_names()->delete();
                    $customer_cart_item->delete();
                    Cart::where('id',$item->id)->update(['session_token' => null,'customer_id' => $customer->id]);
                  }
                  else{
                      Cart::where('id',$item->id)->update(['session_token' => null,'customer_id' => $customer->id]);
                  }
                }
              }
              else{
                Cart::where('session_token',$session_token)->update(['session_token' => null,'customer_id' => $customer->id]);
              }
            }

            $success['user'] =new CustomerResource($customer);
            $success['token'] =  $customer->createToken('MyApp',['customer'])->accessToken;
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

    public function socialLogin (SocialLoginRequest $request)
    {
       if($request->social_type == 'google')
       {
        $customer = Customer::where('email', $request->email)->first();

        if ($customer && $customer->google_id == $request->google_id)
        {
            // local cart merge with customer cart
              $session_token = $request->cookie('session_token');
            //   dd($session_token);
              $cart_items = Cart::where('session_token',$session_token)->where('is_ordered',0)->get();
              if($cart_items)
              {
                if($customer->cartItems)
                {
                  foreach ($cart_items as $item)
                  {
                    $customer_cart_item = $customer->cartItems()->where('is_ordered',0)->where('product_id',$item->product_id)->where('variant',$item->variant)->first();
                    if($customer_cart_item)
                    {
                      $customer_cart_item->attribute_value_names()->delete();
                      $customer_cart_item->delete();
                      Cart::where('id',$item->id)->update(['session_token' => null,'customer_id' => $customer->id]);
                    }
                    else
                    {
                        Cart::where('id',$item->id)->update(['session_token' => null,'customer_id' => $customer->id]);
                    }
                  }
                }
                else
                {
                  Cart::where('session_token',$session_token)->update(['session_token' => null,'customer_id' => $customer->id]);
                }
              }

              $success['user'] =new CustomerResource($customer);
              $success['token'] =  $customer->createToken('MyApp',['customer'])->accessToken;
              $response = generateResponse($success,true,trans('messages.response.web.logged_in'),[],'object');
              return response()->json($response, 200);
        }
        else
        {
           $customer = Customer::create(['name' => $request->name,
           'first_name' => $request->first_name,
           'last_name' => $request->last_name,
           'email' => $request->email,
           'google_id' => $request->google_id ]);
           if($customer)
           {
              // local cart merge with customer cart
              $session_token = $request->cookie('session_token');
              $cart_items = Cart::where('session_token',$session_token)->where('is_ordered',0)->get();
              if($cart_items)
              {
                if($customer->cartItems)
                {
                  foreach ($cart_items as $item)
                  {
                    $customer_cart_item = $customer->cartItems()->where('is_ordered',0)->where('product_id',$item->product_id)->where('variant',$item->variant)->first();
                    if($customer_cart_item)
                    {
                      $customer_cart_item->attribute_value_names()->delete();
                      $customer_cart_item->delete();
                      Cart::where('id',$item->id)->update(['session_token' => null,'customer_id' => $customer->id]);
                    }
                    else
                    {
                        Cart::where('id',$item->id)->update(['session_token' => null,'customer_id' => $customer->id]);
                    }
                  }
                }
                else
                {
                  Cart::where('session_token',$session_token)->update(['session_token' => null,'customer_id' => $customer->id]);
                }
              }

              $success['user'] =new CustomerResource($customer);
              $success['token'] =  $customer->createToken('MyApp',['customer'])->accessToken;
              $response = generateResponse($success,true,trans('messages.response.web.logged_in'),[],'object');
              return response()->json($response, 200);
           }
        }
       }
       else if($request->social_type == 'facebook')
       {
        $customer = Customer::where('email', $request->email)->first();
        if ($customer && $customer->facebook_id == $request->facebook_id)
        {
            // local cart merge with customer cart
              $session_token = $request->cookie('session_token');
            //   dd($session_token);
              $cart_items = Cart::where('session_token',$session_token)->where('is_ordered',0)->get();
              if($cart_items)
              {
                if($customer->cartItems)
                {
                  foreach ($cart_items as $item)
                  {
                    $customer_cart_item = $customer->cartItems()->where('is_ordered',0)->where('product_id',$item->product_id)->where('variant',$item->variant)->first();
                    if($customer_cart_item)
                    {
                      $customer_cart_item->attribute_value_names()->delete();
                      $customer_cart_item->delete();
                      Cart::where('id',$item->id)->update(['session_token' => null,'customer_id' => $customer->id]);
                    }
                    else
                    {
                        Cart::where('id',$item->id)->update(['session_token' => null,'customer_id' => $customer->id]);
                    }
                  }
                }
                else
                {
                  Cart::where('session_token',$session_token)->update(['session_token' => null,'customer_id' => $customer->id]);
                }
              }

              $success['user'] =new CustomerResource($customer);
              $success['token'] =  $customer->createToken('MyApp',['customer'])->accessToken;
              $response = generateResponse($success,true,trans('messages.response.web.logged_in'),[],'object');
              return response()->json($response, 200);
        }
        else
        {
           $customer = Customer::create(['name' => $request->name,
           'first_name' => $request->first_name,
           'last_name' => $request->last_name,
           'email' => $request->email,
           'facebook_id' => $request->facebook_id ]);
           if($customer)
           {
              // local cart merge with customer cart
              $session_token = $request->cookie('session_token');
              $cart_items = Cart::where('session_token',$session_token)->where('is_ordered',0)->get();
              if($cart_items)
              {
                if($customer->cartItems)
                {
                  foreach ($cart_items as $item)
                  {
                    $customer_cart_item = $customer->cartItems()->where('is_ordered',0)->where('product_id',$item->product_id)->where('variant',$item->variant)->first();
                    if($customer_cart_item)
                    {
                      $customer_cart_item->attribute_value_names()->delete();
                      $customer_cart_item->delete();
                      Cart::where('id',$item->id)->update(['session_token' => null,'customer_id' => $customer->id]);
                    }
                    else
                    {
                        Cart::where('id',$item->id)->update(['session_token' => null,'customer_id' => $customer->id]);
                    }
                  }
                }
                else
                {
                  Cart::where('session_token',$session_token)->update(['session_token' => null,'customer_id' => $customer->id]);
                }
              }

              $success['user'] =new CustomerResource($customer);
              $success['token'] =  $customer->createToken('MyApp',['customer'])->accessToken;
              $response = generateResponse($success,true,trans('messages.response.web.logged_in'),[],'object');
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

    public function updateCustomerPassword (Request $request){
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
        $message = 'Password has been changed successfuly';
        $response = generateResponse('',true,$message,[],'object');
        return $response;
      }


    public function logout(){
        Auth::guard('customer-api')->user()->token()->revoke();
        $response = generateResponse([],true,'user successfully logged out',[],'object');
          return response()->json($response, 200);
    }

    public function googleAuthDetails(Request $request)
    {
        $this->headers['Authorization'] = "Bearer ".$request->token ;
        $res = Http::withHeaders($this->headers)->get('https://www.googleapis.com/oauth2/v3/userinfo');
        $details = json_decode($res->body());
        $response = generateResponse($details,true,'Successfully Get Details',[],'object');
        return response()->json($response, 200);
    }
    public function facebookAuthDetails(Request $request)
    {
        $this->headers['Authorization'] = "Bearer ".$request->token ;
        $res = Http::withHeaders($this->headers)->get('https://graph.facebook.com/v6.0/me?fields=id,name,email,first_name,last_name,picture{url}');
        $details = json_decode($res->body());
        $response = generateResponse($details,true,'Successfully Get Details',[],'object');
        return response()->json($response, 200);
    }

}
