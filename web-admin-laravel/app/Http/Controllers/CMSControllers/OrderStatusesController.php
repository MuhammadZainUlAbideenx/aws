<?php

namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\OrderStatus;
use App\Http\Requests\CMS\OrderStatuses\CreateRequest;
use App\Http\Resources\CMS\OrderStatusesResource;
use Excel;
use DB;
use App\Exports\CMS\OrderStatusesExport;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Setting;
use PDF;
class OrderStatusesController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
      $this->middleware('auth:api');
      $this->middleware('permission:order_statuses.index,guard:api');
      $this->middleware('permission:order_statuses.create,guard:api',['only' => ['store']]);
      $this->middleware('permission:order_statuses.update,guard:api',['only' => ['update']]);
      $this->middleware('permission:order_statuses.delete,guard:api',['only' => ['destroy']]);
      $this->middleware('permission:order_statuses.update|order_statuses.is_active,guard:api',['only' => ['updateStatus']]);
  }

  /********* Getter For Pagination, Searching And Sorting  ***********/
  public function getter($req = null,$export = null)
  {
    if($req != null){
      $order_statuses = new OrderStatus;
      if($req->column && $req->column != null && $req->search && $req->search != null){
        if($req->column == 'name'){
          $order_statuses = $order_statuses->whereLike($req->column.'->'.app()->getLocale(),$req->search);
        }
        else{
          $order_statuses = $order_statuses->whereLike($req->column,$req->search);
          }
        }
       else if($req->search && $req->search != null){
            $order_statuses = $order_statuses->whereLike(['name->'.app()->getLocale()],$req->search);
        }
      if($req->sort !=null && $req->sort["field"] != null && $req->sort["type"] != null){
        if($req->sort["field"] == 'name'){
          $locale = app()->getLocale();
          $attribute = $req->sort['field'].'->'."'$.$locale'";
          $order_statuses = $order_statuses->OrderBy(DB::raw("lower($attribute)"),$req->sort["type"]);
        }
        else{
          $order_statuses = $order_statuses->OrderBy($req->sort["field"],$req->sort["type"]);
        }
      }
      else
      {
        $order_statuses = $order_statuses->OrderBy('id','desc');

      }
      if($export != null){ // for export do not paginate
        $order_statuses = $order_statuses->get();
        return $order_statuses;
      }
      $totalOrderStatuses = $order_statuses->count();
      $order_statuses = $order_statuses->paginate($req->perPage);
      $order_statuses = OrderStatusesResource::collection($order_statuses)->response()->getData(true);
      return $order_statuses;
    }
    $order_statuses = OrderStatusesResource::collection(OrderStatus::orderBy('id','desc')->paginate(10))->response()->getData(true);
    return $order_statuses;
  }

  /********* FETCH ALL OrderStatuses ***********/
    public function index()
    {
        $arrayName = array('order_statuses' => $this->getter());
        return response($arrayName);
    }
      /********* Export PDF , CSV And Excel  **********/
    public function export(Request $request)
    {
        $order_statuses = $this->getter($request,"export");
        if ($request->export == 'pdf') {
            $allSettings = Setting::where('name', 'web_logo_image_id')->first();
            $logo = Media::find((int)$allSettings->value);
            $new_logo = str_replace("/api/", "", $logo->original_media_path);
            $data['general'] = [
                'currentDate' => date("Y-m-d"),
                'fileName' => "Order Statuses",
                'reportName' => "Order Statuses",
                'logo' => $new_logo,
            ];
            $data['tableHeaders'] = ["Sr#", "Name", "Status Code", "Status"];
            $data['tableData'] = [];
            foreach ($order_statuses as $key => $order_statuse) {
                if ($order_statuse->is_active == 1) {
                    $is_active = "Active";
                } else {
                    $is_active = "Inactive";
                }

                $result = [++$key, $order_statuse->name,$order_statuse->status_code,$is_active];
                $data['tableData'][] = $result;
            }
            $pdf = PDF::loadView('pdf.pages', $data);
            return $pdf->setPaper('A4', 'potrait')->download('order_statuses.pdf');
        }
        $filename = "order_statuses.".$request->export;
        return Excel::download(new OrderStatusesExport($order_statuses), $filename);
    }

  /********* FILTER OrderStatuses FOR Search ***********/
   public function filter(Request $request){
       return response()->json(["state" => "success", "message" => trans('messages.response.order_status.filter_success'),"order_statuses" => $this->getter($request)] );
   }

    /********* ADD NEW OrderStatus ***********/
    public function store(CreateRequest $request)
    {
      if($request->is_default){
        OrderStatus::where('is_default',1)->update([
          'is_default' => 0
        ]);
      }
      $order_status = OrderStatus::create($request->all());
      return response(["message" => trans('messages.response.order_status.create_success')]);
    }

    /********* View RECORD TO EDIT Or Display ***********/
    public function show(OrderStatus $order_status)
    {
        return new OrderStatusesResource($order_status);
    }

    /********* UPDATE OrderStatus ***********/
    public function update(CreateRequest $request, OrderStatus $order_status)
    {
      if($request->is_default && !$order_status->is_default){
        OrderStatus::where('is_default',1)->update([
          'is_default' => 0
        ]);
        $order_status->update($request->all());
        return response(["message" => trans('messages.response.order_status.update_success')]);
      }
      else if($order_status->is_default && !$request->is_default){
        return response(["state" => "fail","message" => trans('messages.response.order_status.one_must_default')]);
      }
      else{
        $order_status->update($request->all());
        return response(["message" => trans('messages.response.order_status.update_success')]);
      }
    }

    /********* UPDATE OrderStatus Status***********/
    public function updateStatus(Request $request,OrderStatus $order_status){
      if($order_status->is_default){
        return response()->json(["state" => "fail","message" => trans('messages.response.order_status.cannot_disable_default')]);
      }
      else{
        $order_status->update([
          'is_active' => $order_status->is_active == 1 ? 0:1
        ]);
        return response()->json(["state" => "success", "message" => trans('messages.response.order_status.update_status_success'),"order_statuses" => $this->getter($request)] );
      }
    }
    /********* UPDATE default OrderStatus Status***********/

    public function updateDefault(Request $request,OrderStatus $order_status){
      if($order_status->is_default){
        return response()->json(["state" => "fail","message" => trans('messages.response.order_status.one_must_default')]);
      }
      else{
        OrderStatus::where('is_default',1)->update([
          'is_default' => 0
        ]);
        $order_status->update([
          'is_default' => 1,
          'is_active' => 1
        ]);
        return response()->json(["state" => "success", "message" =>  trans('messages.response.order_status.update_default_success'),"order_statuses" => $this->getter($request)] );
      }
    }


    /********* DELETE LANGUAGE ***********/
    public function destroy(Request $request,OrderStatus $order_status)
    {
      if($order_status->is_default){
        return response()->json(["state" => "fail","message" => trans('messages.response.order_status.cannot_delete_default')]);
      }else{
        $order_status->delete();
        return response()->json(["state" => "success", "message" => trans('messages.response.order_status.delete_success'),"order_statuses" => $this->getter($request)] );
      }
    }
}
