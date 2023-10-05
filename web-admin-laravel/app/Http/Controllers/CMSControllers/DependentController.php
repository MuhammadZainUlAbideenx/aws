<?php

namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\CityByState\CreateRequest as CityByStateCreateRequest;
use App\Http\Requests\Mobile\StatesByCountry\CreateRequest as StatesByCountryCreateRequest;
use Illuminate\Http\Request;
use App\Models\CMSModels\Country;
use App\Http\Resources\CMS\CitiesResource;
use App\Http\Resources\CMS\ZonesResource;
use App\Models\CMSModels\State;
use App\Http\Resources\CMS\StatesResource;
use App\Models\CMSModels\Attribute;
use App\Http\Resources\CMS\AttributesResource;
use App\Models\CMSModels\Product;

class DependentController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
      // $this->middleware('auth:api',['except' =>['activeLanguages'] ]);
  }
    /********* FETCH ALL Zones By Country ***********/
    public function getZonesByCountry($id,Request $request)
    {
      $country = Country::find($id);
      if($country){
        $zones = $country->zones()->where('is_active',1);
        if($zones && $request->search){
          $zones = $zones->whereLike('name',$request->search);
        }
        $zones = $zones->paginate(10);
        $zones = ZonesResource::collection($zones)->response()->getData(true);
        $zones = ['zones' => $zones,'fetched' => true];
        return response()->json(['zones' => $zones]);
      }else{
          return response(404);
      }

    }
    public function getStatesByCountry($id,Request $request)
    {
      $country = Country::find($id);
      if($country){
        $states = $country->states()->where('is_active',1);
        if($states && $request->search){
          $states = $states->whereLike('name',$request->search);
        }
        $states = $states->paginate(10);
        $states = StatesResource::collection($states)->response()->getData(true);
        $states = ['states' => $states,'fetched' => true];
        return response()->json(['states' => $states]);
      }else{
          return response(404);
      }
    }
    public function getStatesByCountryMobile(StatesByCountryCreateRequest $request)
    {
      $country = Country::find($request->id);
      if($country){
        $states = $country->states()->where('is_active',1);
        $states = $states->paginate(10);
        $states = StatesResource::collection($states);
        $states = ['states' => $states,'fetched' => true];
        return response()->json(['states' => $states]);
      }else{
          return response(404);
      }
    }
    public function getAttributeValuesByAttribute($id,Request $request)
    {
      $attribute = Attribute::with(['values' => function($q){
                    $q->where('is_active',1);
                  }])->where('id',$id)->first();
      if($attribute){
      $attribute = new AttributesResource($attribute);
      $data = ['attribute' => $attribute,'fetched' => true];
        return response()->json($data);
      }else{
          return response(404);
      }
    }
    public function getCitiesByState($id,Request $request)
    {
      $state = State::find($id);
      if($state){
        $cities = $state->cities()->where('is_active',1);
        if($cities && $request->search){
          $cities = $cities->whereLike('name',$request->search);
        }
        $cities = $cities->paginate(10);
        $cities = CitiesResource::collection($cities)->response()->getData(true);
        $cities = ['cities' => $cities,'fetched' => true];
        return response()->json(['cities' => $cities]);
      }else{
        return response(404);
      }
    }
    public function getCitiesByStateMobile(CityByStateCreateRequest $request)
    {
      $state = State::find($request->id);
      if($state){
        $cities = $state->cities()->where('is_active',1);
        $cities = $cities->paginate(10);
        $cities = CitiesResource::collection($cities)->response()->getData(true);
        $cities = ['cities' => $cities,'fetched' => true];
        return response()->json(['cities' => $cities]);
      }else{
        return response(404);
      }
    }
    public function getProductInventory(Product $product)
    {
      $product = Product::withAll()->find($product->id);
      $total_stock_in = $product->inventories()->where('stock_type','in')->sum('stock');
      $total_stock_out = $product->inventories()->where('stock_type','out')->sum('stock');
      $current_stock =  $total_stock_in - $total_stock_out;
      $total_purchase_price = $product->inventories()->where('stock_type','in')->sum('purchase_price');

      return response()->json(['product' => $product, 'current_stock' => $current_stock,'total_purchase_price' => $total_purchase_price ]);

    }
}
