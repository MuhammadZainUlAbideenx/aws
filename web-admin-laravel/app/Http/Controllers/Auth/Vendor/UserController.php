<?php

namespace App\Http\Controllers\Auth\Vendor;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Admin\UserRequest;
use App\Http\Resources\Auth\VendorResource;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:vendor-api');
    }

    public function show()
    {
      $user = new VendorResource(Auth::guard('vendor-api')->user());
      $response = generateResponse($user,$user ? true:false,'',[],'object');
        return $response;
    }
    public function update(UserRequest $request)
    {
        $admin = Auth::guard('vendor-api')->user();
        $admin->update($request->only('name', 'email', 'password'));
        return new VendorResource($admin);
    }
    public function updateVendorPassword (Request $request){
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|min:8',
        ]);
        if ($validator->fails()) {
            $response = generateResponse('',false,'',$validator->errors(),'object');
            return $response;
        }

        $vendor = Auth::user();
        $hashedPassword = $vendor->password;

        if (!Hash::check($request->old_password,$hashedPassword)) {
            $message = trans('messages.response.web.password_does_not_match');
             $response = generateResponse('',false,$message,[],'object');
               return $response;
        }
        $vendor->password = Hash::make($request->password);
        $data['password'] = $vendor->password;
        $vendor = $vendor->update($data);
        $message = trans('messages.response.web.password_successfully_updated');
        $response = generateResponse('',true,$message,[],'object');
        return $response;


        // $hashed_pass = Hash::make($request->password);
        // $data['password'] = $hashed_pass;
        // $vendor = $vendor->update($data);
        // $message = 'Password has been changed successfuly';
        // $response = generateResponse('',true,$message,[],'object');
        // return $response;
      }


    public function destroy()
    {
        Auth::guard('vendor-api')->user()->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
