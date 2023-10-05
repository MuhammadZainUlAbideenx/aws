<?php

namespace App\Http\Controllers\SellerControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rider;
use App\Http\Requests\Vendor\Riders\CreateRequest;
use App\Http\Requests\Vendor\Riders\UpdateRequest;
use App\Http\Requests\Vendor\Riders\UpdateProfileRequest;
use App\Http\Resources\Vendor\RidersResource;
use Excel;
use App\Exports\Seller\RidersExport;
use App\Http\Requests\Vendor\Riders\UpdateRiderCommissionRequest;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\RiderShipping;
use App\Models\CMSModels\Setting;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Auth;
use Hash;
use Str;
use PDF;

class SellerRidersController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
    $this->middleware('auth:vendor-api');
    $this->middleware('scope:vendor');
    //   $this->middleware('permission:riders.index,guard:api');
    //   $this->middleware('permission:riders.create,guard:api',['only' => ['store']]);
    //   $this->middleware('permission:riders.update,guard:api',['only' => ['update']]);
    //   $this->middleware('permission:riders.delete,guard:api',['only' => ['destroy']]);
    //   $this->middleware('permission:riders.update|riders.is_active,guard:api',['only' => ['updateStatus']]);
  }

  /********* Getter For Pagination, Searching And Sorting  ***********/
  public function getter($req = null,$export = null)
  {
    if($req != null){
      $riders =  Rider::where('vendor_id',Auth::user()->id)->withAll();
      if($req->column && $req->column != null && $req->search && $req->search != null){
        if($req->column == 'first_name'){
          $riders = $riders->whereLike(['first_name','last_name'],$req->search);
        }else{
        $riders = $riders->whereLike($req->column,$req->search);
        }
      }else if($req->search && $req->search != null){
           $riders = $riders->whereLike(['phone','email','address','role.display_name'],$req->search);
        }
      if($req->sort !=null && $req->sort["field"] != null && $req->sort["type"] != null){
        $riders = $riders->OrderBy($req->sort["field"],$req->sort["type"]);
      }
      else
      {
        $riders = $riders->OrderBy('id','desc');
      }
      if($export != null){ // for export do not paginate
        $riders = $riders->get();
        return $riders;
      }
      $totalRiders = $riders->count();
      $riders = $riders->paginate($req->perPage);
      $riders = RidersResource::collection($riders)->response()->getData(true);
      return $riders;
    }
    $riders = Rider::where('vendor_id',Auth::user()->id)->withAll()->orderBy('id','desc')->paginate(10);
    $riders = RidersResource::collection($riders)->response()->getData(true);
    return $riders;
  }

  /********* FETCH ALL Riders ***********/
    public function index()
    {
        $arrayName = array('riders' => $this->getter());
        return response($arrayName);
    }
      /********* Export PDF , CSV And Excel  **********/
    public function export(Request $request)
    {
        $riders = $this->getter($request,"export");
        if ($request->export == 'pdf') {
            $allSettings = Setting::where('name', 'web_logo_image_id')->first();
            $logo = Media::find((int)$allSettings->value);
            $new_logo = str_replace("/api/", "", $logo->original_media_path);
            $data['general'] = [
                'currentDate' => date("Y-m-d"),
                'fileName' => "Riders",
                'reportName' => "Riders",
                'logo' => $new_logo,
            ];
            $data['tableHeaders'] = ["Sr#", "First Name", "Last Name", "Email", "Gender", "Phone" , "Address", "Date of Birth","Status"];
            $data['tableData'] = [];
            foreach ($riders as $key => $rider) {
                if ($rider->is_active == 1) {
                    $is_active = "Active";
                } else {
                    $is_active = "Inactive";
                }

                $result = [++$key, $rider->first_name, $rider->last_name, $rider->email, $rider->gender, $rider->phone, $rider->address, date('d-m-Y', strtotime($rider->dob)), $is_active];
                $data['tableData'][] = $result;
            }
            $pdf = PDF::loadView('pdf.pages', $data);
            return $pdf->setPaper('A4', 'potrait')->download('riders.pdf');
        }
        $filename = "riders.".$request->export;
        return Excel::download(new RidersExport($riders), $filename);
    }

  /********* FILTER Riders FOR Search ***********/
   public function filter(Request $request){
       return response()->json(["state" => "success", "message" => trans('messages.response.riders.filter_success'),"riders" => $this->getter($request)] );
   }

    /********* ADD NEW Rider ***********/
    public function store(CreateRequest $request)
    {
      $rider = new Rider();
      $data = $request->except(['password']);
      $slug = Str::slug($request->name);
      $data["slug"] = $slug;
      $data['password'] = Hash::make($request->password);
      $rider = $rider->create($data);
      return response(["message" => trans('messages.response.riders.create_success')]);
    }

    /********* View RECORD TO EDIT Or Display ***********/
    public function show($rider)
    {
        $rider = Rider::withAll()->find($rider);
        return new RidersResource($rider);
    }

    /********* UPDATE Rider ***********/
    public function update(UpdateRequest $request, Rider $rider)
    {
      if($request->is_credentials){
        $data = $request->except(['is_credentials','password','email']);
        if($request->password != '' && $request->password != null){
        $hashed_pass = Hash::make($request->password);
          $data['password'] = $hashed_pass;
        }
        if($request->email){
          $data['email'] = $request->email;
        }
        $rider->update($data);
      }else{
        $data = $request->except(['is_credentials','password','email']);
        $rider->update($data);
      }
      return response(["message" => trans('messages.response.riders.update_success')]);
    }

    /********* UPDATE Manufacturer Status***********/
    public function updateStatus(Request $request,Rider $rider){
        $rider->update([
          'is_active' => $rider->is_active == 1 ? 0:1
        ]);
        return response()->json(["state" => "success", "message" => trans('messages.response.riders.update_status_success'),"riders" => $this->getter($request)] );
    }
    public function getRiderProfile(){
      $rider = Auth::user();
      $rider = Rider::find($rider->id);
      return new RidersResource($rider);
    }

    public function updateProfileImage(Request $request)
    {
      if (!file_exists(public_path('riders'))) {
          mkdir(public_path('riders'), 0755, true);
      }
      if (!file_exists(public_path('riders/profile_images'))) {
          mkdir(public_path('riders/profile_images'), 0755, true);
      }
      $rider = Auth::user();
      $file = $request->file('file');
      $type = $file->getMimeType();
      $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
      $filename = $rider->name.'_'.$file->getClientOriginalName();
      $file_resize = Image::make($file->getRealPath());
      $file_resize->save(public_path('riders/profile_images/'.$filename));
      $file_url = '/api/riders/profile_images/'.$filename;
      if($rider->profile_image_path){
        $old_profile_image = explode('/api',$rider->profile_image_path);
        $old_profile_image = public_path().$old_profile_image[1];
        if(file_exists($old_profile_image)){
          unlink($old_profile_image);
        }
      }
      $rider->update([
        'profile_image_path' => $file_url,
      ]);
        return response()->json(['profile_image_path' => $rider->profile_image_path, 'success' => 'Your Profile image Has been Uploaded','message' => trans('messages.response.riders.image_uploaded')], 200);
    }

    public function updateRiderProfile (UpdateProfileRequest $request){
      $rider = Auth::user();
      $data = $request->except(['is_pass','password']);
      if($request->is_pass){
        $hashed_pass = Hash::make($request->password);
        $data['password'] = $hashed_pass;
      }
      $rider = $rider->update($data);
     return response(["message" => trans('messages.response.riders.update_success')]);
    }
    public function updateRiderCommission(UpdateRiderCommissionRequest $request){
        $vendor_id = Auth::user()->id;
        $rider_shipping = RiderShipping::where('vendor_id', $vendor_id)->first();
        if ($rider_shipping){
            RiderShipping::where('id', $rider_shipping->id)->update([
                'vendor_id' => $vendor_id,
                'commission_type' => $request->commission_type,
                'commission_rate' => $request->rate,
            ]);
        }else {
            RiderShipping::create([
                'vendor_id' => $vendor_id,
                'commission_type' => $request->commission_type,
                'commission_rate' => $request->rate,
            ]);
        }
       return response(["message" => trans('messages.response.riders.update_success')]);
      }

      public function getRiderShipping(){
        $vendor_id = auth()->user()->id;
        $rider_shipping = RiderShipping::where('vendor_id', $vendor_id)->first();
        return $rider_shipping;
      }

    /********* DELETE LANGUAGE ***********/
    public function destroy(Request $request,Rider $rider)
    {
          $rider->delete();
          return response()->json(["state" => "success", "message" => trans('messages.response.riders.delete_success'),"riders" => $this->getter($request)] );
    }


}
