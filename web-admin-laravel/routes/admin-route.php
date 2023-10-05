<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CMSControllers\LanguagesController;
use App\Http\Controllers\CMSControllers\GeneralController;
use App\Http\Controllers\CMSControllers\DependentController;
use App\Http\Controllers\CMSControllers\SettingsController;
use App\Http\Controllers\CMSControllers\ProductsController;
use App\Http\Controllers\CMSControllers\UnitsController;
use App\Http\Controllers\CMSControllers\ManufacturersController;
use App\Http\Controllers\CMSControllers\TaxClassesController;
use App\Http\Controllers\CMSControllers\CategoriesController;
use App\Http\Controllers\CMSControllers\MediaController;
use App\Http\Controllers\CMSControllers\VendorsController;
use App\Http\Controllers\CMSControllers\OrderStatusesController;
use App\Http\Controllers\CMSControllers\RolesController;
use App\Http\Controllers\CMSControllers\PermissionsController;
use App\Http\Controllers\CMSControllers\CurrenciesController;
use App\Http\Controllers\CMSControllers\SliderImagesController;
use App\Http\Controllers\CMSControllers\StaticBannersController;
use App\Http\Controllers\CMSControllers\CountriesController;
use App\Http\Controllers\CMSControllers\ZonesController;
use App\Http\Controllers\CMSControllers\TaxRatesController;
use App\Http\Controllers\CMSControllers\CitiesController;
use App\Http\Controllers\CMSControllers\StatesController;
use App\Http\Controllers\CMSControllers\CouponsController;
use App\Http\Controllers\CMSControllers\DashboardController;
use App\Http\Controllers\CMSControllers\ParallaxBannersController;
use App\Http\Controllers\CMSControllers\CustomersController;
use App\Http\Controllers\CMSControllers\AdminsController;
use App\Http\Controllers\CMSControllers\NewsesController;
use App\Http\Controllers\CMSControllers\NewsCategoriesController;
use App\Http\Controllers\CMSControllers\AboutUsController;
use App\Http\Controllers\CMSControllers\TermConditionController;
use App\Http\Controllers\CMSControllers\RefundPolicyController;
use App\Http\Controllers\CMSControllers\PrivacyPolicyController;
use App\Http\Controllers\CMSControllers\AddressesController;
use App\Http\Controllers\CMSControllers\ContentPagesController;
use App\Http\Controllers\CMSControllers\CommissionsController;
use App\Http\Controllers\CMSControllers\SeoPagesController;
use App\Http\Controllers\CMSControllers\ReviewsController;
use App\Http\Controllers\CMSControllers\ReviewStatusesController;


use App\Http\Controllers\CMSControllers\ApplicationBannersController;
use App\Http\Controllers\CMSControllers\BrandsController;
use App\Http\Controllers\CMSControllers\ApplicationParallaxBannersController;
use App\Http\Controllers\CMSControllers\ApplicationSliderImagesController;
use App\Http\Controllers\CMSControllers\AttributesController;
use App\Http\Controllers\CMSControllers\AttributeValuesController;
use App\Http\Controllers\CMSControllers\ChatController;
use App\Http\Controllers\CMSControllers\ContactFormsController;
use App\Http\Controllers\CMSControllers\ContentApplicationPagesController;
use App\Http\Controllers\CMSControllers\FaqsController;
use App\Http\Controllers\CMSControllers\OrdersController;
use App\Http\Controllers\CMSControllers\ReportsController;
use App\Http\Controllers\CMSControllers\ShippingMethodsController;
use App\Http\Controllers\CMSControllers\PaymentMethodsController;
use App\Http\Controllers\CMSControllers\InventoriesController;
use App\Http\Controllers\CMSControllers\NewslettersController;
use App\Http\Controllers\CMSControllers\PayoutRequestController;
use App\Http\Controllers\CMSControllers\RiderPayoutRequestController;
use App\Http\Controllers\CMSControllers\RidersController;
use App\Http\Controllers\CMSControllers\ThemeSettingsController;
use App\Http\Controllers\CMSControllers\WalletController;
use App\Models\CMSModels\PayoutRequest;

/*
    |--------------------------------------------------------------------------
    | API Admin Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API Admin routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
    */


