<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\Category;
use App\Http\Resources\Web\CategoriesResource;
use App\Models\CMSModels\Product;
use App\Http\Resources\Web\ProductsResource;
use App\Models\CMSModels\Brand;
use App\Http\Resources\Web\BrandsResource;
use App\Models\CMSModels\Attribute;
use App\Http\Resources\Web\ShopPageAttributesResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class ShopPageController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
    public function __construct()
    {
    }
    public function getter($req = null, $export = null)
    {
        $settings = Cache::get("general_settings");
        if ($settings['is_multi_vendor']  == 1){
            $products =  Product::withAll()->withDetailWeb()->where('is_active', 1)->where('available_date', '<=', Carbon::now()->toISOString())->where(function($q){
                $q->where(function($z){
                    $z->where('product_type', 2)->has('variants')->where('is_active', 1)->whereHas('vendor',function($q){
                        $q->where('is_active',1);
                        $q->whereHas('store',function($q){
                            $q->where('is_active',1);
                        });
                       });
            })
            ->orWhere('product_type', 1);
        })->where('is_active', 1)->whereHas('vendor',function($q){
                $q->where('is_active',1);
                $q->whereHas('store',function($q){
                    $q->where('is_active',1);
                });
            });
        }else{
            $products =  Product::withAll()->withDetailWeb()->where('is_active', 1)->where('available_date', '<=', Carbon::now()->toISOString())->where(function($q){
                $q->where(function($z){
                    $z->where('product_type', 2)->has('variants')->where('is_active', 1);
                })->orWhere('product_type', 1);

            })->where('is_active', 1);
        }

        if (count($req->all()) != 0) {

            if ($req->category && $req->category != null) {

                $products = $products->whereHas('categoriesWithOutAll', function ($q) use ($req) {
                    $q->where('categories.slug', $req->category);
                });
            }
            if (isset($req['brands']) && count($req['brands']) != 0) {

                $products = $products->whereHas('brand', function ($q) use ($req) {
                    $q->whereIn('brands.id', $req['brands']);
                });
            }
            if (isset($req['attributes']) && count($req['attributes']) != 0) {

                $attributes = $req['attributes'];
                foreach ($attributes as $key => $attribute) {
                    $attributes[$key] = json_decode($attribute);
                }
                $attribute_ids = collect($attributes)->pluck('attribute_id')->toArray();
                $value_slugs = collect($attributes)->pluck('slug')->toArray();
                $products = $products->where('product_type', 2)->whereHas('product_attribute_values', function ($q) use ($attribute_ids, $value_slugs) {
                    $q->whereIn('product_attribute_values.attribute_id', $attribute_ids);
                    $q->whereIn('product_attribute_values.slug', $value_slugs);
                });
            }
            $sort = json_decode($req->sort);
            if ($req->column && $req->column != null && $req->search && $req->search != null) {

                if ($req->column == 'name') {
                    $products = $products->whereLike($req->column . '->' . app()->getLocale(), $req->search);
                } else {
                    $products = $products->whereLike($req->column . '->' . app()->getLocale(), $req->search);
                }
            } else if ($req->search && $req->search != null) {

                $products = $products->whereLike(['name->' . app()->getLocale()], $req->search);
            }
            if ($sort != null && $sort->field != null && $sort->type != null) {
                $products = $products->OrderBy($sort->field, $sort->type);
            } else {
                $products = $products->OrderBy('id', 'desc');
            }
            if ($req->min_price && $req->min_price != null ||  $req->min_price === '0') {
                // $products =  Product::withAll()->withDetailWeb()->where('is_active', 1)->where('available_date', '<=', Carbon::now()->toISOString());

                $min_price = $req->min_price;
                $products = $products->where(function($q) use ($min_price){
                    $q->where(function($z) use ($min_price){
                        $z->where('product_type',2)->whereHas('variants', function ($x) use($min_price) {
                            $x->where('product_variants.price', '>=', $min_price);
                        });
                    })->orWhere(function($q) use ($min_price){
                        $q->where('product_type',1)->where('price','>=', $min_price);
                    });
                });
                // $products =  $products->where('price', '>=', $min_price);
            }
            if ($req->max_price && $req->max_price != null) {

                // $products =  Product::withAll()->withDetailWeb()->where('is_active', 1)->where('available_date', '<=', Carbon::now()->toISOString());
                $max_price = $req->max_price;
                $products = $products->where(function($q) use ($max_price){
                    $q->where(function($z) use ($max_price){
                        $z->where('product_type',2)->whereHas('variants', function ($x) use($max_price) {
                            $x->where('product_variants.price','<=', $max_price);
                        });
                    })->orWhere(function($q) use ($max_price){
                        $q->where('product_type',1)->where('price','<=', $max_price);
                    });
                });
                // $products =  $products->where('price', '<=', $max_price);
            }

            $products = $products->paginate(9);
            $products = ProductsResource::collection($products)->response()->getData(true);
            return $products;
        }
        $products = $products->orderBy('id', 'desc')->paginate(24);
        $products = ProductsResource::collection($products)->response()->getData(true);
        return $products;
    }
    // Categories
    public function allShopPageData(Request $request)
    {
        $brands_ids = [];
        $attribute_ids = [];
        $product_ids = [];
        if (count($request->all()) > 0) {
            $categories = Category::with('image')->with('icon')->where('is_active', 1)->where('parent_id', 0)->has('products')->with('childrens')->get();
            $categories = CategoriesResource::collection($categories);
            $selected_categories_products = Category::where('id',$request->category_id)->where('is_active', 1)->with('products')->get();
            $brands_ids = [];
            foreach ($selected_categories_products as $category) {
                foreach ($category->products as $product) {
                    array_push($brands_ids,$product->brand_id);
                }
            }
            $brands = Brand::withAll()
            ->whereIn('id',$brands_ids)
            ->where('is_active', 1)
            ->has('products')
            ->get();

        $brands = BrandsResource::collection($brands);
        foreach ($selected_categories_products as $category) {
            foreach ($category->products as $product) {
                // array_push($attribute_ids,$product->brand_id);
                // return response($product);
                array_push($product_ids,$product->id);
                if (count($product->attributes) > 0) {
                    foreach ($product->attributes as $att) {
                        array_push($attribute_ids,$att->id);
                    }
                }
            }
        }

        $attributes = Attribute::whereIn('id',$attribute_ids)->where('is_active', 1)->has('products')->with('values')->whereHas('values',function($q) use($product_ids)
        {
            $q->whereIn('product_id',$product_ids);
        })->get();
        // return response($attributes);

        $attributes = ShopPageAttributesResource::collection($attributes);
        $response = ['categories' => $categories, 'brands' => $brands, 'attributes' => $attributes];
        $response = generateResponse($response, count($categories) > 0 ? true : false, '', [], 'collection');
        return response($response);
        } else {
            $categories = Category::with('image')->with('icon')->where('is_active', 1)->has('products')->where('parent_id', 0)->with('childrens')->get();
            $categories = CategoriesResource::collection($categories);
            // $brands = Brand::withAll()
            //     ->where('is_active', 1)
            //     ->has('products')
            //     ->get();
            // $brands = BrandsResource::collection($brands);
            // $attributes = Attribute::where('is_active', 1)->has('products')->has('values')->with('values')->get();
            // // dd($attributes);
            // $attributes = ShopPageAttributesResource::collection($attributes);
            $response = ['categories' => $categories, 'brands' => [], 'attributes' => []];
            $response = generateResponse($response, count($categories) > 0 ? true : false, '', [], 'collection');
            return response($response);
        }
    }

    public function allShopPageFilterProducts(Request $request)
    {

        $products = $this->getter($request);
        $response = generateResponse($products, count($products['data']) > 0 ? true : false, '', [], 'collection');
        return response($response);
    }
}
