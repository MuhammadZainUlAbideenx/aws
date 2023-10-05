<?php

namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\Coupon;
use App\Http\Requests\CMS\Coupons\CreateRequest;
use App\Http\Requests\CMS\Coupons\UpdateRequest;
use App\Http\Resources\CMS\CouponsResource;
use Auth;
use Excel;
use App\Exports\CMS\CouponsExport;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Setting;
use PDF;
class CouponsController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
      $this->middleware('auth:api');
      $this->middleware('permission:coupons.index,guard:api');
      $this->middleware('permission:coupons.create,guard:api',['only' => ['store']]);
      $this->middleware('permission:coupons.update,guard:api',['only' => ['update']]);
      $this->middleware('permission:coupons.delete,guard:api',['only' => ['destroy']]);
      $this->middleware('permission:coupons.update|coupons.is_active,guard:api',['only' => ['updateStatus']]);
  }

  /********* Getter For Pagination, Searching And Sorting  ***********/
  public function getter($req = null,$export = null)
  {
    if($req != null){
      $coupons = Coupon::withAll();
      if($req->column && $req->column != null && $req->search && $req->search != null){
        if($req->column == 'name'){
          $coupons = $coupons->whereLike($req->column.'->'.app()->getLocale(),$req->search);
        }
        else{
          $coupons = $coupons->whereLike($req->column,$req->search);
          }
        }
       else if($req->search && $req->search != null){
            $coupons = $coupons->whereLike(['code'],$req->search);
        }
      if($req->sort !=null && $req->sort["field"] != null && $req->sort["type"] != null){
        $coupons = $coupons->OrderBy($req->sort["field"],$req->sort["type"]);
      }
      else
      {
        $coupons = $coupons->OrderBy('id','desc');
      }
      if($export != null){ // for export do not paginate
        $coupons = $coupons->get();
        return $coupons;
      }
      $totalCoupons = $coupons->count();
      $coupons = $coupons->paginate($req->perPage);
      $coupons = CouponsResource::collection($coupons)->response()->getData(true);
      return $coupons;
    }
    $coupons = CouponsResource::collection(Coupon::withAll()->orderBy('id','desc')->paginate(10))->response()->getData(true);
    return $coupons;
  }

  /********* FETCH ALL Coupons ***********/
    public function index()
    {
        $arrayName = array('coupons' => $this->getter());
        return response($arrayName);
    }
      /********* Export PDF , CSV And Excel  **********/
    public function export(Request $request)
    {
        $coupons = $this->getter($request,"export");
        if ($request->export == 'pdf') {
            $allSettings = Setting::where('name', 'web_logo_image_id')->first();
            $logo = Media::find((int)$allSettings->value);
            $new_logo = str_replace("/api/", "", $logo->original_media_path);
            $data['general'] = [
                'currentDate' => date("Y-m-d"),
                'fileName' => "Coupon",
                'reportName' => "Coupon",
                'logo' => $new_logo,
            ];
            $data['tableHeaders'] = ["Sr#", "Code", "Description", "vendor",  "Amount", "Usage Limit", "User Limit", "Free Shipping", "Minimum Spend", "Maximum Spend", "Expiry Date",  "Status"];
            $data['tableData'] = [];
            foreach ($coupons as $key => $coupon) {
                if ($coupon->is_active == 1) {
                    $is_active = "Active";
                } else {
                    $is_active = "Inactive";
                }

                if ($coupon->free_shipping == 1) {
                    $free_shipping = "Yes";
                } else {
                    $free_shipping = "No";
                }

                $result = [++$key, $coupon->code, strip_tags($coupon->description),$coupon->vendor?$coupon->vendor->name:'',$coupon->amount, $coupon->usage_limit, $coupon->user_limit, $free_shipping ,$coupon->minimum_spend,$coupon->maximum_spend ,  $coupon->expiry_date,$is_active];
                $data['tableData'][] = $result;
            }
            $pdf = PDF::loadView('pdf.pages', $data);
            return $pdf->setPaper('A4', 'potrait')->download('coupon.pdf');
        }
        $filename = "coupons.".$request->export;
        return Excel::download(new CouponsExport($coupons), $filename);
    }

  /********* FILTER Coupons FOR Search ***********/
   public function filter(Request $request){
       return response()->json(["state" => "success", "message" =>trans('messages.response.coupons.filter_success'),"coupons" => $this->getter($request)] );
   }

    /********* ADD NEW Coupon ***********/
    public function store(CreateRequest $request)
    {
      $allSettings =allSettings();
      $data = $request->except(['products','categories','email_restrictions']);
      $user = Auth::user();
      $guard = getGuard();
      if($guard == "vendor"){
        if((int)$allSettings['is_multi_vendor'] == 1){
        $product = $user->coupons()->create($data);
        }
     }
      else if($guard == "admin"){
        if($user->hasRole('admin') || $user->hasRole('super_admin')){
        if((int)$allSettings['is_multi_vendor'] == 1){
            $data['vendor_id'] = 1;
          $coupon = Coupon::create($data);
        }
        else{
          $data['vendor_id'] = 1;
          $coupon = Coupon::create($data);
        }
      }
    }
      if($request->products){
        $coupon->products()->attach($request->products);
      }
      if($request->categories){
        $coupon->categories()->attach($request->categories);
      }
      if($request->email_restrictions){
         $coupon->email_restrictions()->attach($request->email_restrictions);
      }
      return response(["message" =>trans('messages.response.coupons.create_success')]);
    }

    /********* View RECORD TO EDIT Or Display ***********/
    public function show($coupon)
    {
        $coupon = Coupon::withAll()->find($coupon);
        return new CouponsResource($coupon);
    }

    /********* UPDATE Coupon ***********/
    public function update(UpdateRequest $request, Coupon $coupon)
    {
      $data = $request->except(['products','categories','email_restrictions']);
      $coupon->update($data);
      $coupon->products()->sync($request->products);
      $coupon->categories()->sync($request->categories);
      $coupon->email_restrictions()->sync($request->email_restrictions);
      return response(["message" => trans('messages.response.coupons.update_success')]);
    }

    /********* UPDATE Coupon Status***********/
    public function updateStatus(Request $request,Coupon $coupon){
        $coupon->update([
          'is_active' => $coupon->is_active == 1 ? 0:1
        ]);
        return response()->json(["state" => "success", "message" => trans('messages.response.coupons.update_status_success'),"coupons" => $this->getter($request)] );
    }


    /********* DELETE LANGUAGE ***********/
    public function destroy(Request $request,Coupon $coupon)
    {
          $coupon->delete();
          return response()->json(["state" => "success", "message" => trans('messages.response.coupons.delete_success'),"coupons" => $this->getter($request)] );
    }
}
