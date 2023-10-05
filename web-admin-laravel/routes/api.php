<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\CMSControllers\DependentController;
use App\Http\Controllers\WebControllers\WebsiteController;
use App\Http\Controllers\WebControllers\ApplicationController;
use App\Http\Controllers\WebControllers\ApiGeneralController;
use App\Http\Controllers\WebControllers\ApiProductsController;
use App\Http\Controllers\WebControllers\ApiPaymentMethodsController;
use App\Http\Controllers\WebControllers\ApiCategoriesController;
use App\Http\Controllers\WebControllers\ApiNewsesController;
use App\Http\Controllers\WebControllers\CartController;
use App\Http\Controllers\GeneralControllers\FcmNotificationController;
use App\Http\Controllers\GeneralControllers\ChatController;
use App\Http\Controllers\GeneralControllers\WalletController;
use App\Http\Controllers\WebControllers\ApiVendorsController;
use App\Http\Controllers\WebControllers\ApiBrandsController;
use App\Http\Controllers\WebControllers\ApiAboutUsController;
use App\Http\Controllers\WebControllers\ApiTermConditionController;
use App\Http\Controllers\WebControllers\ApiPrivacyPolicyController;
use App\Http\Controllers\WebControllers\ApiRefundPolicyController;
use App\Http\Controllers\WebControllers\WishlistProductController;
use App\Http\Controllers\WebControllers\ShopPageController;
use App\Http\Controllers\PaymentGateway\Gateway;
use App\Http\Controllers\WebControllers\ApiCustomersController;
use App\Http\Controllers\WebControllers\ApiNewslettersController;
use App\Http\Controllers\WebControllers\ApiSignUp;
use App\Http\Controllers\WebControllers\ApiContactFormController;
use App\Http\Controllers\WebControllers\ApiReviewsController;
use App\Http\Controllers\WebControllers\ApiRidersOrderController;
use App\Http\Controllers\WebControllers\InstagramController;
use App\Http\Requests\Web\validateBillingAddressRequest\validateBillingAddressRequest;
use App\Http\Requests\Web\validateShippingAddressRequest\validateShippingAddressRequest;
use App\Http\Requests\Web\validateShippingMethodRequest\validateShippingMethodRequest;



