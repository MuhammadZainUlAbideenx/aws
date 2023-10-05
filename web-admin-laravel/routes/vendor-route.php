<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CMSControllers\DependentController;
use App\Http\Controllers\CMSControllers\GeneralController;
use App\Http\Controllers\SellerControllers\SellerChatController;
use App\Http\Controllers\SellerControllers\SellerRiderPayoutRequestController;
use App\Http\Controllers\SellerControllers\SellerSignUpController;
use App\Http\Controllers\SellerControllers\SellerProductsController;
use App\Http\Controllers\SellerControllers\SellerStoresController;
use App\Http\Controllers\SellerControllers\SellerProfileController;
use App\Http\Controllers\SellerControllers\SellerDashboardController;
use App\Http\Controllers\SellerControllers\SellerOrdersController;
use App\Http\Controllers\SellerControllers\SellerPayoutRequestController;
use App\Http\Controllers\SellerControllers\SellerReviewsController;
use App\Http\Controllers\SellerControllers\SellerRidersController;
use App\Http\Controllers\SellerControllers\SellerReportsController;

/*
|--------------------------------------------------------------------------
| API Vendor Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API Vendor routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
    Route::prefix('vendor')->group(function () {
        Route::adminRoutes('products',SellerProductsController::class);
        Route::put('productsMedia/{product}',[SellerProductsController::class,'updateMedia']);
        Route::put('productsAttribute/{product}',[SellerProductsController::class,'updateAttribute']);
        Route::post('productsAttribute/{product}',[SellerProductsController::class,'addAttribute']);
        Route::delete('productsDeleteAttribute/{product}/{combination_id}',[SellerProductsController::class,'deleteAttribute']);
        Route::post("registerVendor", [SellerSignUpController::class,'registerVendor'])->name("seller.register_seller");
        Route::adminRoutes('units',UnitsController::class);
        Route::get("getAttributeValuesByAttribute/{id}", [DependentController::class,'getAttributeValuesByAttribute']);

        Route::adminRoutes('orders',SellerOrdersController::class);
        Route::adminRoutes('riders',SellerRidersController::class);
        Route::get("getZonesByCountry/{id}", [DependentController::class,'getZonesByCountry']);
        Route::adminRoutes('cities',CitiesController::class);
        Route::get("getCitiesByState/{id}", [DependentController::class,'getCitiesByState']);
        Route::adminRoutes('states',StatesController::class);
        Route::get("getStatesByCountry/{id}", [DependentController::class,'getStatesByCountry']);
        Route::adminRoutes('seo_pages',SeoPagesController::class);
        Route::adminRoutes('reviews',SellerReviewsController::class);
        Route::adminRoutes('faqs',FaqsController::class);
        Route::adminRoutes('riderPayoutRequests',SellerRiderPayoutRequestController::class);
        Route::put("updateRiderPayoutRequestStatus/{riderPayoutRequest_id}/{status}", [SellerRiderPayoutRequestController::class,'updateStatus']);
        Route::get("getSellerDashboardData", [SellerDashboardController::class,'index'])->name("seller.dashboard");
        Route::get("getVendorAndStoreStatus", [SellerDashboardController::class,'getVendorAndStoreStatus'])->name("seller.getVendorAndStoreStatus");

        Route::get("settingsActive", [SettingsController::class,'index']);
        Route::get("mediaActive", [GeneralController::class,'activeMedia']);
        Route::get("categoriesActive", [GeneralController::class,'activeCategories']);
        Route::get("categoriesSelectActive", [GeneralController::class,'activeSelectCategories']);
        Route::get("categoriesActiveInactive", [GeneralController::class,'activeInactiveCategories']);
        Route::get("categoriesParentChildActive", [GeneralController::class,'activeParentChildCategories']);
        Route::get("manufacturersActive", [GeneralController::class,'activeManufacturers']);
        Route::get("languagesActive", [GeneralController::class,'activeLanguages']);
        Route::get("unitsActive", [GeneralController::class,'activeUnits']);
        Route::get("taxClassesActive", [GeneralController::class,'activeTaxClasses']);
        Route::get("permissionsActive", [GeneralController::class,'activePermissions']);
        Route::get("countriesActive", [GeneralController::class,'activeCountries']);
        Route::get("countriesActiveForMobile", [GeneralController::class,'activeCountriesForMobile']);
        Route::get("statesActive", [GeneralController::class,'activeStates']);
        Route::get("citiesActive", [GeneralController::class,'activeCities']);
        Route::get("getStatesByCountryMobile", [GeneralController::class,'getStatesByCountryMobile']);
        Route::get("getCitiesByStateMobile", [GeneralController::class,'getCitiesByStateMobile']);
        Route::get("zonesActive", [GeneralController::class,'activeZones']);
        Route::get("activeProductsSeller", [SellerProductsController::class,'activeProductsSeller']);
        Route::get("couponsActive", [GeneralController::class,'activeCoupons']);
        Route::get("tax_ratesActive", [GeneralController::class,'activeTaxRates']);
        Route::get("customersActive", [GeneralController::class,'activeCustomers']);
        Route::get("activeCustomersSeller", [SellerReviewsController::class,'activeCustomersSeller']);

        Route::get("seoPagesActive", [GeneralController::class,'activeSeoPages']);

        Route::get('/fetchMedia', [MediaController::class,'fetchMedia']);
        Route::get('/fetchMedia/{id}', [MediaController::class,'fetchMedia']);
        Route::post('/addMedia', [MediaController::class,'addMedia']);
        Route::get('/deleteMedia/{id}', [MediaController::class,'deleteMedia']);
        Route::get('/deleteThumbnail/{id}', [MediaController::class,'deleteMedia']);
        Route::post('/filterMedia', [MediaController::class,'filter']);
        Route::get('/getVendorStore', [SellerStoresController::class,'getVendorStore']);
        Route::post('/createOrUpdateVendorStore', [SellerStoresController::class,'createOrUpdateVendorStore']);
        Route::post('/updateVendorProfile', [SellerProfileController::class,'updateVendorProfile']);
        Route::post('/updateProfileImage', [SellerProfileController::class,'updateProfileImage']);
        Route::get("ordersActive", [GeneralController::class,'activeOrders'])->name("orders.active_orders");
        Route::post("changeSellerOrderStatus", [SellerOrdersController::class,'changeOrderStatus'])->name("order_statuses.change_seller_order_statuses");
        // live chat with rider
        Route::get('/getRiderMessages', [SellerChatController::class,'getRiderMessages']);
        Route::get('/fetchAllRiderMessages/{id}', [SellerChatController::class,'FetchMessage']);
    // rider shipping commission route
        Route::get("getRiderShipping", [SellerRidersController::class,'getRiderShipping']);
        Route::get("updateRiderCommission", [SellerRidersController::class,'updateRiderCommission']);
     // Seller Reports Routes
      Route::get('/getFilteredSellerSaleReports', [SellerReportsController::class,'getFilteredSellerSaleReports']);
      Route::post('/saleSellerExport', [SellerReportsController::class,'saleSellerExport']);

      Route::get('/getFilteredSellerProductReports', [SellerReportsController::class,'getFilteredSellerProductReports']);
      Route::post('/productSellerExport', [SellerReportsController::class,'productSellerExport']);

      Route::get('/getFilteredSellerOrderReports', [SellerReportsController::class,'getFilteredSellerOrderReports']);
      Route::post('/orderSellerExport', [SellerReportsController::class,'orderSellerExport']);
      Route::post('/createPayoutRequest', [SellerPayoutRequestController::class,'createPayoutRequest']);
      });
?>
