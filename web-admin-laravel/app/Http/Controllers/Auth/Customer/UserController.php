<?php

namespace App\Http\Controllers\Auth\Customer;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Customer\UserRequest;
use App\Http\Resources\Auth\CustomerResource;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Hash;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:customer-api');
    }

    public function show()
    {
      $user = new CustomerResource(Auth::guard('customer-api')->user());
      $response = generateResponse($user,$user ? true:false,'',[],'object');
        return $response;
    }
    public function update(UserRequest $request)
    {
        $customer = Auth::guard('customer-api')->user();
        $customer->update($request->only('name', 'email', 'password'));
        return new CustomerResource($customer);
    }

    public function updateCustomerPassword (Request $request){
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|min:8',
        ]);
        if ($validator->fails()) {
            $response = generateResponse('',false,'',$validator->errors(),'object');
            return $response;
        }

        $customer = Auth::user();
        $hashedPassword = $customer->password;

        if (!Hash::check($request->old_password,$hashedPassword)) {
            $message = trans('messages.response.web.password_does_not_match');
             $response = generateResponse('',false,$message,[],'object');
               return $response;
        }
        $customer->password = Hash::make($request->password);
        $data['password'] = $customer->password;
        $customer = $customer->update($data);
        $message =  trans('messages.response.web.password_successfully_updated');
        $response = generateResponse('',true,$message,[],'object');
        return $response;

      }

    public function destroy()
    {
        Auth::guard('customer-api')->user()->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
