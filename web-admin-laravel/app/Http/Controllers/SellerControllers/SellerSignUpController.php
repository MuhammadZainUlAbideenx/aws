<?php

namespace App\Http\Controllers\SellerControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Http\Resources\Web\CustomerResource;
use App\Http\Requests\Vendor\VendorSignUp\VendorSignUp;
use Carbon\Carbon;
use Hash;
use Str;


class SellerSignUpController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
    public function __construct()
    {

    }
    public function registerVendor(VendorSignUp $request){
      $customer = new Vendor();
      $data = $request->all();
      $slug = Str::slug($request->name);
      $data["slug"] = $slug;
      $hashed_password = Hash::make($request->password);
      $data['password'] = $hashed_password;
      $data['is_active'] = false;
      $customer = $customer->create($data);
       return response(["message" => trans('messages.response.signup.signup_success')]);
    }

}
