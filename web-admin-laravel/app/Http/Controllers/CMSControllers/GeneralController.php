<?php

namespace App\Http\Controllers\CMSControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\Category;
use App\Http\Resources\CMS\CategoriesResource;
use App\Http\Resources\CMS\ActiveCategoriesResource;
use App\Http\Resources\CMS\ActiveParentCategoriesResource;
use App\Models\CMSModels\Language;
use App\Http\Resources\CMS\LanguagesResource;
use App\Models\Role;
use App\Http\Resources\CMS\RolesResource;
use App\Models\CMSModels\Manufacturer;
use App\Http\Resources\CMS\ManufacturersResource;
use App\Models\CMSModels\Unit;
use App\Http\Resources\CMS\UnitsResource;
use App\Models\CMSModels\TaxClass;
use App\Http\Resources\CMS\TaxClassesResource;
use App\Models\CMSModels\OrderStatus;
use App\Http\Resources\CMS\OrderStatusesResource;
use App\Models\CMSModels\MediaDetail;
use App\Http\Resources\CMS\ThumbnailResource;
use App\Models\Vendor;
use App\Http\Resources\CMS\VendorsResource;
use App\Http\Resources\CMS\VendorCategoryResource;
use App\Models\Permission;
use App\Http\Resources\CMS\PermissionsResource;
use App\Models\CMSModels\Currency;
use App\Http\Resources\CMS\CurrenciesResource;
use App\Models\CMSModels\SliderImage;
use App\Http\Resources\CMS\SliderImagesResource;
use App\Models\CMSModels\StaticBanner;
use App\Http\Resources\CMS\StaticBannersResource;
use App\Models\CMSModels\ParallaxBanner;
use App\Http\Resources\CMS\ParallaxBannersResource;
use App\Models\CMSModels\Country;
use App\Http\Resources\CMS\CountriesResource;
use App\Models\CMSModels\City;
use App\Http\Resources\CMS\CitiesResource;
use App\Models\CMSModels\Zone;
use App\Http\Resources\CMS\ZonesResource;
use App\Models\CMSModels\State;
use App\Http\Resources\CMS\StatesResource;
use App\Models\CMSModels\TaxRate;
use App\Http\Resources\CMS\TaxRatesResource;
use App\Models\CMSModels\Product;
use App\Http\Resources\CMS\ProductsResource;
use App\Models\CMSModels\Coupon;
use App\Http\Resources\CMS\CouponsResource;
use App\Models\CMSModels\Customer;
use App\Http\Resources\CMS\CustomersResource;
use App\Models\CMSModels\Admin;
use App\Http\Resources\CMS\AdminsResource;
use App\Models\CMSModels\News;
use App\Http\Resources\CMS\NewsesResource;
use App\Models\CMSModels\Review;
use App\Http\Resources\CMS\ReviewsResource;
use App\Models\CMSModels\ContentPage;
use App\Models\CMSModels\CurrencyCode;
use App\Models\CMSModels\LanguageCode;
use App\Models\CMSModels\NewsCategory;
use App\Models\CMSModels\ReviewStatus;
use App\Http\Resources\CMS\ReviewStatusesResource;
use App\Models\CMSModels\ApplicationBanner;
use App\Http\Resources\CMS\ApplicationBannersResource;
use App\Models\CMSModels\ApplicationParallaxBanner;
use App\Http\Resources\CMS\ApplicationParallaxBannersResource;
use App\Models\CMSModels\ApplicationSliderImage;
use App\Http\Resources\CMS\ApplicationSliderImagesResource;
use App\Models\CMSModels\ContentApplicationPage;
use App\Http\Resources\CMS\ContentApplicationPagesResource;
use App\Models\CMSModels\SeoPage;
use App\Http\Resources\CMS\SeoPagesResource;
use App\Models\CMSModels\Brand;
use App\Http\Resources\CMS\BrandsResource;
use App\Models\CMSModels\ShippingMethod;
use App\Http\Resources\CMS\ShippingMethodsResource;
use App\Models\CMSModels\Attribute;
use App\Models\CMSModels\AttributeValue;
use App\Http\Resources\CMS\AttributesResource;
use App\Http\Resources\CMS\AttributeValuesResource;
use App\Models\CMSModels\PaymentMethod;
use App\Http\Resources\CMS\PaymentMethodsResource;
use App\Http\Requests\Mobile\StatesByCountry\CreateRequest as StatesByCountryCreateRequest;
use App\Http\Requests\Mobile\CityByState\CreateRequest as CityByStateCreateRequest;

