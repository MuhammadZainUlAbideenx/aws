<?php

namespace App\Http\Controllers\WebControllers;
use App\Http\Controllers\Controller;
use App\Models\CMSModels\PaymentMethod;
use App\Http\Resources\Web\PaymentMethodsSimpleResource;

class ApiPaymentMethodsController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
    public function __construct()
    {

    }


    public function allPaymentMethods(){
      $payment_methods = PaymentMethod::with('image')->where('is_active', 1)->get();
      $payment_methods = PaymentMethodsSimpleResource::collection($payment_methods);
      $response = generateResponse($payment_methods,count($payment_methods) > 0 ? true:false,'',[],'collection');
      return $response;
    }
}
