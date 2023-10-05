<?php

namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\ShippingMethod;
use App\Models\CMSModels\ShippingMethodSetting;
use App\Http\Requests\CMS\ShippingMethods\CreateRequest;
use App\Http\Resources\CMS\ShippingMethodsResource;
use Excel;
use App\Exports\CMS\ShippingMethodsExport;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Setting;
use PDF;
class ShippingMethodsController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
      $this->middleware('auth:api');
      $this->middleware('permission:shipping_methods.index,guard:api');
      $this->middleware('permission:shipping_methods.create,guard:api',['only' => ['store']]);
      $this->middleware('permission:shipping_methods.update,guard:api',['only' => ['update']]);
      $this->middleware('permission:shipping_methods.delete,guard:api',['only' => ['destroy']]);
      $this->middleware('permission:shipping_methods.update|shipping_methods.is_active,guard:api',['only' => ['updateStatus']]);
  }

  /********* Getter For Pagination, Searching And Sorting  ***********/
  public function getter($req = null,$export = null)
  {
    if($req != null){
      $shipping_methods = new ShippingMethod;
      if($req->column && $req->column != null && $req->search && $req->search != null){
        if($req->column == 'name'){
          $shipping_methods = $shipping_methods->whereLike($req->column.'->'.app()->getLocale(),$req->search);
        }
        else{
          $shipping_methods = $shipping_methods->whereLike($req->column,$req->search);
          }
        }
       else if($req->search && $req->search != null){
            $shipping_methods = $shipping_methods->whereLike(['name->'.app()->getLocale()],$req->search);
        }
      if($req->sort !=null && $req->sort["field"] != null && $req->sort["type"] != null){
        $shipping_methods = $shipping_methods->OrderBy($req->sort["field"],$req->sort["type"]);
      }
      else
      {
        $shipping_methods = $shipping_methods->OrderBy('id','desc');
      }
      if($export != null){ // for export do not paginate
        $shipping_methods = $shipping_methods->get();
        return $shipping_methods;
      }
      $totalShippingMethods = $shipping_methods->count();
      $shipping_methods = $shipping_methods->OrderBy('id','desc');
      $shipping_methods = $shipping_methods->paginate($req->perPage);
      $shipping_methods = ShippingMethodsResource::collection($shipping_methods)->response()->getData(true);
      return $shipping_methods;
    }
    $shipping_methods = ShippingMethodsResource::collection(ShippingMethod::orderBy('id','desc')->paginate(10))->response()->getData(true);
    return $shipping_methods;
  }

  /********* FETCH ALL ShippingMethods ***********/
    public function index()
    {
        $arrayName = array('shipping_methods' => $this->getter());
        return response($arrayName);
    }
      /********* Export PDF , CSV And Excel  **********/
    public function export(Request $request)
    {
        $shipping_methods = $this->getter($request,"export");
        if ($request->export == 'pdf') {
            $allSettings = Setting::where('name', 'web_logo_image_id')->first();
            $logo = Media::find((int)$allSettings->value);
            $new_logo = str_replace("/api/", "", $logo->original_media_path);
            $data['general'] = [
                'currentDate' => date("Y-m-d"),
                'fileName' => "Shipping Methods",
                'reportName' => "Shipping Methods",
                'logo' => $new_logo,
            ];
            $data['tableHeaders'] = ["Sr#", "Name", "Status"];
            $data['tableData'] = [];
            foreach ($shipping_methods as $key => $shipping_method) {
                if ($shipping_method->is_active == 1) {
                    $is_active = "Active";
                } else {
                    $is_active = "Inactive";
                }
                $result = [++$key, $shipping_method->name,$is_active];
                $data['tableData'][] = $result;
            }
            $pdf = PDF::loadView('pdf.pages', $data);
            return $pdf->setPaper('A4', 'potrait')->download('shipping_method.pdf');
        }
        $filename = "shipping_methods.".$request->export;
        return Excel::download(new ShippingMethodsExport($shipping_methods), $filename);
    }

  /********* FILTER ShippingMethods FOR Search ***********/
   public function filter(Request $request){
       return response()->json(["state" => "success", "message" =>  trans('messages.response.shipping_method.filter_success'),"shipping_methods" => $this->getter($request)] );
   }

    /********* View RECORD TO EDIT Or Display ***********/
    public function show(ShippingMethod $shipping_method)
    {
        return new ShippingMethodsResource($shipping_method);
    }

    /********* UPDATE ShippingMethod ***********/
    public function update(CreateRequest $request, ShippingMethod $shipping_method)
    {
      $shipping_method_data = $request->except(['settings']);
      $shipping_method_settings_data = $request->settings;
      if($request->is_default && !$shipping_method->is_default){
        ShippingMethod::where('is_default',1)->update([
          'is_default' => 0
        ]);
        $shipping_method->update($request->all());
        return response(["message" => trans('messages.response.shipping_method.update_success')]);
      }
      else if($shipping_method->is_default && !$request->is_default){
        return response(["state" => "fail","message" => trans('messages.response.shipping_method.one_must_default')]);
      }
      else{
        $shipping_method->update($shipping_method_data);
        foreach ($shipping_method_settings_data as $key => $value) {
          ShippingMethodSetting::where('shipping_method_id',$request->id)
          ->where('name' , $key)
          ->update([
            'value' => $value,
          ]);
        }
        return response(["message" => trans('messages.response.shipping_method.update_success')]);
      }
    }

    /********* UPDATE ShippingMethod Status***********/
    public function updateStatus(Request $request,ShippingMethod $shipping_method){
      if($shipping_method->is_default){
        return response()->json(["state" => "fail","message" => trans('messages.response.shipping_method.cannot_disable_default')]);
      }
      else{
        $rider_shipping_method = ShippingMethod::where('id' , 6 )->first();
        if ($rider_shipping_method->is_default == 1){
            return response()->json(["state" => "fail", "message" => trans('messages.response.shipping_method.update_status_not_success')]);
        }
        if ($shipping_method->id == 6 && $rider_shipping_method->is_default != 1){
            return response()->json(["state" => "fail", "message" => trans('messages.response.shipping_method.update_status_not_success')]);
        }else {
            $shipping_method->update([
                'is_active' => $shipping_method->is_active == 1 ? 0:1
              ]);
        }

        return response()->json(["state" => "success", "message" => trans('messages.response.shipping_method.update_status_success'),"shipping_methods" => $this->getter($request)] );
      }
    }
    /********* UPDATE default ShippingMethod Status***********/

    public function updateDefault(Request $request,ShippingMethod $shipping_method){
      if($shipping_method->is_default){
        return response()->json(["state" => "fail","message" => trans('messages.response.shipping_method.one_must_default')]);
      }
      else{
        ShippingMethod::where('is_default',1)->update([
          'is_default' => 0
        ]);
        $shipping_method->update([
          'is_default' => 1,
          'is_active' => 1
        ]);
        if($shipping_method->id == 6){
            ShippingMethod::where('is_default',0)->update([
                'is_active' => 0
              ]);
        }else{
            ShippingMethod::where('id',6)->update([
                'is_active' => 0
              ]);
        }
        return response()->json(["state" => "success", "message" =>  trans('messages.response.shipping_method.change_default_success'),"shipping_methods" => $this->getter($request)] );
      }
    }

}