class GeneralController extends Controller
{
    public $guard;
    /********* Initialize Permission based Middlewares  ***********/
    public function __construct()
    {
        if (auth('customer-api')->check() && auth('customer-api')->user()->tokenCan('customer')) {
            $this->guard = 'customer-api';
        } elseif (auth('rider-api')->check() && auth('rider-api')->user()->tokenCan('rider')) {
            $this->guard = 'rider-api';
        } elseif (auth('vendor-api')->check() && auth('vendor-api')->user()->tokenCan('vendor')) {
            $this->guard = 'vendor-api';
        } elseif (auth('admin-api')->check() && auth('admin-api')->user()->tokenCan('admin')) {
            $this->guard = 'admin-api';
        } else {
        }
        // $this->middleware('auth:api',['except' =>['activeLanguages'] ]);
    }
    /********* FETCH ALL Active Languages ***********/
    public function activeLanguages()
    {
        $languages = Language::where('is_active', 1)->OrderBY('is_default', 'DESC')->get();
        $languages = LanguagesResource::collection($languages);
        $languages = array('languages' => $languages, 'fetched' => true);
        $arrayName = array('languages' => $languages);
        return response($arrayName);
    }
    public function activeRoles()
    {
        $roles = Role::where('is_active', 1)
            ->where('name', '!=', 'super_admin')
            ->where('name', '!=', 'customer')
            ->where('name', '!=', 'vendor')
            ->get();
        $roles = RolesResource::collection($roles);
        $roles = array('roles' => $roles, 'fetched' => true);
        $arrayName = array('roles' => $roles);
        return response($arrayName);
    }

    public function activeCategories()
    {
        $categories = Category::where('is_active', 1)->where('parent_id', 0)->get();
        $categories = ActiveCategoriesResource::collection($categories);
        $categories = array('categories' => $categories, 'fetched' => true);
        $arrayName = array('categories' => $categories);
        return response($arrayName);
    }
    public function activeParentChildCategories(Request $request)
    {
        $categories = Category::where('is_active', 1);
        if ($request->search) {
            $categories = $categories->whereLike('name->' . app()->getLocale(), $request->search);
        }
        $categories = $categories->paginate(10);
        $categories = ActiveCategoriesResource::collection($categories)->response()->getData(true);
        $categories = array('categories' => $categories, 'fetched' => true);
        $arrayName = array('categories' => $categories);
        return response($arrayName);
    }
    public function activeParentCategories()
    {

        $categories = Category::where('is_active', 1)->where('parent_id', 0)->get();
        $categories = ActiveParentCategoriesResource::collection($categories);
        $categories = array('categories' => $categories, 'fetched' => true);
        $arrayName = array('categories' => $categories);
        return response($arrayName);
    }

    public function activeSelectCategories(Request $request)
    {
        $categories = Category::where('is_active', 1)->where('parent_id', 0);
        if ($request->search) {
            $categories = $categories->whereLike('name->' . app()->getLocale(), $request->search);
        }
        $categories = $categories->paginate(10);
        $categories = ActiveCategoriesResource::collection($categories)->response()->getData(true);
        $categories = array('categories' => $categories, 'fetched' => true);
        $arrayName = array('categories' => $categories);
        return response($arrayName);
    }

    public function vendorCategories( $id)
    {
        $vendor = Vendor::where('id',$id)->with('categories', function($q)
        {
            $q->with('childrens');
        })->get();
        return  VendorCategoryResource::collection($vendor);
    }

