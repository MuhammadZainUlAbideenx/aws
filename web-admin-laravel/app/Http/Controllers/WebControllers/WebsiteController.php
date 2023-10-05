<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use App\Models\CMSModels\SliderImage;
use App\Http\Resources\Web\SliderImagesResource;
use App\Models\CMSModels\StaticBanner;
use App\Http\Resources\Web\StaticBannersResource;
use App\Models\CMSModels\ParallaxBanner;
use App\Http\Resources\Web\ParallaxBannersResource;
use App\Models\CMSModels\ContentPage;
use App\Http\Resources\Web\ProductsResource;
use App\Http\Resources\Web\ContentPagesResource;
use App\Http\Resources\Web\ContentPageDetailResource;
use App\Models\CMSModels\Category;
use App\Http\Resources\Web\CategoriesResource;
use App\Http\Controllers\WebControllers\ApiNewsesController;
use App\Http\Controllers\WebControllers\ApiReviewsController;
use App\Http\Controllers\WebControllers\ApiBrandsController;
use App\Http\Resources\CMS\ParentCategoryResource;
use App\Models\CMSModels\Setting;

class WebsiteController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
    public function __construct()
    {
    }
    public function index()
    {
    }
    public function allGenericData()
    {
        $slider_images = SliderImage::whereDate('expiry_date', '>=', now())->where('is_active', 1)->get();
        $slider_images = SliderImagesResource::collection($slider_images);

        $static_banners = StaticBanner::whereDate('expiry_date', '>=', now())->where('is_active', 1)->get();
        $static_banners = StaticBannersResource::collection($static_banners)->groupBy('type');

        $parallax_banners = ParallaxBanner::whereDate('expiry_date', '>=', now())->where('is_active', 1)->get();
        $parallax_banners = ParallaxBannersResource::collection($parallax_banners);

        $parent_categories = Category::with('image')->with('icon')->where('parent_id', 0)->where('is_active', 1)->get();
        $parent_categories = ParentCategoryResource::collection($parent_categories);

        $featured_blog_post = ApiNewsesController::allFeaturedPosts();
        $reviews = ApiReviewsController::allReviews();
        $brands = ApiBrandsController::featuredBrands();

        $arr = [
            'parent_categories' => $parent_categories,
            'slider_images' => $slider_images,
            'static_banners' => $static_banners,
            'parallax_banners' => $parallax_banners,
            'featured_blog_post' => $featured_blog_post,
            'reviews' => $reviews,
            'brands' => $brands,
        ];
        $response = generateResponse($arr, true, '', [], 'collection');
        return response($response);
    }

    // content pages
    public function fetchFooterData()
    {
        $content_pages = ContentPage::where('is_active', 1)->get();
        $content_pages = ContentPagesResource::collection($content_pages);
        $categories = Category::with('image')->with('icon')->where('is_active', 1)->has('products')->where('parent_id', 0)->take(5)->get();
        $categories = CategoriesResource::collection($categories);
        $dynamicContact = ['contact_address', 'contact_email', 'contact_number'];
        $contactDetails = Setting::whereIn('name', $dynamicContact)->select('name', 'value')->pluck('value', 'name')->toArray();
        $arr = ['categories' => $categories, 'content_pages' => $content_pages, 'contactDetails' => $contactDetails];
        $response = generateResponse($arr, true, '', [], 'collection');
        return response($response);
    }

    public function megaMenuItems()
    {
        $categories_1 = Category::where('is_active', 1)->where('parent_id', 0)->take(16)->get();
        $categories_1 = CategoriesResource::collection($categories_1);
        $categories_2 = Category::where('is_active', 1)->where('parent_id', 0)->skip(16)->take(16)->get();
        $categories_2 = CategoriesResource::collection($categories_2);
        $category = Category::where('is_active', 1)->where('is_featured', 1)->where('parent_id', 0)->first();
        $featured_product_by_category = $category->products()->where('is_feature', 1)->take(2)->get();
        $featured_products = ProductsResource::collection($featured_product_by_category);
        $arr = ['categories_1' => $categories_1, 'categories_2' => $categories_2, 'featured_items' => $featured_products];
        $response = generateResponse($arr, true, '', [], 'collection');
        return response($response);
    }
    public function websiteContentPageDetail($slug)
    {
        $content_page = ContentPage::where('is_active', 1)->where('slug', $slug)->first();
        if ($content_page) {
            $content_page = new ContentPageDetailResource($content_page);
            $response = generateResponse($content_page, true, '', [], 'object');
            return response($response);
        } else {
            abort(404);
        }
    }
}
