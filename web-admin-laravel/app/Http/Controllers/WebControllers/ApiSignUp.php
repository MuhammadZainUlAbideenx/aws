<?php

namespace App\Http\Controllers\WebControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\CMSModels\Customer;
use App\Http\Resources\Web\CustomerResource;
use App\Http\Requests\Web\CustomerSignUp\CustomerSignUp;
use Carbon\Carbon;
use Hash;


class ApiSignUp extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
    public function __construct()
    {

    }
    public function registerCustomer(CustomerSignUp $request){
      $customer = new Customer();
      $data = $request->all();
      $hashed_password = Hash::make($request->password);
      $data['password'] = $hashed_password;
      $data['is_active'] = true;
      $customer = $customer->create($data);
       return response(["message" => trans('messages.response.signup.signup_success')]);
    }

}