    public function activeVendors(Request $request)
    {
        $vendors = Vendor::where('is_active', 1)->where('id', '!=', 1);
        if ($request->search) {
            $vendors = $vendors->whereLike('name', $request->search);
        }
        $vendors = $vendors->paginate(10);
        $vendors = VendorsResource::collection($vendors)->response()->getData(true);
        $vendors = array('vendors' => $vendors, 'fetched' => true);
        $arrayName = array('vendors' => $vendors);
        return response($arrayName);
    }
    public function activeInactiveCategories(Request $request)
    {
        $categories = new Category;
        if ($request->search) {
            $categories = $categories->whereLike('name->' . app()->getLocale(), $request->search);
        }
        $categories = $categories->paginate(10);
        $categories = CategoriesResource::collection($categories)->response()->getData(true);
        $categories = array('categories' => $categories, 'fetched' => true);
        $arrayName = array('categories' => $categories);
        return response($arrayName);
    }
    public function activeManufacturers(Request $request)
    {
        $manufacturers = Manufacturer::where('is_active', 1);
        if ($request->search) {
            $manufacturers = $manufacturers->whereLike('name->' . app()->getLocale(), $request->search);
        }
        $manufacturers = $manufacturers->paginate(10);
        $manufacturers = ManufacturersResource::collection($manufacturers)->response()->getData(true);
        $manufacturers = array('manufacturers' => $manufacturers, 'fetched' => true);
        $arrayName = array('manufacturers' => $manufacturers);
        return response($arrayName);
    }
    public function activeUnits(Request $request)
    {
        $units = Unit::where('is_active', 1);
        if ($request->search) {
            $units = $units->whereLike('name->' . app()->getLocale(), $request->search);
        }
        $units = $units->paginate(10);
        $units = UnitsResource::collection($units)->response()->getData(true);
        $units = array('units' => $units, 'fetched' => true);
        $arrayName = array('units' => $units);
        return response($arrayName);
    }
    public function activeTaxClasses(Request $request)
    {
        $tax_classes = TaxClass::where('is_active', 1);
        if ($request->search) {
            $tax_classes = $tax_classes->whereLike('name->' . app()->getLocale(), $request->search);
        }
        $tax_classes =  $tax_classes->paginate(10);
        $tax_classes = TaxClassesResource::collection($tax_classes)->response()->getData(true);
        $tax_classes = array('tax_classes' => $tax_classes, 'fetched' => true);
        $arrayName = array('tax_classes' => $tax_classes);
        return response($arrayName);
    }
    public function activeOrderStatuses(Request $request)
    {
        $order_statuses = OrderStatus::where('is_active', 1);
        if ($request->search) {
            $order_statuses = $order_statuses->whereLike('name->' . app()->getLocale(), $request->search);
        }
        $order_statuses =  $order_statuses->paginate(10);
        $order_statuses = OrderStatusesResource::collection($order_statuses)->response()->getData(true);
        $order_statuses = array('order_statuses' => $order_statuses, 'fetched' => true);
        $arrayName = array('order_statuses' => $order_statuses);
        return response($arrayName);
    }
    public function activeMedia()
    {
        $user = auth($this->guard)->user();
        $user_type = $user->role->name;
        $user_id = $user->id;
        $images = MediaDetail::where('thumbnail_type', 'small')->whereHas('media', function ($q) use($user_type,$user_id) {
            $q->where('media.type', 'image');
            $q->where('media.user_type', $user_type);
            $q->where('media.user_id', $user_id);
        })->orderBy('id', 'desc')->get();
        $videos = MediaDetail::where('thumbnail_type', 'small')->whereHas('media', function ($q) use($user_type,$user_id) {
            $q->where('media.type', 'video');
            $q->where('media.user_type', $user_type);
            $q->where('media.user_id', $user_id);
        })->orderBy('id', 'desc')->get();
        $all = MediaDetail::where('thumbnail_type', 'small')->orderBy('id', 'desc')->get();
        $media = ['all' => ThumbnailResource::collection($all), 'images' => ThumbnailResource::collection($images), 'videos' => ThumbnailResource::collection($videos)];

        $media = array('media' => $media, 'fetched' => true);
        $arrayName = array('media' => $media);
        return response($arrayName);
    }
    public function activePermissions()
    {
        $permissions = Permission::all();
        $permissions = PermissionsResource::collection($permissions);
        $permissions = array('permissions' => $permissions, 'fetched' => true);
        $arrayName = array('permissions' => $permissions);
        return response($arrayName);
    }
    public function activeCurrencies(Request $request)
    {
        $currencies = Currency::where('is_active', 1);
        if ($request->search) {
            $currencies = $currencies->whereLike('name', $request->search);
        }
        $currencies = $currencies->paginate(10);
        $currencies = CurrenciesResource::collection($currencies)->response()->getData(true);
        $currencies = array('currencies' => $currencies, 'fetched' => true);
        $arrayName = array('currencies' => $currencies);
        return response($arrayName);
    }
    public function activeSliderImages(Request $request)
    {
        $slider_images = SliderImage::where('is_active', 1);
        if ($request->search) {
            $slider_images = $slider_images->whereLike('name->' . app()->getLocale(), $request->search);
        }
        $slider_images = $slider_images->paginate(10);
        $slider_images = SliderImagesResource::collection($slider_images)->response()->getData(true);
        $slider_images = array('slider_images' => $slider_images, 'fetched' => true);
        $arrayName = array('slider_images' => $slider_images);
        return response($arrayName);
    }
    public function activeStaticBanners(Request $request)
    {
        $static_banners = StaticBanner::where('is_active', 1);
        if ($request->search) {
            $static_banners = $static_banners->whereLike('name->' . app()->getLocale(), $request->search);
        }
        $static_banners = $static_banners->paginate(10);
        $static_banners = StaticBannersResource::collection($static_banners)->response()->getData(true);
        $static_banners = array('static_banners' => $static_banners, 'fetched' => true);
        $arrayName = array('static_banners' => $static_banners);
        return response($arrayName);
    }
    public function activeParallaxBanners(Request $request)
    {
        $parallax_banners = ParallaxBanner::where('is_active', 1);
        if ($request->search) {
            $parallax_banners = $parallax_banners->whereLike('name->' . app()->getLocale(), $request->search);
        }
        $parallax_banners = $parallax_banners->paginate(10);
        $parallax_banners = ParallaxBannersResource::collection($parallax_banners)->response()->getData(true);
        $parallax_banners = array('parallax_banners' => $parallax_banners, 'fetched' => true);
        $arrayName = array('parallax_banners' => $parallax_banners);
        return response($arrayName);
    }
    public function activeStates(Request $request)
    {
        $states = State::where('is_active', 1);
        if ($request->search) {
            $states = $states->whereLike('name', $request->search);
        }
        $states = $states->paginate(10);
        $states = StatesResource::collection($states)->response()->getData(true);
        $states = array('states' => $states, 'fetched' => true);
        $arrayName = array('states' => $states);
        return response($arrayName);
    }
    public function activeZones(Request $request)
    {
        $zones = Zone::where('is_active', 1);
        if ($request->search) {
            $zones = $zones->whereLike('name', $request->search);
        }
        $zones = $zones->paginate(10);
        $zones = ZonesResource::collection($zones)->response()->getData(true);
        $zones = array('zones' => $zones, 'fetched' => true);
        $arrayName = array('zones' => $zones);
        return response($arrayName);
    }
    public function activeCities(Request $request)
    {
        $cities = City::where('is_active', 1);
        if ($request->search) {
            $cities = $cities->whereLike('name', $request->search);
        }
        $cities = $cities->paginate(10);
        $cities = CitiesResource::collection($cities)->response()->getData(true);
        $cities = array('cities' => $cities, 'fetched' => true);
        $arrayName = array('cities' => $cities);
        return response($arrayName);
    }
    public function activeCountries(Request $request)
    {
        $countries = Country::where('is_active', 1);
        if ($request->search) {
            $countries = $countries->whereLike('name', $request->search);
        }
        $countries = $countries->paginate(10);
        $countries = CountriesResource::collection($countries)->response()->getData(true);
        $countries = array('countries' => $countries, 'fetched' => true);
        $arrayName = array('countries' => $countries);
        return response($arrayName);
    }
    public function getActiveCountryById($country_id)
    {
        $country = Country::where('is_active', 1)->where('id',$country_id)->first();
        $country = new CountriesResource($country);
        return response($country);
    }
    public function activeCountriesForMobile(Request $request)
    {
        $countries = Country::where('is_active', 1)->get();
        if ($request->search) {
            $countries = $countries->whereLike('name', $request->search);
        }
        $countries = CountriesResource::collection($countries);
        $countries = generateResponse($countries, true, '', [], 'object');
        return response($countries);
    }
    public function activeTaxRates(Request $request)
    {
        $tax_rates = TaxRate::where('is_active', 1);
        if ($request->search) {
            $tax_rates = $tax_rates->whereLike('rate', $request->search);
        }
        $tax_rates = $tax_rates->paginate(10);
        $tax_rates = TaxRatesResource::collection($tax_rates)->response()->getData(true);
        $tax_rates = array('tax_rates' => $tax_rates, 'fetched' => true);
        $arrayName = array('tax_rates' => $tax_rates);
        return response($arrayName);
    }
    public function activeProducts(Request $request)

