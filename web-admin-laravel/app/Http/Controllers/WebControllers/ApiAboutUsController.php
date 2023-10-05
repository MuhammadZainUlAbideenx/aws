<?php

namespace App\Http\Controllers\WebControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CMS\AboutUsResource;
use App\Models\CMSModels\AboutUs;

class ApiAboutUsController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
    public function __construct()
    {

    }


    public function allAboutUs(Request $request){
        $about_us = new AboutUsResource(AboutUs::first());
        return response($about_us);
    }
}
