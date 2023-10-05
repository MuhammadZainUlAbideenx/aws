<?php

namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Role;
use App\Http\Requests\CMS\Permissions\CreateRequest;
use App\Http\Resources\CMS\PermissionsResource;
use Excel;
use App\Exports\CMS\PermissionsExport;
class PermissionsController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
      $this->middleware('auth:api');
      $this->middleware('permission:permissions.index,guard:api');
      $this->middleware('permission:permissions.create,guard:api',['only' => ['store']]);
      $this->middleware('permission:permissions.update,guard:api',['only' => ['update']]);
      $this->middleware('permission:permissions.delete,guard:api',['only' => ['destroy']]);
      $this->middleware('permission:permissions.update|permissions.is_active,guard:api',['only' => ['updateStatus']]);
  }

  /********* Getter For Pagination, Searching And Sorting  ***********/
  public function getter($req = null,$export = null)
  {
    if($req != null){
      $permissions = new Permission;
      if($req->column && $req->column != null && $req->search && $req->search != null){
        if($req->column == 'display_name'){
          $permissions = $permissions->whereLike($req->column.'->'.app()->getLocale(),$req->search);
        }
        else{
          $permissions = $permissions->whereLike($req->column,$req->search);
          }
        }
       else if($req->search && $req->search != null){
            $permissions = $permissions->whereLike(['name','display_name->'.app()->getLocale()],$req->search);
        }
      if($req->sort !=null && $req->sort["field"] != null && $req->sort["type"] != null){
        $permissions = $permissions->OrderBy($req->sort["field"],$req->sort["type"]);
      }
      else
      {
        $permissions = $permissions->OrderBy('id','desc');
      }
      if($export != null){ // for export do not paginate
        $permissions = $permissions->get();
        return $permissions;
      }
      $totalPermissions = $permissions->count();
      $permissions = $permissions->paginate($req->perPage);
      $permissions = PermissionsResource::collection($permissions)->response()->getData(true);
      return $permissions;
    }
    $permissions = PermissionsResource::collection(Permission::orderBy('id','desc')->paginate(10))->response()->getData(true);
    return $permissions;
  }
  /********* Attach all Permissions to super admin ***********/
  public function attachAllPermissionsToSuperAdmin(){
    $permissions = Permission::get()->pluck('id');
    $superadmin = Role::where('id',1)->first();
    if($superadmin){
      $superadmin->permissions()->sync($permissions);
    }
  }
  /********* FETCH ALL Permissions ***********/
    public function index()
    {
        $arrayName = array('permissions' => $this->getter());
        return response($arrayName);
    }
      /********* Export PDF , CSV And Excel  **********/
    public function export(Request $request)
    {
        $permissions = $this->getter($request,"export");
        $filename = "permissions.".$request->export;
        return Excel::download(new PermissionsExport($permissions), $filename);
    }

  /********* FILTER Permissions FOR Search ***********/
   public function filter(Request $request){
       return response()->json(["state" => "success", "message" => trans('messages.response.permissions.filter_success'),"permissions" => $this->getter($request)] );
   }

    /********* ADD NEW Permission ***********/
    public function store(CreateRequest $request)
    {
      $permission = Permission::create($request->all());
      $this->attachAllPermissionsToSuperAdmin();
      return response(["message" => trans('messages.response.permissions.create_success')]);
    }

    /********* View RECORD TO EDIT Or Display ***********/
    public function show(Permission $permission)
    {
        return new PermissionsResource($permission);
    }

    /********* UPDATE Permission ***********/
    public function update(CreateRequest $request, Permission $permission)
    {
        $permission->update($request->all());
        return response(["message" => trans('messages.response.permissions.update_success')]);

    }

    /********* UPDATE Permission Status***********/
    public function updateStatus(Request $request,Permission $permission){
        $permission->update([
          'is_active' => $permission->is_active == 1 ? 0:1
        ]);
        return response()->json(["state" => "success", "message" => trans('messages.response.permissions.update_status_success'),"permissions" => $this->getter($request)] );
    }


    /********* DELETE LANGUAGE ***********/
    public function destroy(Request $request,Permission $permission)
    {
          $permission->delete();
          $this->attachAllPermissionsToSuperAdmin();
          return response()->json(["state" => "success", "message" =>trans('messages.response.permissions.delete_success'),"permissions" => $this->getter($request)] );
    }
}
