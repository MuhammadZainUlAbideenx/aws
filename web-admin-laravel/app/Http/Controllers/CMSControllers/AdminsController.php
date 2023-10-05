<?php

namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\Admin;
use App\Http\Requests\CMS\Admins\CreateRequest;
use App\Http\Requests\CMS\Admins\UpdateRequest;
use App\Http\Requests\CMS\Admins\UpdateProfileRequest;
use App\Http\Resources\CMS\AdminsResource;
use App\Models\User;
use Excel;
use App\Exports\CMS\AdminsExport;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Setting;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Auth;
use Hash;
use PDF;
class AdminsController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
      $this->middleware('auth:api');
      $this->middleware('permission:admins.index,guard:api');
      $this->middleware('permission:admins.create,guard:api',['only' => ['store']]);
      $this->middleware('permission:admins.update,guard:api',['only' => ['update']]);
      $this->middleware('permission:admins.delete,guard:api',['only' => ['destroy']]);
      $this->middleware('permission:admins.update|admins.is_active,guard:api',['only' => ['updateStatus']]);
  }

  /********* Getter For Pagination, Searching And Sorting  ***********/
  public function getter($req = null,$export = null)
  {
    if($req != null){
      $admins =  Admin::withAll();
      if($req->column && $req->column != null && $req->search && $req->search != null){
        if($req->column == 'first_name'){
          $admins = $admins->whereLike(['first_name','last_name'],$req->search);
        }else{
        $admins = $admins->whereLike($req->column,$req->search);
        }
      }else if($req->search && $req->search != null){
           $admins = $admins->whereLike(['phone','email','address','role.display_name'],$req->search);
        }
      if($req->sort !=null && $req->sort["field"] != null && $req->sort["type"] != null){
        $admins = $admins->OrderBy($req->sort["field"],$req->sort["type"]);
      }
      else
      {
        $admins = $admins->OrderBy('id','desc');
      }
      if($export != null){ // for export do not paginate
        $admins = $admins->get();
        return $admins;
      }
      $totalAdmins = $admins->count();
      $admins = $admins->paginate($req->perPage);
      $admins = AdminsResource::collection($admins)->response()->getData(true);
      return $admins;
    }
    $admins = Admin::withAll()->orderBy('id','desc')->paginate(10);
    $admins = AdminsResource::collection($admins)->response()->getData(true);
    return $admins;
  }

  /********* FETCH ALL Admins ***********/
    public function index()
    {
        $arrayName = array('admins' => $this->getter());
        return response($arrayName);
    }
      /********* Export PDF , CSV And Excel  **********/
    public function export(Request $request)
    {
        $admins = $this->getter($request,"export");
        if ($request->export == 'pdf') {
            $allSettings = Setting::where('name', 'web_logo_image_id')->first();
            $logo = Media::find((int)$allSettings->value);
            $new_logo = str_replace("/api/", "", $logo->original_media_path);
            $data['general'] = [
                'currentDate' => date("Y-m-d"),
                'fileName' => "Admins",
                'reportName' => "Admins",
                'logo' => $new_logo,
            ];
            $data['tableHeaders'] = ["Sr#", "First Name", "Last Name", "Email", "Gender", "DOB", "Phone", "Country", "Admin Type", "Status"];
            $data['tableData'] = [];
            foreach ($admins as $key => $admin) {
                if ($admin->is_active == 1) {
                    $is_active = "Active";
                } else {
                    $is_active = "Inactive";
                }

                $result = [++$key, $admin->first_name, $admin->last_name, $admin->email, $admin->gender, date('d-m-Y', strtotime($admin->dob)),$admin->phone, $admin->country ?$admin->country->name : "" ,$admin->role ?$admin->role->name : "" ,$is_active];
                $data['tableData'][] = $result;
            }
            $pdf = PDF::loadView('pdf.pages', $data);
            return $pdf->setPaper('A4', 'potrait')->download('admin.pdf');
        }
        $filename = "admins.".$request->export;
        return Excel::download(new AdminsExport($admins), $filename);
    }

  /********* FILTER Admins FOR Search ***********/
   public function filter(Request $request){
       return response()->json(["state" => "success", "message" => trans('messages.response.admins.filter_success'),"admins" => $this->getter($request)] );
   }

    /********* ADD NEW Admin ***********/
    public function store(CreateRequest $request)
    {
      $admin = new Admin();
      $data = $request->except(['password']);
      $data['password'] = Hash::make($request->password);
      $admin = $admin->create($data);
      $admin->roles()->attach($request->role_id);
      return response(["message" => trans('messages.response.admins.create_success')]);
    }

    /********* View RECORD TO EDIT Or Display ***********/
    public function show($admin)
    {
        $admin = Admin::withAll()->find($admin);
        return new AdminsResource($admin);
    }

    /********* UPDATE Admin ***********/
    public function update(UpdateRequest $request, Admin $admin)
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
        $admin->update($data);
      }else{
        $data = $request->except(['is_credentials','password','email']);
        $admin->update($data);
      }
      if($admin->role){
        $admin->roles()->detach();
      }
      $admin->roles()->attach($request->role_id);
      return response(["message" => trans('messages.response.admins.update_success')]);
    }

    /********* UPDATE Manufacturer Status***********/
    public function updateStatus(Request $request,Admin $admin){
        $admin->update([
          'is_active' => $admin->is_active == 1 ? 0:1
        ]);
        return response()->json(["state" => "success", "message" => trans('messages.response.admins.update_status_success'),"admins" => $this->getter($request)] );
    }
    public function getAdminProfile(){
      $admin = Auth::user();
      $admin = Admin::find($admin->id);
      return new AdminsResource($admin);
    }

    public function updateProfileImage(Request $request)
    {
      if (!file_exists(public_path('admins'))) {
          mkdir(public_path('admins'), 0755, true);
      }
      if (!file_exists(public_path('admins/profile_images'))) {
          mkdir(public_path('admins/profile_images'), 0755, true);
      }
      $admin = Auth::user();
      $file = $request->file('file');
      $type = $file->getMimeType();
      $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
      $filename = $admin->name.'_'.$file->getClientOriginalName();
      $file_resize = Image::make($file->getRealPath());
      $file_resize->save(public_path('admins/profile_images/'.$filename));
      $file_url = '/api/admins/profile_images/'.$filename;
      if($admin->profile_image_path){
        $old_profile_image = explode('/api',$admin->profile_image_path);
        $old_profile_image = public_path().$old_profile_image[1];
        if(file_exists($old_profile_image)){
          unlink($old_profile_image);
        }
      }
      $admin->update([
        'profile_image_path' => $file_url,
      ]);
        return response()->json(['profile_image_path' => $admin->profile_image_path, 'success' => 'Your Profile image Has been Uploaded','message' => trans('messages.response.admins.image_uploaded')], 200);
    }

    public function updateAdminProfile (UpdateProfileRequest $request){
      $admin = Auth::user();
      $data = $request->except(['is_pass','password']);
      if($request->is_pass){
        $hashed_pass = Hash::make($request->password);
        $data['password'] = $hashed_pass;
      }
      $admin = $admin->update($data);
     return response(["message" => trans('messages.response.profile.update_success')]);
    }

    /********* DELETE LANGUAGE ***********/
    public function destroy(Request $request,Admin $admin)
    {
          if($admin->role){
            $admin->roles()->detach();
          }
          $admin->delete();
          return response()->json(["state" => "success", "message" => trans('messages.response.admins.delete_success'),"admins" => $this->getter($request)] );
    }
}