    { $user = auth($this->guard)->user();
        if ($this->guard == 'admin-api') {
            $products = Product::withAll()->where('is_active', 1);
        }
        else if($this->guard == 'vendor-api')
        {
            $products = Product::withAll()->where('vendor_id',$user->id)->where('is_active', 1);
        }
        else
        {

        }
        if ($request->search) {
            $products = $products->whereLike('name->' . app()->getLocale(), $request->search);
        }
        $products = $products->paginate(10);
        $products = ProductsResource::collection($products)->response()->getData(true);
        $products = array('products' => $products, 'fetched' => true);
        $arrayName = array('products' => $products);
        return response($arrayName);
    }
    public function activeCoupons(Request $request)
    {
        $coupons = Coupon::where('is_active', 1);
        if ($request->search) {
            $coupons = $coupons->whereLike('code', $request->search);
        }
        $coupons = $coupons->paginate(10);
        $coupons = CouponsResource::collection($coupons)->response()->getData(true);
        $coupons = array('coupons' => $coupons, 'fetched' => true);
        $arrayName = array('coupons' => $coupons);
        return response($arrayName);
    }
    public function activeCustomers(Request $request)
    {
        $customers = Customer::where('is_active', 1);
        if ($request->search) {
            $customers = $customers->whereLike(['first_name', 'last_name','email'], $request->search);
        }
        $customers = $customers->paginate(10);
        $customers = CustomersResource::collection($customers)->response()->getData(true);
        $customers = array('customers' => $customers, 'fetched' => true);
        $arrayName = array('customers' => $customers);
        return response($arrayName);
    }
    public function activeAdmins(Request $request)
    {
        $admins = Admin::where('is_active', 1);
        if ($request->search) {
            $admins = $admins->whereLike(['first_name', 'last_name'], $request->search);
        }
        $admins = $admins->paginate(10);
        $admins = AdminsResource::collection($admins)->response()->getData(true);
        $admins = array('customers' => $admins, 'fetched' => true);
        $arrayName = array('customers' => $admins);
        return response($arrayName);
    }
    public function activeNewses(Request $request)
    {
        $newses = News::where('is_active', 1);
        if ($request->search) {
            $newses = $newses->whereLike('name->' . app()->getLocale(), $request->search);
        }
        $newses = $newses->paginate(10);
        $newses = NewsesResource::collection($newses)->response()->getData(true);
        $newses = array('newses' => $newses, 'fetched' => true);
        $arrayName = array('newses' => $newses);
        return response($arrayName);
    }
    public function activeNewsesCategories(Request $request)
    {
        $news_categories = NewsCategory::where('is_active', 1);
        if ($request->search) {
            $news_categories = $news_categories->whereLike('name->' . app()->getLocale(), $request->search);
        }
        $news_categories = $news_categories->paginate(10);
        $news_categories = NewsesResource::collection($news_categories)->response()->getData(true);
        $news_categories = array('news_categories' => $news_categories, 'fetched' => true);
        $arrayName = array('news_categories' => $news_categories);
        return response($arrayName);
    }
    public function allActiveAdminsRoles(Request $request)
    {
        $admins_types = Role::where('name', 'admin')->where('is_active', 1);

        if ($request->search) {
            $admins_types = $admins_types->whereLike('display_name->' . app()->getLocale(), $request->search);
        }
        $admins_types = $admins_types->paginate(10);
        $admins_types = RolesResource::collection($admins_types)->response()->getData(true);
        $admins_types = array('admins_types' => $admins_types, 'fetched' => true);
        $arrayName = array('admins_types' => $admins_types);
        return response($arrayName);
    }
    public function activeLanguageCodes()
    {
        $language_codes = LanguageCode::get();
        $language_codes = array('language_codes' => $language_codes);
        $arrayName = array('language_codes' => $language_codes, 'fetched' => true);
        return response($arrayName);
    }
    public function activeContentPages(Request $request)
    {
        $content_pages = ContentPage::where('is_active', 1);
        if ($request->search) {
            $content_pages = $content_pages->whereLike('name->' . app()->getLocale(), $request->search);
        }
        $content_pages = $content_pages->paginate(1);
        $content_pages = ProductsResource::collection($content_pages)->response()->getData(true);
        $content_pages = array('content_pages' => $content_pages, 'fetched' => true);
        $arrayName = array('content_pages' => $content_pages);
        return response($arrayName);
    }
    public function activeReviews(Request $request)
    {
        $reviews = Review::where('is_active', 1);
        if ($request->search) {
            $reviews = $reviews->whereLike('name', $request->search);
        }
        $reviews = $reviews->paginate(10);
        $reviews = ReviewsResource::collection($reviews)->response()->getData(true);
        $reviews = array('reviews' => $reviews, 'fetched' => true);
        $arrayName = array('reviews' => $reviews);
        return response($arrayName);
    }
    public function activeCurrencyCodes()
    {
        $currency_codes = CurrencyCode::get();
        $currency_codes = array('currency_codes' => $currency_codes);
        $arrayName = array('currency_codes' => $currency_codes, 'fetched' => true);
        return response($arrayName);
    }
    public function activeReviewStatuses(Request $request)
    {
        $review_statuses = ReviewStatus::where('is_active', 1);
        if ($request->search) {
            $review_statuses = $review_statuses->whereLike('name->' . app()->getLocale(), $request->search);
        }
        $review_statuses =  $review_statuses->paginate(10);
        $review_statuses = ReviewStatusesResource::collection($review_statuses)->response()->getData(true);
        $review_statuses = array('review_statuses' => $review_statuses, 'fetched' => true);
        $arrayName = array('review_statuses' => $review_statuses);
        return response($arrayName);
    }
    public function activeApplicationBanners(Request $request)
    {
        $application_banners = ApplicationBanner::where('is_active', 1);
        if ($request->search) {
            $application_banners = $application_banners->whereLike('name->' . app()->getLocale(), $request->search);
        }
        $application_banners = $application_banners->paginate(10);
        $application_banners = ApplicationBannersResource::collection($application_banners)->response()->getData(true);
        $application_banners = array('application_banners' => $application_banners, 'fetched' => true);
        $arrayName = array('application_banners' => $application_banners);
        return response($arrayName);
    }
    public function activeApplicationParallaxBanners(Request $request)
    {
        $application_parallax_banners = ApplicationParallaxBanner::where('is_active', 1);
        if ($request->search) {
            $application_parallax_banners = $application_parallax_banners->whereLike('name->' . app()->getLocale(), $request->search);
        }
        $application_parallax_banners = $application_parallax_banners->paginate(10);
        $application_parallax_banners = ApplicationParallaxBannersResource::collection($application_parallax_banners)->response()->getData(true);
        $application_parallax_banners = array('application_parallax_banners' => $application_parallax_banners, 'fetched' => true);
        $arrayName = array('application_parallax_banners' => $application_parallax_banners);
        return response($arrayName);
    }
    public function activeApplicationSliderImages(Request $request)
    {
        $application_slider_images = ApplicationSliderImage::where('is_active', 1);
        if ($request->search) {
            $application_slider_images = $application_slider_images->whereLike('name->' . app()->getLocale(), $request->search);
        }
        $application_slider_images = $application_slider_images->paginate(10);
        $application_slider_images = ApplicationSliderImagesResource::collection($application_slider_images)->response()->getData(true);
        $application_slider_images = array('application_slider_images' => $application_slider_images, 'fetched' => true);
        $arrayName = array('application_slider_images' => $application_slider_images);
        return response($arrayName);
    }
    public function activeContentApplicationPages(Request $request)
    {
        $content_application_pages = ContentApplicationPage::where('is_active', 1);
        if ($request->search) {
            $content_application_pages = $content_application_pages->whereLike('name->' . app()->getLocale(), $request->search);
        }
        $content_application_pages = $content_application_pages->paginate(10);
        $content_application_pages = ContentApplicationPagesResource::collection($content_application_pages)->response()->getData(true);
        $content_application_pages = array('content_application_pages' => $content_application_pages, 'fetched' => true);
        $arrayName = array('content_application_pages' => $content_application_pages);
        return response($arrayName);
    }
    public function activeSeoPages(Request $request)
    {
        $seo_pages = new SeoPage();
        if ($request->search) {
            $seo_pages = $seo_pages->whereLike('name', $request->search);
        }
        $seo_pages = $seo_pages->paginate(10);
        $seo_pages = SeoPagesResource::collection($seo_pages)->response()->getData(true);
        $seo_pages = array('seo_pages' => $seo_pages, 'fetched' => true);
        $arrayName = array('seo_pages' => $seo_pages);
        return response($arrayName);
    }
    public function activeBrands(Request $request)
    {
        $brands = new Brand();
        if ($request->search) {
            $brands = $brands->whereLike('name->' . app()->getLocale(), $request->search);
        }
        $brands = $brands->paginate(10);
        $brands = BrandsResource::collection($brands)->response()->getData(true);
        $brands = array('brands' => $brands, 'fetched' => true);
        $arrayName = array('brands' => $brands);
        return response($arrayName);
    }
    public function cacheClear()
    {
        \Artisan::call('cache:clear');
        \Artisan::call('config:cache');
        return response()->json(["state" => "success", "message" =>  trans('messages.fields.cache_cleared')], 200);
    }

