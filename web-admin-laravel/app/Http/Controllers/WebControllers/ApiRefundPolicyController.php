<?php

namespace App\Http\Controllers\WebControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CMS\RefundPolicyResource;
use App\Models\CMSModels\RefundPolicy;

class ApiRefundPolicyController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
    public function __construct()
    {

    }

    public function allRefundPolicy(Request $request){
        $refund_policy = new RefundPolicyResource(RefundPolicy::first());
        return response($refund_policy);
    }
}
