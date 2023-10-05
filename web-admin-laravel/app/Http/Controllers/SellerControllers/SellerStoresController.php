<?php

namespace App\Http\Controllers\SellerControllers;
use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\VendorStore;
use App\Http\Requests\Vendor\VendorsStore\UpdateRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Vendor\VendorsResource;
use App\Http\Resources\Vendor\VendorStoresResource;
use Str;

class SellerStoresController extends Controller
{
  /********* Initialize Permission based Middlewares  ***********/
public function __construct()
{
    $this->middleware('auth:vendor-api');
    $this->middleware('scope:vendor');
}

    public function getVendorStore(){
    $vendor = Auth::user();
    $vendor= Vendor::withAll()->find($vendor->id);
    return new VendorsResource($vendor);
  }
  public function createOrUpdateVendorStore(UpdateRequest $request){
      //Generating slug
      $vendor = Auth::user();
      // $slug = Str::slug($request->name);
      // $request->merge(["slug"=> $request->name]);
      // $vendor_data = $request->except(['categories' , 'store_details']);
      // if($request->password != '' && $request->password != null){
      // $hashed_pass = Hash::make($request->password);
      //   $vendor_data['password'] = $hashed_pass;
      // }
      // $vendor->update($vendor_data);
    $store_slug = Str::slug($request->store_details['name']);
    //Generating slug

    $vendor_store_data = $request->store_details;
    $vendor_store_data['cover_image_id'] = $request->cover_image_id;
    $vendor_store_data['logo_image_id'] = $request->logo_image_id;
    $vendor_store_data['slug'] = $store_slug;
    $vendor_store_data['vendor_id'] = $vendor->id;
    $vendor_store = VendorStore::where('vendor_id' , $vendor->id)->first();
    $store_slug_exist = VendorStore::where('slug',$store_slug)->first();

    if ($store_slug_exist && !$vendor_store) {
        return response(["message" => trans('messages.response.vendors.store_allready_exist'), "state" => false]);
    }
    if ($vendor_store && $store_slug_exist) {
        if ($store_slug_exist->slug == $vendor_store->slug) {

        }
        else
        {
            return response(["message" => trans('messages.response.vendors.store_allready_exist'), "state" => false]);
        }
    }
    if($vendor_store){
      // dd("vendor_store");
      $vendor_store= $vendor_store->update($vendor_store_data);
    }else{
        $vendor_store = $vendor->store()->create($vendor_store_data);
    }
    $vendor->categories()->sync($request->categories);
    $vendor_store = VendorStore::where('vendor_id' , $vendor->id)->first();
    return response(["message" => trans('messages.response.vendors.store_update_success'),"state" => true, "details" => new VendorStoresResource($vendor_store)]);
}


}