    public function activeShippingMethods(Request $request)
    {
        $shipping_methods = ShippingMethod::where('is_active', 1);
        if ($request->search) {
            $shipping_methods = $shipping_methods->whereLike('name->' . app()->getLocale(), $request->search);
        }
        $shipping_methods =  $shipping_methods->paginate(10);
        $shipping_methods = ShippingMethodsResource::collection($shipping_methods)->response()->getData(true);
        $shipping_methods = array('shipping_methods' => $shipping_methods, 'fetched' => true);
        $arrayName = array('shipping_methods' => $shipping_methods);
        return response($arrayName);
    }

    public function activeAttributes(Request $request)
    {
        $attributes = Attribute::where('is_active', 1);
        if ($request->search) {
            $attributes = $attributes->whereLike('name->' . app()->getLocale(), $request->search);
        }
        $attributes = $attributes->paginate(10);
        $attributes = AttributesResource::collection($attributes)->response()->getData(true);
        $attributes = array('attributes' => $attributes, 'fetched' => true);
        $arrayName = array('attributes' => $attributes);
        return response($arrayName);
    }
    public function activeAttributeValues(Request $request)
    {
        $attribute_values = AttributeValue::where('is_active', 1);
        if ($request->search) {
            $attribute_values = $attribute_values->whereLike('name->' . app()->getLocale(), $request->search);
        }
        $attribute_values = $attribute_values->paginate(10);
        $attribute_values = AttributeValuesResource::collection($attribute_values)->response()->getData(true);
        $attribute_values = array('attribute_values' => $attribute_values, 'fetched' => true);
        $arrayName = array('attribute_values' => $attribute_values);
        return response($arrayName);
    }

