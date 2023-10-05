<?php

namespace App\Http\Controllers\Auth\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest:customer-api');
    }
    protected function resetPassword($user, $password)
    {
      if (auth('customer-api')->check() && auth('customer-api')->user()->tokenCan('customer')) {
        $response = generateResponse('',false,'You are already Logged In',[],'object');
        return $response;
      }
        $user->password = Hash::make($password);
        $user->save();
         event(new PasswordReset($user));
    }
    protected function sendResetResponse(Request $request, $response)
    {

      $response = generateResponse('',true,'Password reset successful',[],'object');
      return response($response, 200);
    }
    protected function sendResetFailedResponse(Request $request, $response)
    {
      $message = "Invalid Email Or Token ";
      $response = generateResponse('',false,$message,[],'object');
      return response($response, 401);
    }
        /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    protected function broker(){
        return Password::broker('customers');
    }

    /**
     * Get the guard to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard(){
        return Auth::guard('customer');
    }
}
