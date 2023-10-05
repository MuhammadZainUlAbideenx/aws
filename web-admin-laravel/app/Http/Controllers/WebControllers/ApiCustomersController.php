<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\Category;
use App\Models\Vendor;
use App\Models\CMSModels\Address;
use App\Models\CMSModels\Country;
use App\Models\CMSModels\City;
use App\Models\CMSModels\State;
use App\Http\Resources\Web\CategoriesResource;
use App\Http\Resources\Web\CustomerResource;
use App\Http\Resources\Web\OrderResource;
use App\Http\Resources\Web\ProductsByCategoriesResource;
use App\Http\Resources\Web\VendorsResource;
use App\Http\Resources\Web\AddressesResource;
use App\Http\Resources\Web\CountriesResource;
use App\Http\Resources\Web\CitiesResource;
use App\Http\Resources\Web\OrdersResource;


use App\Http\Resources\Web\StatesResource;
use App\Http\Resources\Web\CustomerWithAddressesResource;
use App\Models\CMSModels\Product;
use App\Http\Requests\Web\Addresses\CreateRequest;
use App\Http\Requests\Web\Addresses\UpdateRequest;
use App\Http\Requests\Web\CustomerProfile\CustomerProfile;
use App\Http\Resources\Web\ProductsResource;
use App\Http\Resources\Web\SubOrdersResource;
use App\Models\CMSModels\Customer;
use App\Models\CMSModels\Order;
use Illuminate\Support\Facades\App;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Hash;