    public function activePaymentMethods(Request $request)
    {
        $payment_methods = PaymentMethod::where('is_active', 1);
        if ($request->search) {
            $payment_methods = $payment_methods->whereLike('name->' . app()->getLocale(), $request->search);
        }
        $payment_methods =  $payment_methods->paginate(10);
        $payment_methods = PaymentMethodsResource::collection($payment_methods)->response()->getData(true);
        $payment_methods = array('payment_methods' => $payment_methods, 'fetched' => true);
        $arrayName = array('payment_methods' => $payment_methods);
        return response($arrayName);
    }
    public function getStatesByCountryMobile(StatesByCountryCreateRequest $request)
    {
      $country = Country::where('id',$request->id)->first();
      if($country){
        $states = $country->states()->where('is_active',1)->get();
        $states = StatesResource::collection($states);
        $states = generateResponse($states, true, '', [], 'collection');
        return response($states);
      }else{
          return response(404);
      }
    }
    public function getCitiesByStateMobile(CityByStateCreateRequest $request)
    {
        $state = State::where('id',$request->id)->first();
        if($state){

        $cities = $state->cities()->where('is_active',1)->get();
        $cities = CitiesResource::collection($cities);
        $cities = generateResponse($cities, true, '', [], 'collection');
        return response($cities);
      }else{
        return response(404);
      }
    }
}
