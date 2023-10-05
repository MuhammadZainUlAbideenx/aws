<?php

namespace App\Http\Controllers\WebControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CMS\PrivacyPolicyResource;
use App\Models\CMSModels\PrivacyPolicy;

class ApiPrivacyPolicyController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
    public function __construct()
    {

    }


    public function allPrivacyPolicy(Request $request){
        $privacy_policy = new PrivacyPolicyResource(PrivacyPolicy::first());
        return response($privacy_policy);
    }
}