Route::prefix('admin')->group(function () {
    Route::adminRoutes('languages', LanguagesController::class, 'admin');
    Route::put("languages/updateDefault/{language}", [LanguagesController::class, 'updateDefault'])->name("languages.update_default");
    Route::adminRoutes('products', ProductsController::class, 'admin');
    Route::get("filterVendorProducts", [ProductsController::class, 'filterVendorProducts']);
    Route::put('productsMedia/{product}', [ProductsController::class, 'updateMedia'])->name('products.update_media');
    Route::put('productsAttribute/{product}', [ProductsController::class, 'updateAttribute']);
    Route::post('productsAttribute/{product}', [ProductsController::class, 'addAttribute']);
    Route::delete('productsDeleteAttribute/{product}/{combination_id}', [ProductsController::class, 'deleteAttribute']);

    Route::adminRoutes('units', UnitsController::class, 'admin');
    Route::adminRoutes('attributes', AttributesController::class, 'admin');
    Route::adminRoutes('attribute_values', AttributeValuesController::class, 'admin');
    Route::get("getAttributeValuesByAttribute/{id}", [DependentController::class, 'getAttributeValuesByAttribute']);

    Route::adminRoutes('manufacturers', ManufacturersController::class, 'admin');
    Route::adminRoutes('categories', CategoriesController::class, 'admin');
    Route::adminRoutes('tax_classes', TaxClassesController::class, 'admin');
    //sublan
    Route::adminRoutes('roles', RolesController::class, 'admin');
    Route::adminRoutes('permissions', PermissionsController::class, 'admin');
    Route::adminRoutes('order_statuses', OrderStatusesController::class, 'admin');
    Route::adminRoutes('orders', OrdersController::class, 'admin');
    Route::adminRoutes('payoutRequests', PayoutRequestController::class, 'admin');
    Route::adminRoutes('riderPayoutRequests', RiderPayoutRequestController::class, 'admin');
    Route::put("order_statuses/updateDefault/{order_status}", [OrderStatusesController::class, 'updateDefault'])->name("order_statuses.update_default");
    Route::adminRoutes('vendors', VendorsController::class, 'admin');
    Route::put("updateVendorStoreStatus/{vendor}", [VendorsController::class, 'updateVendorStoreStatus']);
    Route::put("updateVendorFeatured/{vendor}", [VendorsController::class, 'updateVendorFeatured']);
    Route::put("updatePayoutRequestStatus/{payoutRequest_id}/{status}", [PayoutRequestController::class, 'updateStatus']);
    Route::put("updateRiderPayoutRequestStatus/{riderPayoutRequest_id}/{status}", [RiderPayoutRequestController::class, 'updateStatus']);
    Route::adminRoutes('currencies', CurrenciesController::class, 'admin');
    Route::adminRoutes('slider_images', SliderImagesController::class, 'admin');
    Route::adminRoutes('static_banners', StaticBannersController::class, 'admin');
    Route::adminRoutes('parallax_banners', ParallaxBannersController::class, 'admin');
    Route::adminRoutes('tax_rates', TaxRatesController::class, 'admin');
    Route::put("currencies/updateDefault/{currency}", [CurrenciesController::class, 'updateDefault'])->name("currencies.update_default");
    Route::post("settings", [SettingsController::class, 'store'])->name("setting.store");
    Route::post("themeSettings", [ThemeSettingsController::class, 'update'])->name("theme_settings.update");
    Route::adminRoutes('countries', CountriesController::class, 'admin');
    Route::adminRoutes('customers', CustomersController::class, 'admin');
    Route::adminRoutes('admins', AdminsController::class, 'admin');
    Route::adminRoutes('zones', ZonesController::class, 'admin');
    Route::get("getZonesByCountry/{id}", [DependentController::class, 'getZonesByCountry']);
    Route::adminRoutes('cities', CitiesController::class, 'admin');
    Route::get("getCitiesByState/{id}", [DependentController::class, 'getCitiesByState']);
    Route::adminRoutes('states', StatesController::class, 'admin');
    Route::get("getStatesByCountry/{id}", [DependentController::class, 'getStatesByCountry']);
    Route::adminRoutes('coupons', CouponsController::class, 'admin');
    Route::adminRoutes('news', NewsesController::class, 'admin');
    Route::adminRoutes('news_categories', NewsCategoriesController::class, 'admin');
    Route::adminRoutes('about_us', AboutUsController::class, 'admin');
    Route::adminRoutes('term_condition', TermConditionController::class, 'admin');
    Route::adminRoutes('privacy_policy', PrivacyPolicyController::class, 'admin');
    Route::adminRoutes('refund_policy', RefundPolicyController::class, 'admin');
    Route::get("addresses/customer/{id}", [AddressesController::class, 'addresses_index'])->name("addresses.index");
    Route::adminRoutes('addresses', AddressesController::class, 'admin');
    Route::adminRoutes('content_pages', ContentPagesController::class, 'admin');
    Route::adminRoutes('contact_forms', ContactFormsController::class, 'admin');

    Route::adminRoutes('commissions', CommissionsController::class, 'admin');
    Route::adminRoutes('seo_pages', SeoPagesController::class, 'admin');
    Route::adminRoutes('reviews', ReviewsController::class, 'admin');
    Route::adminRoutes('review_statuses', ReviewStatusesController::class, 'admin');
    Route::put("review_statuses/updateDefault/{review_status}", [ReviewStatusesController::class, 'updateDefault'])->name("review_statuses.update_default");
    Route::adminRoutes('application_banners', ApplicationBannersController::class, 'admin');
    Route::adminRoutes('application_parallax_banners', ApplicationParallaxBannersController::class, 'admin');
    Route::adminRoutes('application_slider_images', ApplicationSliderImagesController::class, 'admin');
    Route::adminRoutes('brands', BrandsController::class, 'admin');
    Route::adminRoutes('content_application_pages', ContentApplicationPagesController::class, 'admin');
    Route::adminRoutes('shipping_methods', ShippingMethodsController::class, 'admin');
    Route::put("shipping_methods/updateDefault/{shipping_method}", [ShippingMethodsController::class, 'updateDefault'])->name("shipping_methods.update_default");
    Route::adminRoutes('payment_methods', PaymentMethodsController::class, 'admin');
    Route::adminRoutes('riders', RidersController::class, 'admin');
    // rider shipping commission route
    Route::get("getRiderShipping", [RidersController::class, 'getRiderShipping']);
    Route::get("updateRiderCommission", [RidersController::class, 'updateRiderCommission']);
    Route::put("payment_methods/updateDefault/{payment_method}", [PaymentMethodsController::class, 'updateDefault'])->name("payment_methods.update_default");
    Route::get("getProductInventory/{product}", [DependentController::class, 'getProductInventory'])->name("products.get_product_inventory");
    Route::adminRoutes('inventories', InventoriesController::class, 'admin');
    Route::adminRoutes('faqs', FaqsController::class, 'admin');
    Route::adminRoutes('newsletter', NewslettersController::class, 'admin');
    Route::put("newsletter/updateDefault/{newsletter_status}", [NewslettersController::class, 'updateDefault'])->name("newsletter_statuses.update_default");

    Route::get("settingsActive", [SettingsController::class, 'index']);
    Route::get("themeSettingsActive", [ThemeSettingsController::class, 'index']);
    Route::get("getDashboardData", [DashboardController::class, 'index'])->name("admin.dashboard");
    Route::get("mediaActive", [GeneralController::class, 'activeMedia']);
    Route::get("categoriesActive", [GeneralController::class, 'activeCategories']);
    Route::get("categoriesSelectActive", [GeneralController::class, 'activeSelectCategories']);
    Route::get("categoriesActiveInactive", [GeneralController::class, 'activeInactiveCategories']);
    Route::get("categoriesParentChildActive", [GeneralController::class, 'activeParentChildCategories']);
    Route::get("categoriesParentActive", [GeneralController::class, 'activeParentCategories']);
    Route::get("manufacturersActive", [GeneralController::class, 'activeManufacturers']);
    Route::get("languagesActive", [GeneralController::class, 'activeLanguages']);
    Route::get("rolesActive", [GeneralController::class, 'activeRoles'])->name("roles.active_roles");
    Route::get("unitsActive", [GeneralController::class, 'activeUnits']);
    Route::get("taxClassesActive", [GeneralController::class, 'activeTaxClasses']);
    Route::get("permissionsActive", [GeneralController::class, 'activePermissions']);
    Route::get("orderStatusesActive", [GeneralController::class, 'activeOrderStatuses'])->name("order_statuses.active_order_statuses");
    Route::get("currenciesActive", [GeneralController::class, 'activeCurrencies'])->name("currencies.active_currencies");
    Route::get("vendorsActive", [GeneralController::class, 'activeVendors'])->name("vendors.active_vendors");
    Route::get("categoryVendors/{vendor}", [GeneralController::class, 'vendorCategories'])->name("vendors.vendor_categories");
    Route::get("sliderImagesActive", [GeneralController::class, 'activeSliderImages'])->name("slider_images.active_slider_images");
    Route::get("staticBannersActive", [GeneralController::class, 'activeStaticBanners'])->name("static_banners.active_static_banners");
    Route::get("parallaxBannersActive", [GeneralController::class, 'activeParallaxBanners'])->name("parallax_banners.active_parallax_banners");
    Route::get("countriesActive", [GeneralController::class, 'activeCountries']);
    Route::get("getActiveCountryById/{id}", [GeneralController::class, 'getActiveCountryById']);
    Route::get("statesActive", [GeneralController::class, 'activeStates']);
    Route::get("citiesActive", [GeneralController::class, 'activeCities']);
    Route::get("zonesActive", [GeneralController::class, 'activeZones']);
    Route::get("productsActive", [GeneralController::class, 'activeProducts']);
    Route::get("couponsActive", [GeneralController::class, 'activeCoupons']);
    Route::get("tax_ratesActive", [GeneralController::class, 'activeTaxRates']);
    Route::get("customersActive", [GeneralController::class, 'activeCustomers']);
    Route::get("adminsActive", [GeneralController::class, 'activeAdmins'])->name("admins.active_admins");
    Route::get("allActiveAdminsRoles", [GeneralController::class, 'allActiveAdminsRoles'])->name("admins.active_admins_roles");
    Route::get("newsActive", [GeneralController::class, 'activeNewses'])->name("news.active_news");
    Route::get("newsCategoriesActive", [GeneralController::class, 'activeNewsesCategories'])->name("newsCategories.active_news_categories");
    Route::get("languageCodesActive", [GeneralController::class, 'activeLanguageCodes'])->name("languageCodes.active_language_codes");
    Route::get("contentPagesActive", [GeneralController::class, 'activeContentPages'])->name("contentPages.active_content_pages");
    Route::get("reviewsActive", [GeneralController::class, 'activeReviews'])->name("reviews.active_reviews");
    Route::get("reviewStatusesActive", [GeneralController::class, 'activeReviewStatuses'])->name("review_statuses.active_review_statuses");
    Route::get("currencyCodesActive", [GeneralController::class, 'activeCurrencyCodes'])->name("currencyCodes.active_currency_codes");
    Route::get("applicationBannersActive", [GeneralController::class, 'activeApplicationBanners'])->name("application_banners.active_application_banners");
    Route::get("applicationParallaxBannersActive", [GeneralController::class, 'activeApplicationParallaxBanners'])->name("application_parallax_banners.active_application_parallax_banners");
    Route::get("applicationSliderImagesActive", [GeneralController::class, 'activeApplicationSliderImages'])->name("application_slider_images.active_application_slider_images");
    Route::get("contentApplicationPagesActive", [GeneralController::class, 'activeContentApplicationPages'])->name("contentApplicationPages.active_content_application_pages");
    Route::get("seoPagesActive", [GeneralController::class, 'activeSeoPages']);
    Route::get("brandsActive", [GeneralController::class, 'activeBrands'])->name("brands.active_brands");
    Route::get('cacheClear', [GeneralController::class, 'cacheClear'])->name("cache_clear");
    Route::get("shippingMethodsActive", [GeneralController::class, 'activeShippingMethods'])->name("shipping_methods.shipping_methods");

    Route::get("attributeActive", [GeneralController::class, 'activeAttributes'])->name("attributes.active_attributes");
    Route::get("attributeValueActive", [GeneralController::class, 'activeAttributeValues'])->name("attributes.active_attribute_values");
    Route::get("paymentMethodsActive", [GeneralController::class, 'activePaymentMethods'])->name("payment_methods.payment_methods");


    Route::get('/fetchMedia', [MediaController::class, 'fetchMedia']);
    Route::get('/fetchMedia/{id}', [MediaController::class, 'fetchMedia']);
    Route::post('/addMedia', [MediaController::class, 'addMedia']);
    Route::get('/deleteMedia/{id}', [MediaController::class, 'deleteMedia']);
    Route::get('/deleteThumbnail/{id}', [MediaController::class, 'deleteMedia']);
    Route::post('/filterMedia', [MediaController::class, 'filter']);
    Route::post("changeOrderStatus", [OrdersController::class, 'changeOrderStatus'])->name("order_statuses.change_order_statuses");

    Route::get('/getAdminProfile', [AdminsController::class, 'getAdminProfile']);
    Route::post('/updateProfileImage', [AdminsController::class, 'updateProfileImage']);
    Route::post('/updateAdminProfile', [AdminsController::class, 'updateAdminProfile']);

    Route::get('/getFilteredSaleReports', [ReportsController::class, 'getFilteredSaleReports']);
    Route::post('/saleExport', [ReportsController::class, 'saleExport']);

    Route::get('/getFilteredCustomerReports', [ReportsController::class, 'getFilteredCustomerReports']);
    Route::post('/customerExport', [ReportsController::class, 'customerExport']);

    Route::get('/getFilteredProductReports', [ReportsController::class, 'getFilteredProductReports']);
    Route::post('/productExport', [ReportsController::class, 'productExport']);

    Route::get('/getFilteredOrderReports', [ReportsController::class, 'getFilteredOrderReports']);
    Route::post('/orderExport', [ReportsController::class, 'orderExport']);

    // live chat with rider
    Route::get('/getRiderMessages', [ChatController::class, 'getRiderMessages']);
    Route::get('/fetchAllRiderMessages/{id}', [ChatController::class, 'FetchMessage']);
    // import products
    Route::post("/importData", [ProductsController::class, 'importData']);
});
