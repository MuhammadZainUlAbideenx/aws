<?php

namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\Address;
use App\Models\CMSModels\Customer;
use App\Http\Requests\CMS\Addresses\CreateRequest;
use App\Http\Resources\CMS\AddressesResource;
use Excel;
use App\Exports\CMS\AddressesExport;
use Hash;
class AddressesController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
      $this->middleware('auth:api');
      $this->middleware('permission:addresses.index,guard:api');
      $this->middleware('permission:addresses.create,guard:api',['only' => ['store']]);
      $this->middleware('permission:addresses.update,guard:api',['only' => ['update']]);
      $this->middleware('permission:addresses.delete,guard:api',['only' => ['destroy']]);
      $this->middleware('permission:addresses.update|addresses.is_active,guard:api',['only' => ['updateStatus']]);
  }

  /********* Getter For Pagination, Searching And Sorting  ***********/
  public function getter($req = null,$export = null)
  {
    if($req != null){
      $addresses = Address::withAll()->where('customer_id' , $req->id);
      if($req->column && $req->column != null && $req->search && $req->search != null){
        $addresses = $addresses->whereLike($req->column,$req->search);
      }else if($req->search && $req->search != null){
           $addresses = $addresses->whereLike(['country.name','city.name','address','state.name'],$req->search);
        }
      if($req->sort !=null && $req->sort["field"] != null && $req->sort["type"] != null){
        $addresses = $addresses->OrderBy($req->sort["field"],$req->sort["type"]);
      }
      else
      {
        $addresses = $addresses->OrderBy('id','desc');

      }
      if($export != null){ // for export do not paginate
        $addresses = $addresses->get();
        return $addresses;
      }
      $totalAddresses = $addresses->count();
      $addresses = $addresses->paginate($req->perPage);
      $addresses = AddressesResource::collection($addresses)->response()->getData(true);
      return $addresses;
    }
    $addresses = Address::withAll()->orderBy('id','desc')->paginate(10);
    $addresses = AddressesResource::collection($addresses)->response()->getData(true);
    return $addresses;
  }

  /********* FETCH ALL Addresses ***********/
    public function addresses_index($id)
    {
      $addresses = Address::withAll()->where('customer_id' , $id)->paginate(10);
      $addresses = AddressesResource::collection($addresses)->response()->getData(true);
      $arrayName = array('addresses' => $addresses);
      return response($arrayName);
    }
      /********* Export PDF , CSV And Excel  **********/
    public function export(Request $request)
    {
        $addresses = $this->getter($request,"export");
        $filename = "addresses.".$request->export;
        return Excel::download(new AddressesExport($addresses), $filename);
    }

  /********* FILTER Addresses FOR Search ***********/
   public function filter(Request $request){
       return response()->json(["state" => "success", "message" =>  trans('messages.response.addresses.filter_success'),"addresses" => $this->getter($request)] );
   }

    /********* ADD NEW Address ***********/
    public function store(CreateRequest $request)
    {
      $customer = Customer::find($request->customer_id);
      if($customer){
        $customer->addresses()->create($request->all());
        return response(["message" => trans('messages.response.addresses.create_success')]);
      }else{
        return abort(404);
      }
    }

    /********* View RECORD TO EDIT Or Display ***********/
    public function show($address)
    {
        $address = Address::withAll()->find($address);
        return new AddressesResource($address);
    }

    /********* UPDATE Address ***********/
    public function update(CreateRequest $request, Address $address)
    {
        $address->update($request->all());
        return response(["message" => trans('messages.response.addresses.update_success')]);
    }

    /********* UPDATE Manufacturer Status***********/
  //  public function updateStatus(Request $request,Address $address){
  //      $address->update([
  //        'is_active' => $address->is_active == 1 ? 0:1
  //      ]);
  //      return response()->json(["state" => "success", "message" => trans('messages.response.addresses.update_status_success'),"addresses" => $this->getter($request)] );
  //  }

    /********* DELETE LANGUAGE ***********/
    public function destroy(Request $request,Address $address)
    {
        $addresses = Address::where('id' , $address->id)->first();
        $customer = $addresses->customer_id;
        $address->delete();
        $addresses = Address::withAll()->where('customer_id' , $customer)->paginate(10);
        $addresses = AddressesResource::collection($addresses)->response()->getData(true);
        return response()->json(["state" => "success", "message" => trans('messages.response.addresses.delete_success'),"addresses" => $addresses] );
    }
}
