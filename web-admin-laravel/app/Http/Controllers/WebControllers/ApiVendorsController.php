<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Http\Resources\Web\CategoriesResource;
use App\Http\Resources\Web\ProductReviewsResource;
use App\Http\Resources\Web\ProductsByCategoriesResource;
use App\Http\Resources\Web\VendorsResource;
use App\Models\CMSModels\Product;
use App\Http\Resources\Web\ProductsResource;
use App\Models\CMSModels\Review;
use App\Models\VendorFollower;
use App\Models\VendorStore;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

use function GuzzleHttp\Promise\all;

class ApiVendorsController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
    public function __construct()
    {
    }

    public function getter($req = null, $export = null)
    {
        $vendors =  Vendor::withAll()
    ->whereHas('store', function ($q) {
            $q->where('is_active',1);
        })->where('id', '!=', 1)->where('is_active', 1);
        if (count($req->all()) != 0) {
            $sort = json_decode($req->sort);
            if ($req->column && $req->column != null && $req->search && $req->search != null) {
                if ($req->column == 'name') {
                    $vendors = $vendors->whereLike('store.name', $req->search);
                } else {
                    $vendors = $vendors->whereLike($req->column, $req->search);
                }
            } else if ($req->search && $req->search != null) {

                $vendors = $vendors->whereLike(['store.name'], $req->search);
            }
            if ($sort != null && $sort->field != null && $sort->type != null) {
                $vendors = $vendors->OrderBy($sort->field, $sort->type);
            } else {
                $vendors = $vendors->OrderBy('id', 'desc');
            }
            $vendors = $vendors->paginate($req->perPage);
            $vendors = VendorsResource::collection($vendors)->response()->getData(true);

            return $vendors;
        }
        $vendors = $vendors->orderBy('id', 'desc')->paginate(12);
        $vendors = VendorsResource::collection($vendors)->response()->getData(true);
        return $vendors;
    }
    // Featured Vendors
    public function allFeaturedVendors()
    {
        $featured_vendors = Vendor::withAll()
            // ->with('store', function ($q) {
            //     $q->where('is_active',1);
            // })
            // ->with('products', function ($q) {
            //     $q
            //         ->where('available_date', '<=', Carbon::now()->toISOString())
            //         ->where('is_active', 1);
            //     $q->take(config('constants.featured_vendors_products_limit'));
            // })
            ->whereHas('store', function ($q) {
                $q->where('is_active',1);
            })
            ->has('store.cover_image')
            ->has('store.store_logo')
            ->whereHas('products', function ($q) {
                $q->where(function($q){
                    $q->where('product_type', 2)->has('variants');
                })->orWhere('product_type', 1);
                $q
                ->where('available_date', '<=', Carbon::now()->toISOString())
                ->where('is_active', 1);
            $q->take(config('constants.featured_vendors_products_limit'));
            })
            ->where('is_featured', 1)
            ->where('is_active', 1)
            // ->take(config('constants.featured_vendors_limit'))
            ->take(1)
            ->get();
        $featured_vendors = VendorsResource::collection($featured_vendors);
        $response = generateResponse($featured_vendors, count($featured_vendors) > 0 ? true : false, '', [], 'collection');
        return response($response);
    }

    public function allVendors(Request $request)
    {
        $all_vendors = $this->getter($request);
        $response = generateResponse($all_vendors, count($all_vendors) > 0 ? true : false, '', [], 'collection');
        return response($response);
    }

    public function vendorDetail($slug)
    {
        $store = VendorStore::where('slug', $slug)->first();
        $vendor = Vendor::withAll()->where('id', $store->vendor_id)->where('is_active', 1)->first();
        if ($vendor) {
            $categories = $vendor->categories()->with('image')->with('icon')->where('is_active', 1)->where('parent_id', 0)->get();
            $categories = CategoriesResource::collection($categories);
            $new_arrival_products = $vendor->categories()->withAll()
                ->with('products', function ($q) use ($store) {
                    $q->where('vendor_id', $store->vendor_id);
                    $q->where(function($x){
                        $x->where(function($y){
                            $y->where('product_type', 2)->has('variants');
                        })->orWhere('product_type', 1);
                    });
                    $q->orderBYDESC('available_date');
                    $q->where('available_date', '<=', Carbon::now()->toISOString());
                    $q->where('is_active', 1);
                    $q->with('reviews');
                    $q->with('attributes');
                })
                ->whereHas('products', function ($q) {
                    $q->where('available_date', '<=', Carbon::now()->toISOString());
                    $q->where('is_active', 1);
                })

                ->where('parent_id', 0)
                ->where('is_featured', 1)
                ->get()->map(function ($category) {
                    $category->products = $category->products->take(config('constants.new_arrival_products_limit'));
                    return $category;
                });
                $new_arrival_products_for_mobile = Product::where(function($q){
                    $q->where(function($q){
                        $q->where('product_type', 2)->has('variants');
                    })->orWhere('product_type', 1);
                })->withAll()->with('reviews')->where('vendor_id', $store->vendor_id)->orderBYDESC('available_date')->where('available_date', '<=', Carbon::now()->toISOString())->where('is_active', 1)->get();

                $new_arrival_products_for_mobile = ProductsResource::collection($new_arrival_products_for_mobile);
                $new_arrival_products = ProductsByCategoriesResource::collection($new_arrival_products);
            $trending_products = $vendor->Products()->where(function($q){
                $q->where(function($q){
                    $q->where('product_type', 2)->has('variants');
                })->orWhere('product_type', 1);
            })->withAll()->with('reviews')
                ->where('is_active', 1)
                ->where('available_date', '<=', Carbon::now()->toISOString())

                ->take(config('constants.upcoming_products_limit'))
                ->get();
            $trending_products = ProductsResource::collection($trending_products);
            $upcoming_products = $vendor->Products()->where(function($q){
                $q->where(function($q){
                    $q->where('product_type', 2)->has('variants');
                })->orWhere('product_type', 1);
            })->withAll()
                ->where('is_active', 1)
                ->where('available_date', '>=', Carbon::now()->toISOString())
                ->take(config('constants.upcoming_products_limit'))
                ->get();
            $upcoming_products = ProductsResource::collection($upcoming_products);
            $vendor = new VendorsResource($vendor);
            $data = ['vendor' => $vendor, 'categories' => $categories, 'new_arrival_products' => $new_arrival_products, 'new_arrival_products_for_mobile' => $new_arrival_products_for_mobile ,'trending_products' => $trending_products, 'upcoming_products' => $upcoming_products];
            $response = generateResponse($data, true, '', [], 'object');
            return response($response);
        } else {
            $response = generateResponse('', false, trans('messages.response.web.vendor_store_not_found'), [], 'object');
            return response($response, 404);
        }
    }
    public function vendorProducts($slug)
    {

        $vendor = Vendor::withAll()->where('slug', $slug)->where('is_active', 1)->first();
        if ($vendor) {
            $vendor_products = $vendor->Products()->where(function($q){
                $q->where(function($q){
                    $q->where('product_type', 2)->has('variants');
                })->orWhere('product_type', 1);
            })->withAll()
                ->where('is_active', 1)
                ->where('available_date', '<=', Carbon::now()->toISOString())
                ->paginate(10);
            $vendor_products = ProductsResource::collection($vendor_products)->response()->getData(true);
            $response = generateResponse($vendor_products, true, '', [], 'object');
            return response($response);
        } else {
            $response = generateResponse('', false, trans('messages.response.web.vendor_not_found'), [], 'object');
            return response($response);
        }
    }
    public function followVendpor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vendor_id' => 'required|integer',
            'customer_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            $response = generateResponse('', false, '', $validator->errors(), 'object');
            return $response;
        }
        $followed = VendorFollower::where('vendor_id',$request->vendor_id)->where('customer_id',$request->customer_id)->first();
        if ($followed) {
            $followed->delete();
            $response = generateResponse(['is_follow' => false], true, trans('messages.response.web.unfollow_successfully'), [], 'object');
            return response($response);
        }
        else
        {
            VendorFollower::create($request->all());
            $response = generateResponse(['is_follow' => true], true,  trans('messages.response.web.follow_successfully'), [], 'object');
            return response($response);
        }

    }
    public function vendorReviews($slug)
    {
        $store = VendorStore::where('slug', $slug)->first();

        $vendor = Vendor::with(['products' => function($q)
        {
            $q->where('is_active',1);
        }])->with('categories')->with('store')->with('followers')->where('id', $store->vendor_id)->where('is_active', 1)->first();

        if ($vendor) {
            $vendor_products_ids = $vendor->products->pluck('id')->toArray();
            $reviews = Review::with('product')->with('customer')->whereIn('product_id',$vendor_products_ids)->orderBy('id','desc')->take(10)->get();

            $ratings_count['avgRatings']=$reviews->avg('rating');
            $ratings_count['totalRatings']=$reviews->count();
            $ratings_count['fiveRatings']=$reviews->where('rating',5)->avg('rating')? $reviews->where('rating',5)->avg('rating'):0;
            $ratings_count['fourRatings']=$reviews->whereBetween('rating',[4.0, 4.9])->avg('rating')?$reviews->whereBetween('rating',[4.0, 4.9])->avg('rating'):0;
            $ratings_count['threeRatings']=$reviews->whereBetween('rating',[3.0, 3.9])->avg('rating')?$reviews->whereBetween('rating',[3.0, 3.9])->avg('rating'):0;
            $ratings_count['twoRatings']=$reviews->whereBetween('rating',[2.0, 2.9])->avg('rating')?$reviews->whereBetween('rating',[2.0, 2.9])->avg('rating'):0;
            $ratings_count['oneRatings']=$reviews->whereBetween('rating',[1.0, 2.9])->avg('rating')?$reviews->whereBetween('rating',[1.0, 2.9])->avg('rating'):0;

            $reviews = ProductReviewsResource::collection($reviews);

            $data = ["vendor" => new VendorsResource($vendor),"reviews" => $reviews, "ratings_count"=>$ratings_count,"vendor_category"=> CategoriesResource::collection($vendor->categories)];
            $response = generateResponse($data, true, '', [], 'object');
            return response($response);
        }
        else
        {
            $response = generateResponse('', false,  trans('messages.response.web.vendor_store_not_found'), [], 'object');
            return response($response, 404);
        }
    }
}