class ApiCustomersController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
    public function __construct()
    {
        $this->middleware('auth:customer-api', ['except' => ['activeCountries', 'getStatesByCountry', 'getCitiesByState']]);
        $this->middleware('scope:customer', ['except' => ['activeCountries', 'getStatesByCountry', 'getCitiesByState']]);
    }

    public function getter($req = null, $export = null)
    {
        $customer = Auth::user();
        $orders =  $customer->orders()->withAll()->withAllDetail()->where('is_active', 1)->where('parent_order_id', 0);

        if (count($req->all()) != 0) {
            if ($req->search && $req->search != null) {
                $orders = $orders->where('order_number', 'LIKE', '%' . $req->search . '%');
            }
            if ($req->status != null) {

                $orders = $orders->where('order_status_id', $req->status);
            }

            if ($req->date && $req->date != null) {

                $orders = $orders->whereDate('created_at', date('Y-m-d', strtotime($req->date)));
            }
            $orders = $orders->OrderBy('id','desc');
            $orders = $orders->paginate($req->perPage);
            $orders = OrdersResource::collection($orders)->response()->getData(true);

            return $orders;
        }
        $orders = $orders->orderBy('id', 'desc')->paginate(10);
        $orders = OrdersResource::collection($orders)->response()->getData(true);
        return $orders;
    }


    public function CutomerOrders(Request $request)
    {
        $customer_orders = $this->getter($request);
        $response = generateResponse($customer_orders, true, '', [], 'collection');
        return response($response);
    }
    public function CutomerProfile()
    {
        $customer = Auth::user();
        $customer = new CustomerResource($customer);
        $response = generateResponse($customer, true, '', [], 'object');
        return response($response);
    }
    public function OrderDetail($id)
    {
        $data = Order::withAll()->withAllDetail()->find($id);
        $sub_orders = Order::withAll()->with('vendor',function($q){
            $q->with('store');})
            ->with('payment_method')->with('order_products')->with('rider')->with('vendor_order_products')->where('parent_order_id', $id)->get();
        $data['order'] = SubOrdersResource::collection($sub_orders);
        $data['sub_order'] = false;
        if (count($data['order']) > 0){
            $data['sub_order'] = true;
        }
        $order_detail = new OrdersResource($data);
        $response = generateResponse($order_detail, true, '', [], 'object');
        return response($response);
    }
    public function OrderDetailMobile(Request $request)
    {
        $data = Order::withAll()->WithAllDetail()->find($request->id);
        $sub_orders = Order::withAll()->with('vendor',function($q){
            $q->with('store');})
            ->with('payment_method')->with('order_products')->with('rider')->with('vendor_order_products')->where('parent_order_id', $request->id)->get();
        $data['order'] = SubOrdersResource::collection($sub_orders);
        $data['sub_order'] = false;
        if (count($data['order']) > 0){
            $data['sub_order'] = true;
        }
        $order_detail = new OrdersResource($data);
        $response = generateResponse($order_detail, true, '', [], 'object');
        return response($response);
    }
    public function addCustomerAddress(CreateRequest $request)
    {
        $customer = Auth::user();
        $data = $request->all();
        $data['customer_id'] = $customer->id;
        if ($request->is_default) {
            $customer_all_addresses = $customer->addresses()->get();
            foreach ($customer_all_addresses as $address) {
                $address->update([
                    'is_default' => 0
                ]);
            }
        }
        $add = $customer->addresses()->create($data);
        $message =  trans('messages.response.addresses.create_success');
        $response = generateResponse('', true, $message, [], 'object');
        return $response;
    }

    public function updateCustomerAddress(UpdateRequest $request)
    {
        $address = Address::find($request->id);
        $customer = Auth::user();
        $data['city_id'] = $request->city_id;
        $data['country_id'] = $request->country_id;
        $data['customer_id'] = $customer->id;
        $data['state_id'] = $request->state_id;
        $data['near_by'] = $request->near_by;
        $data['address'] = $request->address;
        $data['zip_code'] = $request->zip_code;
        $data['latitude'] = $request->latitude;
        $data['longitude'] = $request->longitude;
        $data['phone'] = $request->phone;
        $data['is_default'] = $request->is_default;
        if ($request->is_default) {
            $customer_all_addresses = $customer->addresses()->where('id', '!=', $address->id)->update(['is_default' => 0]);
            // foreach ($customer_all_addresses as $add) {
            //   $add->update([
            //     'is_default' => false
            //   ]);
            // }
        }
        $address->update($data);

        $message =  trans('messages.response.addresses.update_success');
        $response = generateResponse('', true, $message, [], 'object');
        return $response;
    }
    public function updateCustomerdefaultAddress(Request $request)
    {
        $address = Address::find($request->address_id);
        $customer = Auth::user();
        $data['is_default'] = $request->is_default;
        if ($request->is_default) {
            $customer_all_addresses = $customer->addresses()->get();
            foreach ($customer_all_addresses as $add) {
                $add->update([
                    'is_default' => false
                ]);
            }
        }
        $address->update($data);
        $message =  trans('messages.response.addresses.update_success');
        $response = generateResponse('', true, $message, [], 'object');
        return $response;
    }
    public function viewCustomerAddress($address)
    {
        $address = Address::withAll()->find($address);
        return new AddressesResource($address);
    }
    public function deleteCustomerAddress($id)
    {
        $address = Address::find($id);
        if ($address->is_default) {
            return response(["state" => "fail", "message" => trans('messages.response.addresses.update_fail')]);
        } else {
            $address->delete();
            return response(["state" => "success", "message" => trans('messages.response.addresses.delete_success')]);
        }
    }
    public function deleteCustomerAddressMobile(Request $request)
    {
        $address = Address::find($request->id);
        $address->delete();
        $message =  trans('messages.response.addresses.delete_success');
        $response = generateResponse('', true, $message, [], 'object');
        return $response;
    }
    public function CustomerAllAddresses()
    {
        $customer = Auth::user();
        $addresses = Address::withAll()->where('customer_id', $customer->id)->paginate(10);
        $addresses = AddressesResource::collection($addresses)->response()->getData(true);
        $addresses = generateResponse($addresses, true, '', [], 'array');
        return response($addresses);
    }
    public function activeCities(Request $request)
    {
        $cities = City::where('is_active', 1);
        if ($request->search) {
            $cities = $cities->whereLike('name', $request->search);
        }
        $cities = $cities->paginate(10);
        $cities = CitiesResource::collection($cities)->response()->getData(true);
        $cities = generateResponse($cities, true, '', [], 'collection');
        return response($cities);
    }
    public function activeStates(Request $request)
    {
        $states = State::where('is_active', 1);
        if ($request->search) {
            $states = $states->whereLike('name', $request->search);
        }
        $states = $states->paginate(10);
        $states = StatesResource::collection($states)->response()->getData(true);
        $states = generateResponse($states, true, '', [], 'collection');
        return response($states);
    }
    public function activeCountries(Request $request)
    {
        $countries = Country::where('is_active', 1);
        if ($request->search) {
            $countries = $countries->whereLike('name', $request->search);
        }
        $countries = $countries->paginate(10);
        $countries = CountriesResource::collection($countries)->response()->getData(true);
        $countries = generateResponse($countries, true, '', [], 'collection');
        return response($countries);
    }
    public function getStatesByCountry($id, Request $request)
    {
        $country = Country::find($id);
        if ($country) {
            $states = $country->states()->where('is_active', 1);
            if ($states && $request->search) {
                $states = $states->whereLike('name', $request->search);
            }
            $states = $states->paginate(10);
            $states = StatesResource::collection($states)->response()->getData(true);
            $states = ['states' => $states, 'fetched' => true];
            return response()->json(['states' => $states]);
        } else {
            return response(404);
        }
    }
    public function getCitiesByState($id, Request $request)
    {
        $state = State::find($id);
        if ($state) {
            $cities = $state->cities()->where('is_active', 1);
            if ($cities && $request->search) {
                $cities = $cities->whereLike('name', $request->search);
            }
            $cities = $cities->paginate(10);
            $cities = CitiesResource::collection($cities)->response()->getData(true);
            $cities = ['cities' => $cities, 'fetched' => true];
            return response()->json(['cities' => $cities]);
        } else {
            return response(404);
        }
    }
    public function customerProfileUpdate(CustomerProfile $request)
    {
        $customer = Auth::user();
        $data = $request->except(['is_credentials','old_password' ,'password','password_confirmation']);
        if($request->is_credentials)
        {

            if (!Hash::check($request->old_password,$customer->password)) {
                $message = 'Old Password does not match';
                 $response = generateResponse('',false,$message,[],'object');
                   return $response;
            }
            $hashed_pass = Hash::make($request->password);
            $data['password'] = $hashed_pass;
        }
        $customer->update($data);
        $customer = new CustomerResource($customer);
        $response = generateResponse($customer, true, trans('messages.response.profile.update_success'), [], 'object');
        return response($response);
    }
    public function updateProfileImage(Request $request)
    {
        if (!file_exists(public_path('customers'))) {
            mkdir(public_path('customers'), 0755, true);
        }
        if (!file_exists(public_path('customers/profile_images'))) {
            mkdir(public_path('customers/profile_images'), 0755, true);
        }
        $customer = Auth::user();
        $file = $request->file('file');
        $filename = $customer->first_name . '_' . $file->getClientOriginalName();
        $file_resize = Image::make($file->getRealPath());
        $file_resize->save(public_path('customers/profile_images/' . $filename));
        $file_url = '/api/customers/profile_images/' . $filename;
        if ($customer->profile_image_path) {
            $old_profile_image = explode('/api', $customer->profile_image_path);
            $old_profile_image = public_path() . $old_profile_image[1];
            if (file_exists($old_profile_image)) {
                unlink($old_profile_image);
            }
        }
        $customer->update([
            'profile_image_path' => $file_url,
        ]);
        $customer = new CustomerResource($customer);
        $response = generateResponse($customer, true, trans('messages.response.web.image_uploaded'), [], 'object');
        return response($response);
        // return response()->json(['profile_image_path' => $customer->profile_image_path, 'success' => 'Your Profile image Has been Uploaded', 'message' => 'your Profile image Has been Uploaded'], 200);
    }
    public function customerWithAddresses()
    {
        $customer = Auth::user();
        $customer = new CustomerWithAddressesResource($customer);
        $response = generateResponse($customer, true, '', [], 'object');
        return response($response);
    }
}
