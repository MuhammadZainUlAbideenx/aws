<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\FaqsResource;
use Illuminate\Http\Request;
use App\Models\CMSModels\Category;
use App\Http\Resources\Web\ProductsByCategoriesResource;
use App\Models\CMSModels\Product;
use App\Http\Resources\Web\ProductsResource;
use App\Http\Resources\Web\ReviewsResource;
use App\Http\Resources\Web\SearchProductsResource;
use App\Models\CMSModels\OrderProduct;
use App\Models\CMSModels\Review;
use App\Models\CMSModels\SpecialSale;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class ApiProductsController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
    public function __construct()
    {
    }
    // Featured Products
    public function allFeaturedProductsCategoriesWise()
    {
        $featured_products = Category::withAll()
            ->with('products', function ($q) {

                $q->where('is_feature', 1)
                    ->where('available_date', '<=', Carbon::now()->toISOString())
                    ->where('is_active', 1)
                    ->orderBy('products.id','desc')
                    ->where(function ($q) {
                        $q->where('product_type', 2)->has('variants');
                    })->orWhere('product_type', 1)
                    ->with('reviews');
            })
            ->whereHas('products', function ($q) {
                $q->where('is_feature', 1)
                    ->whereDate('available_date', '<=', Carbon::now()->toISOString())
                    ->where('is_active', 1)
                    ->orderBy('products.id','desc');

            })
            ->where('parent_id', 0)
            ->where('is_active', 1)
            ->take(config('constants.featured_products_category_limit'))
            ->get()
            ->map(function ($category) {
                $category->products = $category->products->take(config('constants.featured_products_limit'));
                return $category;
            });

        $featured_products = ProductsByCategoriesResource::collection($featured_products);
        $response = generateResponse($featured_products, count($featured_products) > 0 ? true : false, '', [], 'collection');
        return response($response);
    }
    public function allFeaturedProducts()
    {
            $featured_products = Product::withAll()->withDetailWeb()
                                        ->where(function ($q) {
                                            $q->where('product_type', 2)->has('variants')->where('is_active', 1);
                                        })
                                        ->orWhere('product_type', 1)
                                        ->where('is_feature', 1)
                                        ->whereDate('available_date', '<=', Carbon::now()->toISOString())
                                        ->where('is_active', 1)
                                        ->orderBy('id','desc')
                                        ->get()
                                        ->take(10);
        $featured_products = ProductsResource::collection($featured_products);
        $response = generateResponse($featured_products, count($featured_products) > 0 ? true : false, '', [], 'collection');
        return response($response);
    }
    // Flash Sale Products
    public function allFlashSaleProducts()
    {
        $flash_sale_products = Product::withAll()->withDetailWeb()
            ->whereHas('flash_sale', function ($q) {
                $q->where('start_date', '<=', Carbon::now()->toISOString());
                $q->where('expire_date', '>=', Carbon::now()->toISOString());
                $q->where('is_active', 1);
            })
            ->where('available_date', '<=', Carbon::now()->toISOString())
            ->where('is_active', 1)
            ->take(config('constants.flash_sale_products_limit'))
            ->get();
        $flash_sale_products = ProductsResource::collection($flash_sale_products)->response()->getData(true);
        $response = generateResponse($flash_sale_products, count($flash_sale_products['data']) > 0 ? true : false, '', []);
        return response($response);
    }
    // New Arrival Products
    public function allNewArrivalProducts()
    {

        $new_arrival_products = Category::withAll()
            ->with('products', function ($q) {
                $q->where(function ($q) {
                    $q->where('product_type', 2)->has('variants')->where('is_active', 1);
                });
                $q->orWhere('product_type', 1);
                $q->orderBYDESC('available_date');
                $q->where('available_date', '<=', Carbon::now()->toISOString());
                $q->where('is_active', 1)

                    ->with('reviews')
                    ->with('attributes');
            })
            ->whereHas('products', function ($q) {
                $q->where('available_date', '<=', Carbon::now()->toISOString());
                $q->where('is_active', 1);
            })

            ->where('parent_id', 0)
            ->where('is_featured', 1)
            ->where('is_active', 1)
            ->orderBy('id', 'desc')
            ->get()
            ->take(2)
            ->map(function ($category) {
                $category->products = $category->products->take(config('constants.new_arrival_products_limit'));
                return $category;
            });
        $new_arrival_products = ProductsByCategoriesResource::collection($new_arrival_products);
        $response = generateResponse($new_arrival_products, count($new_arrival_products) > 0 ? true : false, '', [], 'collection');
        return response($response);
    }
    public function allLatestProducts()
    {

        $latest_products = Product::withAll()->withDetailWeb()->where('is_active', 1)->orderBYDESC('available_date')->where('available_date', '<=', Carbon::now()->toISOString())->limit(32)->get();
        $latest_products = ProductsResource::collection($latest_products);
        $response = generateResponse($latest_products, count($latest_products) > 0 ? true : false, '', [], 'collection');
        return response($response);
    }

    public function allCategoryWiseProducts()
    {

        $category_wise = Category::withAll()
            ->with('products', function ($q) {
                $q->orderBYDESC('available_date');
                $q->where('available_date', '<=', Carbon::now()->toISOString());
                $q->where('is_active', 1)

                    ->with('reviews');
            })
            ->whereHas('products', function ($q) {
                $q->where('available_date', '<=', Carbon::now()->toISOString());
                $q->where('is_active', 1);
            })
            ->where('parent_id', 0)
            ->where('is_featured', 1)
            ->get()
            ->map(function ($category) {
                $category->products = $category->products->take(config('constants.category_wise_products_limit'));
                return $category;
            });
        $category_wise = ProductsByCategoriesResource::collection($category_wise);
        $all_category_products = Product::withAll()->withDetailWeb()
            ->where('available_date', '<=', Carbon::now()->toISOString())
            ->where('is_active', 1)
            ->take(config('constants.category_wise_all_category_products_limit'))
            ->get();
        $all_category_products = ProductsResource::collection($all_category_products);

        $data = ['other_cats' => $category_wise, 'all_categories' => $all_category_products];
        $response = generateResponse($data, count($category_wise) + count($all_category_products) > 0 ? true : false, '', [], 'collection');
        return response($response);
    }
    // Top Selling Products
    public function allTopSellingProducts()
    {

        $top_selling_products = Product::withAll()->withDetailWeb()
            ->where('available_date', '<=', Carbon::now()->toISOString())
            ->where('is_active', 1)
            ->orderBy('product_ordered', 'DESC')
            ->take(config('constants.top_selling_products_limit'))
            ->get();
        $top_selling_products = ProductsResource::collection($top_selling_products)->response()->getData(true);
        $response = generateResponse($top_selling_products, count($top_selling_products['data']) > 0 ? true : false, '', []);
        return response($response);
    }

    // Trending Products
    public function allTrendingProducts()
    {

        // $products = Product::withAll()->withDetailWeb()
        //     ->where('available_date', '<=', Carbon::now()->toISOString())
        //     ->where('is_active', 1)
        //     // ->orderBy('product_ordered', 'DESC')
        //     ->orderBy('id', 'DESC')
        //     ->take(config('constants.products_limit'))
        //     ->get();
        // $products =  ProductsResource::collection($products);
        // $newset_products = $products->where('available_date',  '>', Carbon::now()->subDays(20)->toISOString())->take(9);
        // $featured_products = $products->where('is_feature', 1)->take(9);
        // $sale_products_id = SpecialSale::where('expire_date', '>=', Carbon::now()->toISOString())->where('is_active', 1)->pluck('product_id')->toArray();
        // $on_sale_products = $products->whereIn('id', $sale_products_id)->take(9);
        // $product_ids = $products->pluck('id')->toArray();
        // $best_sellers_products_ids = OrderProduct::whereIn('product_id', $product_ids)->pluck('product_id')->toArray();
        // $best_sellers_products = $products->whereIn('id', $best_sellers_products_ids)->take(9);
        // $data['trending_products'] =  $products->take(9);
        // $data['newset_products'] = $newset_products;
        // $data['on_sale_products'] = $on_sale_products;
        // $data['featured_products'] = $featured_products;
        // $data['featured_products'] = $featured_products;
        // $data['best_sellers_products'] = $best_sellers_products;
        // $data['success'] = true;
        // $data['errors'] = [];
        // $data['message'] = "";
        // // $response = generateResponse($data, true, '', []);
        // return response($data);
// continue
        $products = Product::withAll()->withDetailWeb()
            ->where('available_date', '<=', Carbon::now()->toISOString())
            ->where('is_active', 1)
            // ->orderBy('product_ordered', 'DESC')
            ->orderBy('id', 'DESC')
            // ->take(config('constants.products_limit'))
            ->get();
        $products =  ProductsResource::collection($products);
        $sale_products_id = SpecialSale::where('expire_date', '>=', Carbon::now()->toISOString())->where('is_active', 1)->pluck('product_id')->toArray();
        $on_sale_products = $products->whereIn('id', $sale_products_id)->take(9);
        // return response($sale_products_id);
        $product_ids = $products->pluck('id')->toArray();
        $best_sellers_products_ids = OrderProduct::whereIn('product_id', $product_ids)->pluck('product_id')->toArray();

        $best_sellers_products = $products->whereIn('id', $best_sellers_products_ids)->take(9);
        $top_rated_products_review = Review::whereIn('product_id', $product_ids)->get()->groupBy('product_id');
        $product_avg_array = array();
        foreach ($top_rated_products_review as $key => $top_rated_product) {
            $product_avg_array[$top_rated_product[0]->product_id]['reviews_avg'] = $top_rated_product->avg('rating');
        }
        arsort($product_avg_array);
        $top_rated_product_ids = array();
        foreach ($product_avg_array as $key => $array) {
            array_push($top_rated_product_ids,$key);
        }
        $sale_products_id_limit = array_slice($sale_products_id, 0, 3);
        $best_sellers_products_ids_limit = array_slice($best_sellers_products_ids, 0, 3);
        $top_rated_product_ids_limit = array_slice($top_rated_product_ids, 0, 3);
        $all_products_array_ids =  array_merge($sale_products_id_limit,$best_sellers_products_ids_limit,$top_rated_product_ids_limit);


        $top_rated_products = $products->whereIn('id',$top_rated_product_ids)->take(9);
        $trending_products = $products->whereIn('id',$all_products_array_ids)->take(9);
        $data['trending_products'] =  $trending_products;
        $data['on_sale_products'] = $on_sale_products;
        $data['best_sellers_products'] = $best_sellers_products;
        $data['top_rated_products'] = $top_rated_products;
        $data['success'] = true;
        $data['errors'] = [];
        $data['message'] = "";
        return response($data);
    }

    public function allTrendingProductsMobile()
    {

        $trending_products = Product::withAll()->withDetailWeb()
            ->where('available_date', '<=', Carbon::now()->toISOString())
            ->where('is_active', 1)
            ->orderBy('product_ordered', 'DESC')
            ->take(config('constants.trending_products_limit'))
            ->get();
        $trending_products = ProductsResource::collection($trending_products)->response()->getData(true);
        $response = generateResponse($trending_products, count($trending_products['data']) > 0 ? true : false, '', []);
        return response($response);
    }


    // Top Selling Products
    public function allTopReviewedProducts()
    {

        $top_reviewed_products = Product::withAll()->withDetailWeb()
            ->where('available_date', '<=', Carbon::now()->toISOString())
            ->where('is_active', 1)
            ->get()
            ->sortBy(function ($product) {
                return $product->total_reviews;
            })
            ->take(config('constants.top_reviewed_products_limit'));
        $top_reviewed_products = ProductsResource::collection($top_reviewed_products)->response()->getData(true);
        $response = generateResponse($top_reviewed_products, count($top_reviewed_products['data']) > 0 ? true : false, '', []);
        return response($response);
    }

    // Upcoming Products
    public function allUpcomingProducts()
    {

        $upcoming_products = Product::withAll()->withDetailWeb()
            // ->where('available_date', '>=', Carbon::now()->toISOString())
            // ->where('is_active', 1)
            ->where(function ($q) {
                $q->where('product_type', 2)->has('variants')->where('available_date', '>=', Carbon::now()->toISOString())
                    ->where('is_active', 1);
            })
            ->orWhere(function ($q) {
                $q->where('product_type', 1)->where('available_date', '>=', Carbon::now()->toISOString())
                    ->where('is_active', 1);
            })
            ->take(config('constants.upcoming_products_limit'))->orderBy('id', 'DESC')
            ->get();
        $upcoming_products = ProductsResource::collection($upcoming_products)->response()->getData(true);
        $response = generateResponse($upcoming_products, count($upcoming_products['data']) > 0 ? true : false, '', []);
        return response($response);
    }
    // Get Single Product Detail
    public function productDetail($slug)
    {

        $product = Product::withAll()->withDetailWeb()->with('vendor.products', function ($q) {
            $q->where('is_active', 1);
            $q->take(3);
        })->where('slug', $slug)->where('is_active', 1)->first();
        if ($product) {
            $related_products = $product->related_products;
            $category_ids = $product->category_ids;
            $featured_products = Product::withAll()->withDetailWeb()->whereHas('categories', function ($q) use ($category_ids) {
                $q->whereIn('categories.id', $category_ids);
            })->where('is_feature', 1)
                ->where('is_active', 1)
                ->where('available_date', '<=', Carbon::now()->toISOString())
                ->take(2)
                ->get();

            $featured_products = ProductsResource::collection($featured_products);
            $related_products = ProductsResource::collection($related_products);
            $reviews = $product->reviews()->get();
            if (count($reviews) > 0) {
                $reviews_average_rating = round($reviews->sum('rating') / $reviews->count());
                $product['reviews_average_rating'] = $reviews_average_rating;
            } else {
                $product['reviews_average_rating'] = 0;
            }

            $product = new ProductsResource($product);
            $data = ['product' => $product, 'related_products' => $related_products, 'featured_products' => $featured_products];
            $response = generateResponse($data, true, '', [], 'object');
            return response($response);
        } else {
            $response = generateResponse('', false, trans('messages.response.web.product_not_found'), [], 'object');
            return response($response, 404);
        }
    }
    // Get All Products by category id
    public function allProductsByCategoryId($category)
    {
        $category = Category::where('id', $category)->where('is_active', 1)->first();
        if ($category) {
            $products = $category->products()->where('is_active', 1)
                ->where('available_date', '<=', Carbon::now()->toISOString())
                ->paginate(config('constants.category_products_pagination_limit'));
            $products = ProductsResource::collection($products)->response()->getData(true);
            $response = generateResponse($products, count($products['data']) > 0 ? true : false, '', []);
        } else {
            $response = generateResponse('', false, trans('messages.response.web.category_not_found'), [], 'object');
        }
        return response($response);
    }

    public function compareProducts(Request $request)
    {
        if ($request->compare_ids != null) {
            $compare_products = Product::withAll()->withDetailWeb()->whereIn('id', $request->compare_ids)->where('is_active', 1)
                ->where('available_date', '<=', Carbon::now()->toISOString())
                ->get();
            if ($compare_products) {
                $products = ProductsResource::collection($compare_products);
                $product_categories = Category::whereHas('products', function ($q) use ($request) {
                    $q->whereIn('products.id', $request->compare_ids);
                })->where('is_active', 1)->pluck('id')->toArray();
                $related_products = Product::withAll()->withDetailWeb()->whereHas('categories', function ($q) use ($product_categories) {
                    $q->whereIn('categories.id', $product_categories);
                })->where('is_active', 1)
                    ->where('available_date', '<=', Carbon::now()->toISOString())
                    ->take(5)->get();
                $related_products = ProductsResource::collection($related_products);
                $product_detail = ['products' => $products, 'related_products' => $related_products];
                $response = generateResponse($product_detail, count($product_detail) > 0 ? true : false, '', [], 'collection');
            } else {
                $response = generateResponse(null, false, trans('messages.response.web.no_product_select_comparison'), [], 'object');
            }
        } else {
            $response = generateResponse(null, false, trans('messages.response.web.no_product_select_comparison'), [], 'object');
        }
        return $response;
    }
    public function productFaq($slug)
    {

        $product = Product::withAll()->withDetailWeb()->where('slug', $slug)->where('is_active', 1)
            ->where('available_date', '<=', Carbon::now()->toISOString())
            ->first();
        $faqs = $product->faqs;
        $faqs = FaqsResource::collection($faqs);
        $response = generateResponse($faqs, true, '', [], 'object');
        return response($response);
    }
    public function productReview($slug)
    {

        $product = Product::withAll()->withDetailWeb()->where('slug', $slug)->where('is_active', 1)
            ->where('available_date', '<=', Carbon::now()->toISOString())
            ->first();
        $reviews = $product->reviews;
        $reviews = ReviewsResource::collection($reviews);
        $response = generateResponse($reviews, true, '', [], 'object');
        return response($response);
    }

    public function searchProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'search' => 'required',
        ]);
        if ($validator->fails()) {
            $response = generateResponse('', false, '', $validator->errors(), 'object');
            return $response;
        }
        $products = Product::withAll()->WithDetailWeb();
        $settings = Cache::get("general_settings");
        $is_multivendor = (int)$settings['is_multi_vendor'];
        if ($is_multivendor) {
            $products = $products->whereHas('vendor.store', function ($q) {
                $q->where('is_active',1);
            })->whereHas('vendor', function ($q) {
                $q->where('is_active',1);
            })->where('is_active', 1)->where('name', 'like', '%' . $request->search . '%')->orderByRaw('name like ? desc', $request->search)->orderByRaw('instr(name,?) asc', $request->search)->orderBy('name')->get();
        }
        else
        {
            $products = $products->where('is_active', 1)->where('name', 'like', '%' . $request->search . '%')->orderByRaw('name like ? desc', $request->search)->orderByRaw('instr(name,?) asc', $request->search)->orderBy('name')->get();
        }

        $products = SearchProductsResource::collection($products);
        $response = generateResponse($products, true, '', [], 'object');
        return response($response);
    }
    public function searchProductByCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category_id' => 'required'
        ]);
        if ($validator->fails()) {
            $response = generateResponse('', false, '', $validator->errors(), 'object');
            return $response;
        }
        $products = Product::withAll()->withDetailWeb();
        $products = $products->whereLike('name' . '->' . app()->getLocale(), $request->name)
            ->whereHas('categories', function ($q) use ($request) {
                $q->where('category_id', $request->category_id);
            })->get();
        $response = generateResponse($products, true, '', [], 'object');
        return response($response);
    }
}
