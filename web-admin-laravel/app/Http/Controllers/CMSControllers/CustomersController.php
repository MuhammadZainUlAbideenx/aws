<?php

namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\Customer;
use App\Http\Requests\CMS\Customers\CreateRequest;
use App\Http\Requests\CMS\Customers\UpdateRequest;
use App\Http\Resources\CMS\CustomersResource;
use App\Models\User;
use App\Models\Role;
use Excel;
use App\Exports\CMS\CustomersExport;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Setting;
use Hash;
use PDF;
class CustomersController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
      $this->middleware('auth:api');
      $this->middleware('permission:customers.index,guard:api',['except' =>['activeCustomers'] ]);
      $this->middleware('permission:customers.create,guard:api',['only' => ['store']]);
      $this->middleware('permission:customers.update,guard:api',['only' => ['update']]);
      $this->middleware('permission:customers.delete,guard:api',['only' => ['destroy']]);
      $this->middleware('permission:customers.update|customers.is_active,guard:api',['only' => ['updateStatus']]);
  }

  /********* Getter For Pagination, Searching And Sorting  ***********/
  public function getter($req = null,$export = null)
  {
    if($req != null){
      $customers = Customer::withAll();
      if($req->column && $req->column != null && $req->search && $req->search != null){
        if($req->column == 'name'){
          $customers = $customers->whereLike(['first_name','last_name'],$req->search);
        }else{
        $customers = $customers->whereLike($req->column,$req->search);
        }
      }else if($req->search && $req->search != null){
           $customers = $customers->whereLike(['first_name','last_name','phone','email'],$req->search);
        }
      if($req->sort !=null && $req->sort["field"] != null && $req->sort["type"] != null){
        $customers = $customers->OrderBy($req->sort["field"],$req->sort["type"]);
      }
      else
      {
        $customers = $customers->OrderBy('id','desc');
      }
      if($export != null){ // for export do not paginate
        $customers = $customers->get();
        return $customers;
      }
      $totalCustomers = $customers->count();
      $customers = $customers->paginate($req->perPage);
      $customers = CustomersResource::collection($customers)->response()->getData(true);
      return $customers;
    }
    $customers = Customer::withAll()->orderBy('id','desc')->paginate(10);
    $customers = CustomersResource::collection($customers)->response()->getData(true);
    return $customers;
  }

  /********* FETCH ALL Customers ***********/
    public function index()
    {
        $arrayName = array('customers' => $this->getter());
        return response($arrayName);
    }
      /********* Export PDF , CSV And Excel  **********/
    public function export(Request $request)
    {
        $customers = $this->getter($request,"export");
        if ($request->export == 'pdf') {
            $allSettings = Setting::where('name', 'web_logo_image_id')->first();
            $logo = Media::find((int)$allSettings->value);
            $new_logo = str_replace("/api/", "", $logo->original_media_path);
            $data['general'] = [
                'currentDate' => date("Y-m-d"),
                'fileName' => "Customer",
                'reportName' => "Customer",
                'logo' => $new_logo,
            ];
            $data['tableHeaders'] = ["Sr#", "First Name", "Last Name", "Email", "Gender", "DOB", "Phone",  "Status"];
            $data['tableData'] = [];
            foreach ($customers as $key => $customer) {
                if ($customer->is_active == 1) {
                    $is_active = "Active";
                } else {
                    $is_active = "Inactive";
                }

                $result = [++$key, $customer->first_name,$customer->last_name, $customer->email,$customer->gender,date('d-m-Y', strtotime($customer->dob)), $customer->phone,$is_active];
                $data['tableData'][] = $result;
            }
            $pdf = PDF::loadView('pdf.pages', $data);
            return $pdf->setPaper('A4', 'potrait')->download('customer.pdf');
        }
        $filename = "customers.".$request->export;
        return Excel::download(new CustomersExport($customers), $filename);
    }

  /********* FILTER Customers FOR Search ***********/
   public function filter(Request $request){
       return response()->json(["state" => "success", "message" => trans('messages.response.customers.filter_success'),"customers" => $this->getter($request)] );
   }

    /********* ADD NEW Customer ***********/
    public function store(CreateRequest $request)
    {

      $customer = new Customer();
      $hashed_password = Hash::make($request->password);
      $data = $request->except(['passowrd']);
      $data['password'] = $hashed_password;
      if($request->address){

         $customer = $customer->create($data);
         $add = $customer->addresses()->create($data);
      }else{
        $data = $request->except(['address','country_id','state_id','city_id','zip_code','passowrd']);
        $data['password'] = $hashed_password;
        $customer = $customer->create($data);
      }
      return response(["message" => trans('messages.response.customers.create_success')]);
    }

    /********* View RECORD TO EDIT Or Display ***********/
    public function show($customer)
    {
        $customer = Customer::withAll()->find($customer);
        return new CustomersResource($customer);
    }

    /********* UPDATE Customer ***********/
    public function update(UpdateRequest $request, Customer $customer)
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
        $customer->update($data);
      }else{
        $data = $request->except(['is_credentials','password','email']);
        $customer->update($data);
      }
        return response(["message" => trans('messages.response.customers.update_success')]);
    }

    /********* UPDATE Manufacturer Status***********/
    public function updateStatus(Request $request,Customer $customer){
        $customer->update([
          'is_active' => $customer->is_active == 1 ? 0:1
        ]);
        return response()->json(["state" => "success", "message" => trans('messages.response.customers.update_status_success'),"customers" => $this->getter($request)] );
    }

    /********* DELETE LANGUAGE ***********/
    public function destroy(Request $request,Customer $customer)
    {
          if($customer->addresses()){
            $customer->addresses()->delete();
          }
          $customer->delete();
          return response()->json(["state" => "success", "message" => trans('messages.response.customers.delete_success'),"customers" => $this->getter($request)] );
    }
}
