<?php

namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\PaymentMethod;
use App\Models\CMSModels\PaymentMethodSetting;
use App\Http\Requests\CMS\PaymentMethods\CreateRequest;
use App\Http\Resources\CMS\PaymentMethodsResource;
use Excel;
use App\Exports\CMS\PaymentMethodsExport;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Setting;
use PDF;
class PaymentMethodsController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
      $this->middleware('auth:api');
      $this->middleware('permission:payment_methods.index,guard:api');
      $this->middleware('permission:payment_methods.create,guard:api',['only' => ['store']]);
      $this->middleware('permission:payment_methods.update,guard:api',['only' => ['update']]);
      $this->middleware('permission:payment_methods.delete,guard:api',['only' => ['destroy']]);
      $this->middleware('permission:payment_methods.update|payment_methods.is_active,guard:api',['only' => ['updateStatus']]);
  }

  /********* Getter For Pagination, Searching And Sorting  ***********/
  public function getter($req = null,$export = null)
  {
    if($req != null){
      $payment_methods = new PaymentMethod;
      if($req->column && $req->column != null && $req->search && $req->search != null){
        if($req->column == 'name'){
          $payment_methods = $payment_methods->whereLike($req->column.'->'.app()->getLocale(),$req->search);
        }
        else{
          $payment_methods = $payment_methods->whereLike($req->column,$req->search);
          }
        }
       else if($req->search && $req->search != null){
            $payment_methods = $payment_methods->whereLike(['name->'.app()->getLocale()],$req->search);
        }
      if($req->sort !=null && $req->sort["field"] != null && $req->sort["type"] != null){
        $payment_methods = $payment_methods->OrderBy($req->sort["field"],$req->sort["type"]);
      }
      else
      {
        $payment_methods = $payment_methods->OrderBy('id','desc');
      }
      if($export != null){ // for export do not paginate
        $payment_methods = $payment_methods->get();
        return $payment_methods;
      }
      $totalPaymentMethods = $payment_methods->count();
      $payment_methods = $payment_methods->OrderBy('id','desc');
      $payment_methods = $payment_methods->paginate($req->perPage);
      $payment_methods = PaymentMethodsResource::collection($payment_methods)->response()->getData(true);
      return $payment_methods;
    }
    $payment_methods = PaymentMethodsResource::collection(PaymentMethod::orderBy('id','desc')->paginate(10))->response()->getData(true);
    return $payment_methods;
  }

  /********* FETCH ALL PaymentMethods ***********/
    public function index()
    {
        $arrayName = array('payment_methods' => $this->getter());
        return response($arrayName);
    }
      /********* Export PDF , CSV And Excel  **********/
    public function export(Request $request)
    {
        $payment_methods = $this->getter($request,"export");
        if ($request->export == 'pdf') {
            $allSettings = Setting::where('name', 'web_logo_image_id')->first();
            $logo = Media::find((int)$allSettings->value);
            $new_logo = str_replace("/api/", "", $logo->original_media_path);
            $data['general'] = [
                'currentDate' => date("Y-m-d"),
                'fileName' => "Payment Methods",
                'reportName' => "Payment Methods",
                'logo' => $new_logo,
            ];
            $data['tableHeaders'] = ["Sr#", "Name", "Code", "Status"];
            $data['tableData'] = [];
            foreach ($payment_methods as $key => $payment_method) {
                if ($payment_method->is_active == 1) {
                    $is_active = "Active";
                } else {
                    $is_active = "Inactive";
                }

                $result = [++$key, $payment_method->name,  $payment_method->code,$is_active];
                $data['tableData'][] = $result;
            }
            $pdf = PDF::loadView('pdf.pages', $data);
            return $pdf->setPaper('A4', 'potrait')->download('payment_method.pdf');
        }
        $filename = "payment_methods.".$request->export;
        return Excel::download(new PaymentMethodsExport($payment_methods), $filename);
    }

  /********* FILTER PaymentMethods FOR Search ***********/
   public function filter(Request $request){
       return response()->json(["state" => "success", "message" => trans('messages.response.payment_method.filter_success'),"payment_methods" => $this->getter($request)] );
   }

    /********* View RECORD TO EDIT Or Display ***********/
    public function show($payment_method)
    {
        $payment_method = PaymentMethod::withAll()->find($payment_method);
        return new PaymentMethodsResource($payment_method);
    }

    /********* UPDATE PaymentMethod ***********/
    public function update(CreateRequest $request, PaymentMethod $payment_method)
    {
      $payment_method_data = $request->except(['settings']);
      $payment_method_settings_data = $request->settings;
      if($request->is_default && !$payment_method->is_default){
        PaymentMethod::where('is_default',1)->update([
          'is_default' => 0
        ]);
        $payment_method->update($request->all());
        return response(["message" => trans('messages.response.payment_method.update_success')]);
      }
      else if($payment_method->is_default && !$request->is_default){
        return response(["state" => "fail","message" => trans('messages.response.payment_method.one_must_default')]);
      }
      else{
        $payment_method->update($payment_method_data);
        foreach ($payment_method_settings_data as $key => $value) {
          PaymentMethodSetting::where('payment_method_id',$request->id)
          ->where('name' , $key)
          ->update([
            'value' => $value,
          ]);
        }
        return response(["message" => trans('messages.response.payment_method.update_success')]);
      }
    }

    /********* UPDATE PaymentMethod Status***********/
    public function updateStatus(Request $request,PaymentMethod $payment_method){
      if($payment_method->is_default){
        return response()->json(["state" => "fail","message" => trans('messages.response.payment_method.cannot_disable_default')]);
      }
      else{
        $payment_method->update([
          'is_active' => $payment_method->is_active == 1 ? 0:1
        ]);
        return response()->json(["state" => "success", "message" => trans('messages.response.payment_method.update_status_success'),"payment_methods" => $this->getter($request)] );
      }
    }
    /********* UPDATE default PaymentMethod Status***********/

    public function updateDefault(Request $request,PaymentMethod $payment_method){
      if($payment_method->is_default){
        return response()->json(["state" => "fail","message" => trans('messages.response.payment_method.one_must_default')]);
      }
      else{
        PaymentMethod::where('is_default',1)->update([
          'is_default' => 0
        ]);
        $payment_method->update([
          'is_default' => 1,
          'is_active' => 1
        ]);
        return response()->json(["state" => "success", "message" =>  trans('messages.response.payment_method.update_status_success'),"payment_methods" => $this->getter($request)] );
      }
    }

}
