<?php

namespace App\Http\Controllers\Auth\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\Customer\ForgotPasswordRequest;
use App\Models\CMSModels\Customer;
use Response;
use Exception;
use Illuminate\Mail\Message;
class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    public function __construct()
    {
        // $this->middleware('auth:customer-api');
        // $this->middleware('scope:customer');
    }
    public function sendResetLinkEmail(ForgotPasswordRequest $request){
      if (auth('customer-api')->check() && auth('customer-api')->user()->tokenCan('customer')) {
        $response = generateResponse('',false,'You are already Logged In',[],'object');
        return $response;
      }
      $email = $request->only('email');
      $customer = Customer::where('email',$email)->first();
      $response = Password::broker('customers')->sendResetLink($email);
      if($response == Password::INVALID_USER){
        $response = generateResponse('',false,'Invalid User',[],'object');
        return $response;
      }
      if($response == Password::RESET_LINK_SENT){
        $response = generateResponse('',true,'Email Sended Successfully',[],'object');
        return $response;
      }
      // can use try ccatch for else case
    }
}
