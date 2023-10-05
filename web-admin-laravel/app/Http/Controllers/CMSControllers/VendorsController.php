<?php

namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\VendorStore;
use App\Http\Requests\CMS\Vendors\CreateRequest;
use App\Http\Requests\CMS\Vendors\UpdateRequest;
use App\Http\Resources\CMS\VendorsResource;
use Excel;
use Illuminate\Support\Facades\Hash;
use App\Exports\CMS\VendorsExport;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Setting;
use App\Models\Role;
use Str;
use PDF;

class VendorsController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
      $this->middleware('auth:api');
      $this->middleware('permission:vendors.index,guard:api');
      $this->middleware('permission:vendors.create,guard:api',['only' => ['store']]);
      $this->middleware('permission:vendors.update,guard:api',['only' => ['update']]);
      $this->middleware('permission:vendors.delete,guard:api',['only' => ['destroy']]);
      $this->middleware('permission:vendors.update|vendors.is_active,guard:api',['only' => ['updateStatus']]);
  }

  /********* Getter For Pagination, Searching And Sorting  ***********/
  public function getter($req = null,$export = null)
  {
    if($req != null){
      $vendors =  Vendor::withAll();
      $vendors = $vendors->where('id','!=',1);
      if($req->column && $req->column != null && $req->search && $req->search != null){
          $vendors = $vendors->whereLike($req->column,$req->search);
        }
       else if($req->search && $req->search != null){
            $vendors = $vendors->whereLike(['name','store.name', 'email', 'store.phone'],$req->search);
        }
      if($req->sort !=null && $req->sort["field"] != null && $req->sort["type"] != null){
        $vendors = $vendors->OrderBy($req->sort["field"],$req->sort["type"]);
      }
      else
      {
        $vendors = $vendors->OrderBy('id','desc');
      }
      if($export != null){ // for export do not paginate
        $vendors = $vendors->get();
        return $vendors;
      }
      $totalVendors = $vendors->count();
      $vendors = $vendors->paginate($req->perPage);
      $vendors = VendorsResource::collection($vendors)->response()->getData(true);
      return $vendors;
    }
    $vendors = VendorsResource::collection(Vendor::withAll()->orderBy('id','desc')->where('id','!=',1)->paginate(10))->response()->getData(true);
    return $vendors;
  }

  /********* FETCH ALL Vendors ***********/
    public function index()
    {
        $arrayName = array('vendors' => $this->getter());
        return response($arrayName);
    }
      /********* Export PDF , CSV And Excel  **********/
    public function export(Request $request)
    {
        $vendors = $this->getter($request,"export");
        if ($request->export == 'pdf') {
            $allSettings = Setting::where('name', 'web_logo_image_id')->first();
            $logo = Media::find((int)$allSettings->value);
            $new_logo = str_replace("/api/", "", $logo->original_media_path);
            $data['general'] = [
                'currentDate' => date("Y-m-d"),
                'fileName' => "Vendors",
                'reportName' => "Vendors",
                'logo' => $new_logo,
            ];
            $data['tableHeaders'] = ["Sr#", "Name", "Email", "Store Name", "Featured", "Status"];
            $data['tableData'] = [];
            foreach ($vendors as $key => $vendor) {
                if ($vendor->is_active == 1) {
                    $is_active = "Active";
                } else {
                    $is_active = "Inactive";
                }
                if ($vendor->is_featured == 1) {
                    $is_feature = "Yes";
                } else {
                    $is_feature = "No";
                }

                $result = [++$key, $vendor->name, $vendor->email,$vendor->slug, $is_feature,$is_active];
                $data['tableData'][] = $result;
            }
            $pdf = PDF::loadView('pdf.pages', $data);
            return $pdf->setPaper('A4', 'potrait')->download('vendor.pdf');
        }
        $filename = "vendors.".$request->export;
        return Excel::download(new VendorsExport($vendors), $filename);
    }

  /********* FILTER Vendors FOR Search ***********/
   public function filter(Request $request){
       return response()->json(["state" => "success", "message" => trans('messages.response.vendors.filter_success'),"vendors" => $this->getter($request)] );
   }

    /********* ADD NEW Vendor ***********/
    public function store(CreateRequest $request, Vendor $vendor , VendorStore $vendor_store)
    {
      $role = Role::where('name','vendor')->first();
      //Generating slug
      $slug = Str::slug($request->name);
      $store_slug = Str::slug($request->store_details['name']);
      $request->merge(["slug"=> $slug,"role_id" => $role->id]);

      //Creating Vendor
      $vendor_data = $request->except(['categories' , 'store_details']);
      $hashed_password = Hash::make($request->password);
      $vendor_data['password'] = $hashed_password;
      $created_vendor = $vendor->create($vendor_data);

      //Creating Vendor Sotre
      $vendor_store_data = $request->store_details;
      $vendor_store_data['cover_image_id'] = $request->cover_image_id;
      $vendor_store_data['logo_image_id'] = $request->logo_image_id;
      $vendor_store_data['vendor_id'] = $created_vendor->id;
      $vendor_store_data['slug'] = $store_slug;
      $vendor_store_created = $vendor_store->create($vendor_store_data);

      //Ataching Vendor Categories
      $created_vendor->categories()->attach($request->categories);
      return response(["message" => trans('messages.response.vendors.create_success')]);
    }

    /********* View RECORD TO EDIT Or Display ***********/
    public function show($vendor)
    {
        $vendor= Vendor::withAll()->find($vendor);
        return new VendorsResource($vendor);
    }



    /********* UPDATE Vendor ***********/
    public function update(UpdateRequest $request, Vendor $vendor , VendorStore $vendor_store)
    {
      if($request->is_credentials){
        //Generating slug
        $slug = Str::slug($request->name);
        $request->merge(["slug"=> $request->name]);
        $vendor_data = $request->except(['categories' , 'store_details']);
        $hashed_password = Hash::make($request->password);
        $vendor_data['password'] = $hashed_password;
        $vendor->update($vendor_data);
    }
      else
      {
        $slug = Str::slug($request->name);
        $request->merge(["slug"=> $request->name]);
        $vendor_data = $request->except(['categories' , 'store_details']);
        $vendor->update($vendor_data);
      }
      $store_slug = Str::slug($request->store_details['name']);
      //Generating slug
      $vendor_store_data = $request->store_details;
      $vendor_store_data['cover_image_id'] = $request->cover_image_id;
      $vendor_store_data['logo_image_id'] = $request->logo_image_id;
      $vendor_store_data['slug'] = $store_slug;
      $vendor_store_data['vendor_id'] = $vendor->id;
      $vendor_store_created = $vendor_store->where('vendor_id' , $vendor->id)->update($vendor_store_data);
      $vendor->categories()->sync($request->categories);
        return response(["message" => trans('messages.response.vendors.update_success')]);

    }

    /********* UPDATE Vendor Status***********/
    public function updateStatus(Request $request,Vendor $vendor){
        $vendor->update([
          'is_active' => $vendor->is_active == 1 ? 0:1
        ]);
        return response()->json(["state" => "success", "message" => trans('messages.response.vendors.update_status_success'),"vendors" => $this->getter($request)] );
    }

        /********* UPDATE Vendor Store Status***********/
        public function updateVendorStoreStatus(Request $request,Vendor $vendor){
            $vendor->store->update([
              'is_active' => $vendor->store->is_active == 1 ? 0:1
            ]);
            return response()->json(["state" => "success", "message" => trans('messages.response.vendors.update_store_status_success'),"vendors" => $this->getter($request)] );
        }

              /********* UPDATE Vendor Featured Status***********/
              public function updateVendorFeatured(Request $request,Vendor $vendor){

                $vendor->update([
                  'is_featured' => $vendor->is_featured == 1 ? 0:1
                ]);
                return response()->json(["state" => "success", "message" => trans('messages.response.vendors.update_status_success'),"vendors" => $this->getter($request)] );
            }


    /********* DELETE LANGUAGE ***********/
    public function destroy(Request $request,Vendor $vendor)
    {
          $vendor->categories()->detach();
          if($vendor->products){
            $vendor->products()->delete();
          }
          $vendor->delete();
          return response()->json(["state" => "success", "message" => trans('messages.response.vendors.delete_success'),"vendors" => $this->getter($request)] );
    }
}
