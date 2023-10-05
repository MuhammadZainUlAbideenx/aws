<?php
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Auth Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API Auth routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


    Route::prefix('admin/auth')->name('admin.')->group(function () {
        Route::get('/user', [\App\Http\Controllers\Auth\Admin\UserController::class,'show'])->name('user');
        Route::post('/login', [\App\Http\Controllers\Auth\Admin\LoginController::class,'login']);
        Route::get('/logout', [\App\Http\Controllers\Auth\Admin\LoginController::class,'logout'])->name('logout');
        Route::post('/password/email', [\App\Http\Controllers\Auth\Admin\ForgotPasswordController::class,'sendResetLinkEmail'])->name('password.email');
        Route::get('/password/reset/{token}', [\App\Http\Controllers\Auth\Admin\ResetPasswordController::class,'showResetForm'])->name('password.reset');
        Route::post('/password/reset', [\App\Http\Controllers\Auth\Admin\ResetPasswordController::class,'reset'])->name('password.update');
        Route::get('email/verify/{id}/{hash}', [\App\Http\Controllers\Auth\Admin\VerificationController::class,'verify'])->name('verification.verify');
        Route::post('email/resend', [\App\Http\Controllers\Auth\Admin\VerificationController::class,'resend'])->name('verification.resend');
    });
    Route::prefix('customer/auth')->name('customer.')->group(function () {
        Route::get('/user', [\App\Http\Controllers\Auth\Customer\UserController::class,'show'])->name('user');
        Route::post('/login', [\App\Http\Controllers\Auth\Customer\LoginController::class,'login']);
        Route::post('/socialLogin', [\App\Http\Controllers\Auth\Customer\LoginController::class,'socialLogin']);
        Route::get('/check', [\App\Http\Controllers\Auth\Customer\LoginController::class,'check']);
        Route::get('/logout', [\App\Http\Controllers\Auth\Customer\LoginController::class,'logout'])->name('logout');
        Route::post('/password/confirm ', [\App\Http\Controllers\Auth\Customer\ConfirmPasswordController::class,'confirm']);
        Route::post('/register', [\App\Http\Controllers\Auth\Customer\RegisterController::class,'register']);
        Route::post('/password/email', [\App\Http\Controllers\Auth\Customer\ForgotPasswordController::class,'sendResetLinkEmail'])->name('password.email');
        Route::get('/password/reset/{token}', [\App\Http\Controllers\Auth\Customer\ResetPasswordController::class,'showResetForm'])->name('password.reset');
        Route::post('/password/reset', [\App\Http\Controllers\Auth\Customer\ResetPasswordController::class,'reset'])->name('password.update');
        Route::get('email/verify/{id}/{hash}', [\App\Http\Controllers\Auth\Customer\VerificationController::class,'verify'])->name('verification.verify');
        Route::post('email/resend', [\App\Http\Controllers\Auth\Customer\VerificationController::class,'resend'])->name('verification.resend');
        Route::post('updateCustomerPassword', [\App\Http\Controllers\Auth\Customer\UserController::class,'updateCustomerPassword'])->name('update.customer_password');
    });
    Route::prefix('vendor/auth')->name('vendor.')->group(function () {
         Route::get('/user', [\App\Http\Controllers\Auth\Vendor\UserController::class,'show'])->name('user');
        Route::post('/login', [\App\Http\Controllers\Auth\Vendor\LoginController::class,'login']);
        Route::post('/socialLogin', [\App\Http\Controllers\Auth\Vendor\LoginController::class,'socialLogin']);
        Route::get('/logout', [\App\Http\Controllers\Auth\Vendor\LoginController::class,'logout'])->name('logout');
        Route::post('/password/email', [\App\Http\Controllers\Auth\Vendor\ForgotPasswordController::class,'sendResetLinkEmail'])->name('password.email');
        Route::get('/password/reset/{token}', [\App\Http\Controllers\Auth\Vendor\ResetPasswordController::class,'showResetForm'])->name('password.reset');
        Route::post('/password/reset', [\App\Http\Controllers\Auth\Vendor\ResetPasswordController::class,'reset'])->name('password.update');
        Route::get('email/verify/{id}/{hash}', [\App\Http\Controllers\Auth\Vendor\VerificationController::class,'verify'])->name('verification.verify');
        Route::post('email/resend', [\App\Http\Controllers\Auth\Vendor\VerificationController::class,'resend'])->name ('verification.resend');
        Route::post('updateVendorPassword', [\App\Http\Controllers\Auth\Vendor\UserController::class,'updateVendorPassword'])->name('update.password');
    });

    Route::prefix('rider/auth')->name('rider.')->group(function () {
        Route::get('/user', [\App\Http\Controllers\Auth\Rider\UserController::class,'show'])->name('user');
       Route::post('/login', [\App\Http\Controllers\Auth\Rider\LoginController::class,'login']);
       Route::get('/logout', [\App\Http\Controllers\Auth\Rider\LoginController::class,'logout'])->name('logout');
       Route::post('/password/email', [\App\Http\Controllers\Auth\Rider\ForgotPasswordController::class,'sendResetLinkEmail'])->name('password.email');
       Route::get('/password/reset/{token}', [\App\Http\Controllers\Auth\Rider\ResetPasswordController::class,'showResetForm'])->name('password.reset');
       Route::post('/password/reset', [\App\Http\Controllers\Auth\Rider\ResetPasswordController::class,'reset'])->name('password.update');
       Route::get('email/verify/{id}/{hash}', [\App\Http\Controllers\Auth\Rider\VerificationController::class,'verify'])->name('verification.verify');
       Route::post('email/resend', [\App\Http\Controllers\Auth\Rider\VerificationController::class,'resend'])->name('verification.resend');
       Route::post('updateRiderPassword', [\App\Http\Controllers\Auth\Rider\UserController::class,'updateRiderPassword'])->name('update.rider_password');

    });
?>
