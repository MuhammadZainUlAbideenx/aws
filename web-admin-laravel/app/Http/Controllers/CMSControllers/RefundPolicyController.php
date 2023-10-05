<?php
namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\RefundPolicy;
use App\Http\Requests\CMS\RefundPolicy\CreateRequest;
use App\Http\Resources\CMS\RefundPolicyResource;
class RefundPolicyController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
      $this->middleware('auth:api');
      $this->middleware('permission:refund_policy.index,guard:api');
      $this->middleware('permission:refund_policy.create,guard:api',['only' => ['store']]);
      $this->middleware('permission:refund_policy.update,guard:api',['only' => ['update']]);
      $this->middleware('permission:refund_policy.delete,guard:api',['only' => ['destroy']]);
      $this->middleware('permission:refund_policy.update|refund_policy.is_active,guard:api',['only' => ['updateStatus']]);
  }



  /********* FETCH ALL NewsCategories ***********/
    public function index()
    {
    $refund_policy = new RefundPolicyResource(RefundPolicy::first());
        return response($refund_policy);
    }


    /********* ADD NEW NewsCategory ***********/
    public function store(CreateRequest $request)
    {
      $refundPolicyFind = RefundPolicy::truncate();
      $refund_policy = RefundPolicy::create($request->all());
      return response(["message" => trans('messages.response.refund_policy.create_success')]);
    }

}
