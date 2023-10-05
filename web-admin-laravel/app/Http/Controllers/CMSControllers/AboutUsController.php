<?php
namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\AboutUs;
use App\Http\Requests\CMS\AboutUs\CreateRequest;
use App\Http\Resources\CMS\AboutUsResource;
class AboutUsController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
      $this->middleware('auth:api');
      $this->middleware('permission:about_us.index,guard:api');
      $this->middleware('permission:about_us.create,guard:api',['only' => ['store']]);
      $this->middleware('permission:about_us.update,guard:api',['only' => ['update']]);
      $this->middleware('permission:about_us.delete,guard:api',['only' => ['destroy']]);
      $this->middleware('permission:about_us.update|about_us.is_active,guard:api',['only' => ['updateStatus']]);
  }



  /********* FETCH ALL NewsCategories ***********/
    public function index()
    {
    $about_us = new AboutUsResource(AboutUs::first());
        return response($about_us);
    }


    /********* ADD NEW NewsCategory ***********/
    public function store(CreateRequest $request)
    {
      $aboutUsFind = AboutUs::truncate();
      $about_us = AboutUs::create($request->all());
      return response(["message" => trans('messages.response.about_us.create_success')]);
    }

}