use Intervention\Image\ImageManagerStatic as Image;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::prefix('web')->middleware('verifyApplicationAuthenticated')->group(function () {
    Route::get("check", function () {
        $media = \App\Models\CMSModels\Media::get();
        foreach ($media as $med) {
            $val = str_replace('/api/', "", $med->original_media_path);
            $path = public_path($val);
            if (File::exists($path)) {
                $file = file_get_contents($path);
                $image = Image::make($file);
                $height = $image->height();
                $width = $image->width();
                $med->update(['width' => $width, 'height' => $height]);
            }
            // code...
        }
        return response()->json('updated');
    });

    //   Route::get("imageExists", function () {
    //     $media = \App\Models\CMSModels\Media::get();
    //     foreach ($media as $med) {

    //         $val = str_replace('/api/', "", $med->original_media_path);
    //         $file_name = str_replace('media/image/', "", $val);
    //         $path = public_path($val);
    //         $sourcePath=public_path($val);

    //         $destinationPath=public_path('media/backup_images/'.$file_name);
    //         if (File::exists($path)) {
    //             File::move($sourcePath,$destinationPath);
    //         }
    //         // code...
    //     }
    //     return response()->json('Moved');
    // });

    Route::get("shopPageData", [ShopPageController::class, 'allShopPageData'])->name('shop_page.shop_page_data');
    Route::get("shopFilterProducts", [ShopPageController::class, 'allShopPageFilterProducts'])->name('shop_page.shop_page_products');
    Route::get("fetchCartItems", [CartController::class, 'index'])->name('cart.index');
    Route::post("addCartItem", [CartController::class, 'store'])->name('cart.store');
    Route::post("changeCartItemQuantity", [CartController::class, 'changeQuantity'])->name('cart.change_quantity');
    Route::delete("removeCartItem/{cart_id}", [CartController::class, 'destroy'])->name('cart.delete');
    Route::delete("deleteAllCartItems", [CartController::class, 'deleteAllCartItems']);
    Route::get("fetchWishlistItems", [WishlistProductController::class, 'index'])->name('wishlist.index');
    Route::post("addWishlistItem", [WishlistProductController::class, 'store'])->name('wishlist.store');
    Route::get("search_Wishlist_Product", [WishlistProductController::class, 'searchWishlistProduct'])->name('search.wishlist_product');
    Route::post("deleteWishlistItem", [WishlistProductController::class, 'destroy'])->name('wishlist.delete');
    Route::get("generic_web_data", [WebsiteController::class, 'allGenericData'])->name("web.generic_data");
    Route::get("generic_app_data", [ApplicationController::class, 'allGenericData'])->name("app.generic_data");
    Route::get("fetchFooterData", [WebsiteController::class, 'fetchFooterData'])->name("web.all_footer_data");
    Route::get("contentPageDetail/{slug}", [WebsiteController::class, 'websiteContentPageDetail'])->name("web.content_page_detail");

    Route::get('rider_pending_order_list', [ApiRidersOrderController::class, 'RiderPendingOrderList']);
    Route::get('rider_order_list', [ApiRidersOrderController::class, 'RiderOrderList']);
    Route::post('rider_update_status', [ApiRidersOrderController::class, 'RiderUpdateStatus']);
    Route::get('rider_order_detail', [ApiRidersOrderController::class, 'RiderOrderDetail']);
    Route::get("rider_profile", [ApiRidersOrderController::class, 'RiderProfile'])->name("rider_profile");
    Route::post('rider_update_image', [ApiRidersOrderController::class, 'RiderUpdateImage']);
    Route::post('rider_update_profile', [ApiRidersOrderController::class, 'RiderUpdateProfile']);
    Route::get('rider_order_detail', [ApiRidersOrderController::class, 'RiderOrderDetail']);
    Route::post('rider_search_order', [ApiRidersOrderController::class, 'RiderSearchOrder']);
    Route::post('/createPayoutRequest', [ApiRidersOrderController::class, 'createPayoutRequest']);

    Route::post("add_product_review", [ApiReviewsController::class, 'addProductReview']);

    Route::post("order_tracking", [ApiGeneralController::class, 'orderTracking']);

    Route::post("depositAmount", [WalletController::class, 'depositAmount']);
    Route::get("getWalletBalance", [WalletController::class, 'getWalletBalance']);
    Route::get("getWalletTransactions", [WalletController::class, 'getWalletTransactions']);
    Route::post("withdrawAmount", [WalletController::class, 'withdrawAmount']);
    Route::post("RefundAmount", [WalletController::class, 'RefundAmount']);

    Route::post("store_message", [ChatController::class, 'StoreMessage']);
    Route::get("fetch_message", [ChatController::class, 'FetchMessage']);
    Route::get("fetch_vendor_message", [ChatController::class, 'FetchVendorMessage']);

    Route::get("application_content_pages", [ApplicationController::class, 'applicationContentPages'])->name("app.content_pages");

    Route::get("environment", [ApiGeneralController::class, 'environment'])->name("web.environment");
    Route::get("application_default_settings", [ApiGeneralController::class, 'applicationDefaultSettings'])->name("application.application_default_settings");
    Route::get("website_default_settings", [ApiGeneralController::class, 'websiteDefaultSettings'])->name("web.website_default_settings");
    Route::get("languages", [ApiGeneralController::class, 'allLanguages'])->name("web.languages");
    Route::get("currencies", [ApiGeneralController::class, 'allCurrencies'])->name("web.currencies");
    Route::get("settings", [ApiGeneralController::class, 'allSettings'])->name("web.settings");
    Route::get("featured_category", [ApiGeneralController::class, 'FeaturedCategories'])->name("web.featured_category");

    Route::get("posts/{post}", [ApiNewsesController::class, 'postDetail'])->name("web.posts");

    Route::get("categories", [ApiCategoriesController::class, 'allCategories'])->name("web.categories");
    Route::get("categories/{category}", [ApiCategoriesController::class, 'categoryDetail'])->name("web.category_detail");
    Route::post("search_Category", [ApiCategoriesController::class, 'searchCategory'])->name("searchCategory");

    Route::get("flash_sale_products", [ApiProductsController::class, 'allFlashSaleProducts'])->name("web.flash_sale_products");
    Route::get("fetch_coupons", [ApiGeneralController::class, 'allCoupons'])->name("web.fetch_coupons");

    Route::get("top_selling_products", [ApiProductsController::class, 'allTopSellingProducts'])->name("web.top_selling_products");
    Route::get("top_reviewed_products", [ApiProductsController::class, 'allTopReviewedProducts'])->name("web.top_reviewed_products");
    Route::get("category_wise_products", [ApiProductsController::class, 'allCategoryWiseProducts'])->name("web.category_wise_products");
    Route::get("featured_products_categories_wise", [ApiProductsController::class, 'allFeaturedProductsCategoriesWise'])->name("web.featured_products_categories_wise");
    Route::get("featured_products", [ApiProductsController::class, 'allFeaturedProducts'])->name("web.featured_products");
    Route::get("upcoming_products", [ApiProductsController::class, 'allUpcomingProducts'])->name("web.upcoming_products");
    Route::get("new_arrival_products", [ApiProductsController::class, 'allNewArrivalProducts'])->name("web.new_arrival_products");
    Route::get("latest_products", [ApiProductsController::class, 'allLatestProducts'])->name("web.latest_products");
    Route::get("trending_products", [ApiProductsController::class, 'allTrendingProductsMobile'])->name("web.trending_products_mobile");
    Route::get("trending_products_web", [ApiProductsController::class, 'allTrendingProducts'])->name("web.trending_products_web");
    Route::get("product/{slug}", [ApiProductsController::class, 'productDetail'])->name("web.product_detail");
    Route::get("productsByCategoryId/{category}", [ApiProductsController::class, 'allProductsByCategoryId'])->name("web.products_by_category_id");
    Route::get('search_products', [ApiProductsController::class, 'searchProduct']);
    Route::get('search_product_by_category', [ApiProductsController::class, 'searchProductByCategory']);
    Route::get("brands", [ApiBrandsController::class, 'allBrands'])->name("allBrands");
    Route::get("aboutus", [ApiAboutUsController::class, 'allAboutUs'])->name("allAboutUs");
    Route::get("term_condition", [ApiTermConditionController::class, 'allTermCondition'])->name("allTermCondition");
    Route::get("privacy_policy", [ApiPrivacyPolicyController::class, 'allPrivacyPolicy'])->name("allPrivacyPolicy");
    Route::get("refund_policy", [ApiRefundPolicyController::class, 'allRefundPolicy'])->name("allRefundPolicy");
    //   for customer app starts
    Route::get("brandProducts/{id}", [ApiBrandsController::class, 'brandProducts'])->name("brandProducts");
    //   for customer app ends
    Route::get("vendors", [ApiVendorsController::class, 'allVendors'])->name("allVendors");
    Route::get("vendor/{slug}", [ApiVendorsController::class, 'vendorDetail'])->name("web.vendor_detail");
    Route::get("vendor/{slug}/reviews", [ApiVendorsController::class, 'vendorReviews'])->name("web.vendor_reviews");
    Route::post("follow_vendor", [ApiVendorsController::class, 'followVendpor'])->name("web.follow_vendor");

    Route::get("featured_vendors", [ApiVendorsController::class, 'allFeaturedVendors'])->name("web.featured_vendors");

    //payment_routes
    Route::post("executePayment", [Gateway::class, 'index'])->name("web.executePayment");
    Route::post("verifyPayment", [Gateway::class, 'verifyPayment'])->name("web.verifyPayment");
    //paymrnt_routes
    Route::get("payment_methods", [ApiPaymentMethodsController::class, 'allPaymentMethods'])->name("web.payment_methods");
    Route::post("compare_products", [ApiProductsController::class, 'compareProducts'])->name("web.compareProducts");
    Route::get("vendor/{slug}/products", [ApiVendorsController::class, 'vendorProducts'])->name("web.vendor_products");
    Route::get("{slug}/faqs", [ApiProductsController::class, 'productFaq'])->name("web.product_faq");
    Route::get("{slug}/reviews", [ApiProductsController::class, 'productReview'])->name("web.product_review");
    Route::get("customer_orders", [ApiCustomersController::class, 'CutomerOrders'])->name("web.customer_order");
    Route::get("customer_profile", [ApiCustomersController::class, 'CutomerProfile'])->name("web.customer_profile");
    Route::get("customer_all_addresses", [ApiCustomersController::class, 'CustomerAllAddresses'])->name("web.customer_all_addresses");
    Route::post("addCustomerAddress", [ApiCustomersController::class, 'addCustomerAddress'])->name("web.add_customer_addresses");
    Route::get("viewCustomerAddress/{id}", [ApiCustomersController::class, 'viewCustomerAddress'])->name("web.view_customer_addresses");
    Route::post("updateCustomerAddress", [ApiCustomersController::class, 'updateCustomerAddress'])->name("web.update_customer_addresses");
    Route::post("updateCustomerdefaultAddress", [ApiCustomersController::class, 'updateCustomerdefaultAddress'])->name("web.update_customer_default_addresses");
    Route::post("customerProfileUpdate", [ApiCustomersController::class, 'customerProfileUpdate'])->name("web.update_customer_profile");
    Route::post("updateProfileImage", [ApiCustomersController::class, 'updateProfileImage'])->name("web.update_profile_image");
    Route::delete("deleteCustomerAddress/{id}", [ApiCustomersController::class, 'deleteCustomerAddress'])->name("web.delete_customer_addresses");
    Route::post("deleteCustomerAddressMobile", [ApiCustomersController::class, 'deleteCustomerAddressMobile']);
    Route::post("registerCustomer", [ApiSignUp::class, 'registerCustomer'])->name("web.register_customer");
    Route::get("customerWithAddresses", [ApiCustomersController::class, 'customerWithAddresses'])->name("web.customer_with_addresses");
    Route::get("allShippingMethods", [ApiGeneralController::class, 'allShippingMethods'])->name("web.all_shipping_methods");

    Route::post("validateBillingAddress", function (validateBillingAddressRequest $request) {
        return response()->json(['state' => 'success']);
    })->name("web.validate_billing_address");
    //   Route::post("validateShippingAddress", function (validateShippingAddressRequest $request) {
    //       return response()->json(['state' => 'success']);
    //   })->name("web.validate_shipping_address");
    Route::post("validateShippingAddress", [ApiGeneralController::class, 'validateAndCalculateShipping'])->name("web.validate_shipping_address");
    Route::post("validateShippingMethod", function (validateShippingMethodRequest $request) {
        return response()->json(['state' => 'success']);
    })->name("web.validate_shipping_method");

    Route::get("statesActive", [ApiCustomersController::class, 'activeStates'])->name("web.active_states");
    Route::get("citiesActive", [ApiCustomersController::class, 'activeCities'])->name("web.active_cities");
    Route::get("countriesActive", [ApiCustomersController::class, 'activeCountries'])->name("web.active_countries");
    Route::get("getCitiesByState/{id}", [ApiCustomersController::class, 'getCitiesByState'])->name("web.get_cities_by_state");
    Route::get("getStatesByCountry/{id}", [ApiCustomersController::class, 'getStatesByCountry'])->name("web.get_states_by_country");
    Route::get("order_detail/{id}", [ApiCustomersController::class, 'OrderDetail'])->name("web.order_detail");
    Route::get("order_detail", [ApiCustomersController::class, 'OrderDetailMobile']);
    Route::post("newsletter", [ApiNewslettersController::class, 'create'])->name("web.newsletter");
    Route::get("all_posts", [ApiNewsesController::class, 'allPostss'])->name("web.all_posts");
    Route::get("post_detail/{slug}", [ApiNewsesController::class, 'postDetail'])->name("web.post_detail");
    Route::get("post_detail_mobile", [ApiNewsesController::class, 'postDetailMobile']);
    Route::post("submit_contact_form", [ApiContactFormController::class, 'create'])->name("web.submit_contact_form");
    Route::get("megaMenuItems", [WebsiteController::class, 'megaMenuItems'])->name("web.mega_menu_items");
    Route::post("validateCouponCode",  [CartController::class, 'validateCouponCode'])->name("validate_coupon_code");
    Route::get("getStatesByCountryMobile", [DependentController::class, 'getStatesByCountryMobile']);
    Route::get("getCitiesByStateMobile", [DependentController::class, 'getCitiesByStateMobile']);
    Route::post('/storeFcmToken', [FcmNotificationController::class, 'storeToken']);
    Route::post('/sendPushNotification', [FcmNotificationController::class, 'sendPushNotification']);
    Route::get('/googleAuthDetails', [\App\Http\Controllers\Auth\Customer\LoginController::class, 'googleAuthDetails']);
    Route::get('/facebookAuthDetails', [\App\Http\Controllers\Auth\Customer\LoginController::class, 'facebookAuthDetails']);
    Route::get('/instagram', [InstagramController::class, 'instagram']);
});




Route::get('/clear-cache', function () {
    \Artisan::call('optimize');
    \Artisan::call('clear-compiled');
    return "Cache Cleared";
});
