<?php
namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\PrivacyPolicy;
use App\Http\Requests\CMS\PrivacyPolicy\CreateRequest;
use App\Http\Resources\CMS\PrivacyPolicyResource;
class PrivacyPolicyController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
      $this->middleware('auth:api');
      $this->middleware('permission:privacy_policy.index,guard:api');
      $this->middleware('permission:privacy_policy.create,guard:api',['only' => ['store']]);
      $this->middleware('permission:privacy_policy.update,guard:api',['only' => ['update']]);
      $this->middleware('permission:privacy_policy.delete,guard:api',['only' => ['destroy']]);
      $this->middleware('permission:privacy_policy.update|privacy_policy.is_active,guard:api',['only' => ['updateStatus']]);
  }



  /********* FETCH ALL NewsCategories ***********/
    public function index()
    {
    $privacy_policy = new PrivacyPolicyResource(PrivacyPolicy::first());
        return response($privacy_policy);
    }


    /********* ADD NEW NewsCategory ***********/
    public function store(CreateRequest $request)
    {
      $privacyPolicyFind = PrivacyPolicy::truncate();
      $privacy_policy = PrivacyPolicy::create($request->all());
      return response(["message" => trans('messages.response.privacy_policy.create_success')]);
    }

}
