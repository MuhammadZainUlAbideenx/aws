<?php

namespace App\Http\Controllers\WebControllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\CMS\ContactForms\CreateRequest;
use App\Models\CMSModels\ContactForm;

class ApiContactFormController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
    public function __construct()
    {

    }
    public function create(CreateRequest $request)
    {

      $contact_form = ContactForm::create($request->all());
      $response = generateResponse('',true,trans('messages.response.web.request_submitted'),[],'object');
      return response($response);

    }

}
