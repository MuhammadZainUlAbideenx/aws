<?php

namespace App\Http\Controllers\WebControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\Brand;
use App\Http\Resources\Web\BrandsResource;
use App\Http\Resources\Web\ProductsResource;
use App\Models\CMSModels\Product;

class ApiBrandsController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
    public function __construct()
    {

    }

    public function getter( $req = null,$export = null)
    {
      $brands =  Brand::withAll()->where('is_active',1);
      if(count($req->all()) != 0){
        $sort = json_decode($req->sort);
        if($req->column && $req->column != null && $req->search && $req->search != null){
          if($req->column == 'name'){
            $brands = $brands->whereLike($req->column.'->'.app()->getLocale(),$req->search);
          }
          else{
            $brands = $brands->whereLike($req->column,$req->search);
            }
          }
         else if($req->search && $req->search != null){

              $brands = $brands->whereLike(['name->'.app()->getLocale()],$req->search);
          }
        if($sort !=null && $sort->field != null && $sort->type != null){
          $brands = $brands->OrderBy($sort->field,$sort->type);
        }
        else
        {
          $brands = $brands->OrderBy('id','desc');
        }
        $brands = $brands->paginate($req->perPage);
        $brands = BrandsResource::collection($brands)->response()->getData(true);

        return $brands;
      }
      $brands = $brands->orderBy('id','desc')->paginate(18);
      $brands = BrandsResource::collection($brands)->response()->getData(true);
      return $brands;
    }
    // Posts
    public static function featuredBrands(){
        $brands = Brand::withAll()
                          ->where('is_active',1)
                          ->where('is_featured',1)
                          ->whereHas('image')
                          // ->orderBy('is_featured','DESC')
                          ->take(config('constants.brands_limit'))
                          ->get();
        $brands = BrandsResource::collection($brands);
        return $brands;
    }

    public function allBrands(Request $request){
        $allbrands = $this->getter($request);
        $response = generateResponse($allbrands,true,'',[],'collection');
        return response($response);
    }

    public function brandDetail($brand){
        $brand = Brand::withAll()->where('id',$brand)->where('is_active',1)->first();
        if($brand){
          $brand = new BrandsResource($brand);
          $response = generateResponse($brand,true,'',[],'object');
          return response($response);
        }
        else{
          $response = generateResponse('',false,trans('messages.response.web.post_not_found'),[],'object');
          return response($response,404);
        }
    }
// for a customer app
    public function brandProducts($id){
        $products = Product::withAll()->where('brand_id', $id)->get();
        $products = ProductsResource::collection($products);
        $response = generateResponse($products,count($products) > 0 ? true : false,'',[],'collection');
        return response($response);
    }
}
