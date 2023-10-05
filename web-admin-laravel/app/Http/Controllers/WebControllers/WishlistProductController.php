<?php

namespace App\Http\Controllers\WebControllers;
use App\Http\Controllers\Controller;
use App\Http\Resources\Web\ProductsResource;
use Illuminate\Http\Request;
use App\Models\CMSModels\WishlistProduct;
use App\Models\CMSModels\Customer;
use App\Models\CMSModels\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WishlistProductController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
    public function __construct()
    {
        $this->middleware('auth:customer-api');
    }
    public function getter($req = null)
    {
      $customer = Auth::user();
      $products =  $customer->wishlistProducts()->where('is_active',1)->with('attributes');
      if(count($req->all()) != 0){
        $sort = json_decode($req->sort);
        if($req->column && $req->column != null && $req->search && $req->search != null){
          if($req->column == 'name'){
            $products = $products->whereLike($req->column.'->'.app()->getLocale(),$req->search);
          }
          else{
            $products = $products->whereLike($req->column,$req->search);
            }
          }
         else if($req->search && $req->search != null){

              $products = $products->whereLike(['name->'.app()->getLocale()],$req->search);
          }
        if($sort !=null && $sort->field != null && $sort->type != null){
          $products = $products->OrderBy($sort->field,$sort->type);
        }
        else
        {
          $products = $products->OrderBy('id','desc');
        }
        $products = $products->paginate($req->perPage);
        $products = ProductsResource::collection($products)->response()->getData(true);

        return $products;
      }
      $products = $products->orderBy('id','desc')->paginate(12);
      $products = ProductsResource::collection($products)->response()->getData(true);
      return $products;
    }
    // Posts
    public function index(Request $request){
        $wishlist_products=$this->getter($request);
        $response = generateResponse($wishlist_products,true,'',[],'collection');
        return $response;
    }
    public function store(Request $request){
        $customer = Auth::user();
        // $customer = Customer::find(2);
        // dd($customer->wishlistProducts);
        $db_product = Product::where('is_active',1)->where('id',$request->product_id)->first();
        if(!$db_product){
          $data = ['message' =>  trans('messages.response.web.invalid_product')];
          $response = generateResponse($data,false,'',[],'object');
          return $response;
        }
        $product = $customer->wishlistProducts()->where('product_id', $request->product_id)->first();
       if($product)
       {
        $data = ['message' => trans('messages.response.web.already_added_to_wishlist')];
        $response = generateResponse($data,false,'',[],'object');
        return $response;
       }

       $product_added = $customer->wishlistProducts()->attach([ $request->product_id]);
        $data = ['message' => trans('messages.response.web.added_to_wishlist')];
        $response = generateResponse($data,true,'',[],'object');
        return $response;

    }

    public function searchWishlistProduct(Request $request)
    {
        $customer = Auth::user();
        // dd( $customer);
        $validator = Validator::make($request->all(), [
            'search' => 'required',
        ]);
        if ($validator->fails()) {
            $response = generateResponse('', false, '', $validator->errors(), 'object');
            return $response;
        }
        $products = Product::withAll();
        $products = $products->whereLike('name'.'->'.app()->getLocale(),$request->search)->get();
        $product_ids = $products->pluck('id')->toArray();
        $wishlist_products = WishlistProduct::withAll()->where('customer_id', $customer->id)->whereIn('product_id',$product_ids)->get();
        $wishlist_products_id = $wishlist_products->pluck('product_id')->toArray();
        $retern_product = Product::whereIn('id', $wishlist_products_id)->withAll()->paginate(10);
        $retern_product = ProductsResource::collection($retern_product)->response()->getData(true);
        $response = generateResponse($retern_product,true,'',[],'collection');
        return response($response);
    }


    public function destroy(Request $request){
        $wishlist = WishlistProduct::where('product_id',$request->product_id)->first();
        if($wishlist){
          $wishlist->delete();
          $data = ['message' => trans('messages.response.web.remove_from_wishlist')];
        //   $message =  'Selected item deleted from wishlist';
        $response = generateResponse($data,true,'',[],'object');
        return $response;
        }
        else
        {
            // $message =  'Wishlist Product not Found';
            $data = ['message' => trans('messages.response.web.product_not_found')];
            $response = generateResponse($data,false,'',[],'object');
            return $response;
        }

    }
}
