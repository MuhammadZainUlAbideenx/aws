<?php

namespace App\Http\Controllers\WebControllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\CMS\Newsletters\CreateRequest;
use App\Models\CMSModels\Newsletter;

class ApiNewslettersController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
    public function __construct()
    {

    }
    public function create(CreateRequest $request)
    {
        $data = [];
        $data['email'] = $request->email;
        $data['is_active']= 1;
        $data['is_verified'] = 1;
      $newsletter = Newsletter::create($data);
      $response = generateResponse('',true,trans('messages.response.web.email_added_subscription'),[],'object');
      return response($response);
    }

}
