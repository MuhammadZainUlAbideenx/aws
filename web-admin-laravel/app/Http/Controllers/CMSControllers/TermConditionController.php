<?php
namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\TermCondition;
use App\Http\Requests\CMS\TermCondition\CreateRequest;
use App\Http\Resources\CMS\TermConditionResource;
class TermConditionController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
      $this->middleware('auth:api');
      $this->middleware('permission:term_condition.index,guard:api');
      $this->middleware('permission:term_condition.create,guard:api',['only' => ['store']]);
      $this->middleware('permission:term_condition.update,guard:api',['only' => ['update']]);
      $this->middleware('permission:term_condition.delete,guard:api',['only' => ['destroy']]);
      $this->middleware('permission:term_condition.update|term_condition.is_active,guard:api',['only' => ['updateStatus']]);
  }



  /********* FETCH ALL NewsCategories ***********/
    public function index()
    {
    $term_condition = new TermConditionResource(TermCondition::first());
        return response($term_condition);
    }


    /********* ADD NEW NewsCategory ***********/
    public function store(CreateRequest $request)
    {
      $termConditionFind = TermCondition::truncate();
      $term_condition = TermCondition::create($request->all());
      return response(["message" => trans('messages.response.term_condition.create_success')]);
    }

}
