<?php

namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use App\Http\Requests\CMS\Roles\CreateRequest;
use App\Http\Resources\CMS\RolesResource;
use Excel;
use Artisan;
use App\Exports\CMS\RolesExport;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Setting;
use PDF;
class RolesController extends Controller
{
  /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
    $this->middleware('auth:api');
    $this->middleware('permission:roles.index,guard:api');
    $this->middleware('permission:roles.create,guard:api',['only' => ['store']]);
    $this->middleware('permission:roles.update,guard:api',['only' => ['update']]);
    $this->middleware('permission:roles.delete,guard:api',['only' => ['destroy']]);
    $this->middleware('permission:roles.update|roles.is_active,guard:api',['only' => ['updateStatus']]);
  }

  /********* Getter For Pagination, Searching And Sorting  ***********/
  public function getter($req = null,$export = null)
  {
    $user_role = auth()->user()->role;
    if($req != null){
      $roles =  Role::withAll();
      if($req->column && $req->column != null && $req->search && $req->search != null){
        if($req->column == 'description'){
          $roles = $roles->whereLike($req->column.'->'.app()->getLocale(),$req->search);
        }
        else{
          $roles = $roles->whereLike($req->column,$req->search);
        }
      }
      else if($req->search && $req->search != null){
        $roles = $roles->whereLike(['display_name'],$req->search);
      }
      if($req->sort !=null && $req->sort["field"] != null && $req->sort["type"] != null){
        $roles = $roles->OrderBy($req->sort["field"],$req->sort["type"]);
      }
      else
      {
        $roles = $roles->OrderBy('id','desc');

      }
      $roles = $roles->where('name','!=','super_admin');
      $roles = $roles->where('name','!=','customer');
      $roles = $roles->where('name','!=','vendor');
      // $roles = $roles->where('id','!=',$user_role->id);
      if($export != null){ // for export do not paginate
        $roles = $roles->get();
        return $roles;
      }
      $totalRoles = $roles->count();
      $roles = $roles->paginate($req->perPage);
      $roles = RolesResource::collection($roles)->response()->getData(true);
      return $roles;
    }
    $roles = RolesResource::collection(Role::where('name','!=','super_admin')
                                            ->where('name','!=','customer')
                                            ->where('name','!=','vendor')
                                          // ->where('id','!=',$user_role->id)
    ->withAll()->orderBy('id','desc')->paginate(10))->response()->getData(true);
    return $roles;
  }
  /********* attachAllPermissionsToSuperAdmin ***********/
  public function attachAllPermissionsToSuperAdmin(){
    $permissions = Permission::get()->pluck('id');
    $superadmin = Role::where('name','super_admin')->first();
    if($superadmin){
      $superadmin->permissions()->sync($permissions);
    }
  }
  /********* FETCH ALL Roles ***********/
  public function index()
  {
    $arrayName = array('roles' => $this->getter());
    return response($arrayName);
  }
  /********* Export PDF , CSV And Excel  **********/
  public function export(Request $request)
  {
    $roles = $this->getter($request,"export");
    if ($request->export == 'pdf') {
        $allSettings = Setting::where('name', 'web_logo_image_id')->first();
        $logo = Media::find((int)$allSettings->value);
        $new_logo = str_replace("/api/", "", $logo->original_media_path);
        $data['general'] = [
            'currentDate' => date("Y-m-d"),
            'fileName' => "Roles",
            'reportName' => "Roles",
            'logo' => $new_logo,
        ];
        $data['tableHeaders'] = ["Sr#", "Name", "Description", "Status"];
        $data['tableData'] = [];
        foreach ($roles as $key => $role) {
            if ($role->is_active == 1) {
                $is_active = "Active";
            } else {
                $is_active = "Inactive";
            }

            $result = [++$key, $role->name, strip_tags($role->description),$is_active];
            $data['tableData'][] = $result;
        }
        $pdf = PDF::loadView('pdf.pages', $data);
        return $pdf->setPaper('A4', 'potrait')->download('attribute.pdf');
    }
    $filename = "roles.".$request->export;
    return Excel::download(new RolesExport($roles), $filename);
  }

  /********* FILTER Roles FOR Search ***********/
  public function filter(Request $request){
    return response()->json(["state" => "success", "message" => trans('messages.response.roles.filter_success'),"roles" => $this->getter($request)] );
  }

  /********* ADD NEW Role ***********/
  public function store(CreateRequest $request)
  {
    $data = $request->all();
    $role = Role::create($data);
    $role->name = 'admin';
    $role->save();
    $this->attachAllPermissionsToSuperAdmin();
    return response(["message" => trans('messages.response.roles.create_success')]);
  }

  /********* View RECORD TO EDIT Or Display ***********/
  public function show( $role)
  {
    $role = Role::withAll()->find($role);
    $user_role = auth()->user()->role;
    if($role && $role->name != 'super_admin' && $role->name != 'customer' && $role->name != 'vendor'
    // && $user_role->id != $role->id
  ){
      return new RolesResource($role);
    }
    else{
      return response()->json(["state" => "fail", "message" => trans('messages.response.roles.role_not_found'),"roles" => $this->getter($request)] );
    }
  }

  /********* UPDATE Role ***********/
  public function update(CreateRequest $request, Role $role)
  {
    $user_role = auth()->user()->role;
    if($role && $role->name != 'super_admin' && $role->name != 'customer' && $role->name != 'vendor'
    // && $role->id != $user_role->id
  ){
      if($request->permissions){
        $arr = array_keys($request->permissions,true);
        $dbpermissions = Permission::get()->pluck('name')->toArray();
        $notInDb = array_diff($arr, $dbpermissions);
        foreach ($notInDb as $key => $value) {
          Permission::create(['name' => $value]);
        }
        $permissions = Permission::whereIn('name',$arr)->get()->pluck('id');
        $role->permissions()->sync($permissions);
        $this->attachAllPermissionsToSuperAdmin();
        Artisan::call('cache:clear');
        Artisan::call('config:cache');
        return response(["message" => trans('messages.response.roles.update_permission_success')]);
      }
      $role->update($request->all());
      $this->attachAllPermissionsToSuperAdmin();
      Artisan::call('cache:clear');
       Artisan::call('config:cache');
      return response(["message" => trans('messages.response.roles.update_success')]);
    }
    else{
      return response()->json(["state" => "fail", "message" => trans('messages.response.roles.role_not_found'),"roles" => $this->getter($request)] );

    }
  }

  /********* UPDATE Role Status***********/
  public function updateStatus(Request $request,Role $role){
    $user_role = auth()->user()->role;
    if($role->name == 'customer' || $role->name == 'vendor'  || $role->name == 'super_admin' || $user_role->id == $role->id){
      return response()->json(["state" => "fail", "message" => trans('messages.response.roles.role_not_found'),"roles" => $this->getter($request)] );
    }
    $role->update([
      'is_active' => $role->is_active == 1 ? 0:1
    ]);
    return response()->json(["state" => "success", "message" => trans('messages.response.roles.update_status_success'),"roles" => $this->getter($request)] );
  }


  /********* DELETE LANGUAGE ***********/
  public function destroy(Request $request,Role $role)
  {
    $user_role = auth()->user()->role;
    if($role->name == 'customer' || $role->name == 'vendor'  || $role->name == 'super_admin' || $user_role->id == $role->id){
      return response()->json(["state" => "fail", "message" =>trans('messages.response.roles.role_not_found'),"roles" => $this->getter($request)] );
    }
    $role->delete();
    return response()->json(["state" => "success", "message" => trans('messages.response.roles.delete_success'),"roles" => $this->getter($request)] );
  }
}
