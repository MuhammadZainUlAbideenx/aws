<?php

namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\AttributeValue;
use App\Models\CMSModels\Product;
use App\Models\CMSModels\AttributeValueCombination;
use App\Http\Requests\CMS\AttributeValues\CreateRequest;
use App\Http\Resources\CMS\AttributeValuesResource;
use Excel;
use App\Exports\CMS\AttributeValuesExport;
class AttributeValuesController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
      $this->middleware('auth:api');
      $this->middleware('permission:attribute_values.index,guard:api');
      $this->middleware('permission:attribute_values.create,guard:api',['only' => ['store']]);
      $this->middleware('permission:attribute_values.update,guard:api',['only' => ['update']]);
      $this->middleware('permission:attribute_values.delete,guard:api',['only' => ['destroy']]);
      $this->middleware('permission:attribute_values.update|attribute_values.is_active,guard:api',['only' => ['updateStatus']]);
  }

  /********* Getter For Pagination, Searching And Sorting  ***********/
  public function getter($req = null,$export = null)
  {
    if($req != null){
      $attribute_values = new AttributeValue;
      if($req->column && $req->column != null && $req->search && $req->search != null){
        if($req->column == 'name'){
          $attribute_values = $attribute_values->whereLike($req->column.'->'.app()->getLocale(),$req->search);
        }
        else{
          $attribute_values = $attribute_values->whereLike($req->column,$req->search);
          }
        }
       else if($req->search && $req->search != null){
            $attribute_values = $attribute_values->whereLike(['name->'.app()->getLocale()],$req->search);
        }
      if($req->sort !=null && $req->sort["field"] != null && $req->sort["type"] != null){
        $attribute_values = $attribute_values->OrderBy($req->sort["field"],$req->sort["type"]);
      }
      if($export != null){ // for export do not paginate
        $attribute_values = $attribute_values->get();
        return $attribute_values;
      }
      $totalAttributeValues = $attribute_values->count();
      $attribute_values = $attribute_values->paginate($req->perPage);
      $attribute_values = AttributeValuesResource::collection($attribute_values)->response()->getData(true);
      return $attribute_values;
    }
    $attribute_values = AttributeValuesResource::collection(AttributeValue::orderBy('id','desc')->paginate(10))->response()->getData(true);
    return $attribute_values;
  }

  /********* FETCH ALL AttributeValues ***********/
    public function index()
    {
        $arrayName = array('attribute_values' => $this->getter());
        return response($arrayName);
    }
      /********* Export PDF , CSV And Excel  **********/
    public function export(Request $request)
    {
        $attribute_values = $this->getter($request,"export");
        $filename = "attribute_values.".$request->export;
        return Excel::download(new AttributeValuesExport($attribute_values), $filename);
    }

  /********* FILTER AttributeValues FOR Search ***********/
   public function filter(Request $request){
       return response()->json(["state" => "success", "message" => trans('messages.response.attribute_values.filter_success'),"attribute_values" => $this->getter($request)] );
   }

    /********* ADD NEW AttributeValue ***********/
    public function store(CreateRequest $request)
    {
      $attribute_value = AttributeValue::create($request->all());
      AttributeValueCombination::create([
                                        'attribute_id' => $attribute_value->attribute_id,
                                        'attribute_value_id' => $attribute_value->id,
                                        'combination_id' => $attribute_value->attribute_id.$attribute_value->id
                                      ]);
      return response(["message" => trans('messages.response.attribute_values.create_success')]);
    }

    /********* View RECORD TO EDIT Or Display ***********/
    public function show(AttributeValue $attribute_value)
    {
        return new AttributeValuesResource($attribute_value);
    }

    /********* UPDATE AttributeValue ***********/
    public function update(CreateRequest $request, AttributeValue $attribute_value)
    {
      $old_combination_id = $attribute_value->attribute_id.$attribute_value->id;
      $new_combination_id = $request->attribute_id.$attribute_value->id;
      if((int)$old_combination_id != (int)$new_combination_id){
        $products = Product::with('attributes')->whereHas('attributes',function($q) use ($old_combination_id){
          $q->where('combination_id',$old_combination_id);
        })->get();
        if(count($products) > 0){
          return response(["message" => trans('messages.response.attribute_values.attribute_attached_to_product')],422);
        }
      }
      $attribute_value->update($request->all());
      AttributeValueCombination::where('attribute_Value_id',$attribute_value->id)->update([
                                        'attribute_id' => $attribute_value->attribute_id,
                                        'attribute_value_id' => $attribute_value->id,
                                        'combination_id' => $new_combination_id
                                      ]);

        return response(["message" => trans('messages.response.attribute_values.update_success')]);

    }

    /********* UPDATE AttributeValue Status***********/
    public function updateStatus(Request $request,AttributeValue $attribute_value){
        $attribute_value->update([
          'is_active' => $attribute_value->is_active == 1 ? 0:1
        ]);
        return response()->json(["state" => "success", "message" => trans('messages.response.attribute_values.update_status_success'),"attribute_values" => $this->getter($request)] );
    }


    /********* DELETE LANGUAGE ***********/
    public function destroy(Request $request,AttributeValue $attribute_value)
    {
      $old_combination_id = $attribute_value->attribute_id.$attribute_value->id;
        $products = Product::with('attributes')->whereHas('attributes',function($q) use ($old_combination_id){
          $q->where('combination_id',$old_combination_id);
        })->get();
        if(count($products) > 0){
          return response(["message" => trans('messages.response.attribute_values.attribute_attached_to_product')],422);
        }
          $attribute_value->delete();
          return response()->json(["state" => "success", "message" => trans('messages.response.attribute_values.delete_success'),"attribute_values" => $this->getter($request)] );
    }
}
