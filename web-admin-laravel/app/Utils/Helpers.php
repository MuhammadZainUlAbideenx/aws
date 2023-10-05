<?php

use App\Http\Controllers\GeneralControllers\FcmNotificationController;
use App\Http\Requests\General\PushNotificationRequest;
use App\Models\CMSModels\Currency;
use App\Models\CMSModels\Product;
use App\Models\CMSModels\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

if (!function_exists('remove_api_segment')) {
    function remove_api_segment($route)
    {
        $swapDomain = str_replace(config('app.api_url'), config('app.url'), $route);

        return preg_replace('/api\/v[0-9]+\//', '', $swapDomain);
    }
}
function allLanguages()
{
    $languages = \App\Models\CMSModels\Language::where('is_active', 1)->get();
    return $languages;
}
function defaultLanguage()
{
    $language = \App\Models\CMSModels\Language::where('is_default', 1)->first();
    return $language;
}
function defaultCurrency()
{
    $currency = \App\Models\CMSModels\Currency::where('is_default', 1)->first();
    return $currency;
}
function currentCurrency($code)
{
    $currency = \App\Models\CMSModels\Currency::where('code', $code)->where('is_active', 1)->first();
    return $currency;
}
function dateFormat()
{
    $format = Setting::where('name', 'date_format')->pluck('value')->first();
    return $format;
}
function timezone()
{
    $format = Setting::where('name', 'timezone')->pluck('value')->first();
    return $format;
}
function translationRequiredForAllLanguages()
{
    $validationSetting = \App\Models\CMSModels\Setting::where('name', 'is_all_translations_required')->first();
    return (int)$validationSetting->value;
}
function allSettings()
{
    $validationSetting = \App\Models\CMSModels\Setting::select('name', 'value')->pluck('value', 'name')->toArray();
    $default_currency = Currency::where('is_default', 1)->first();
    $validationSetting['current_currency'] = $default_currency;
    return $validationSetting;
}
function getGuard()
{
    if (\Illuminate\Support\Facades\Auth::guard('admin-api')->check()) {
        return "admin";
    } elseif (\Illuminate\Support\Facades\Auth::guard('customer-api')->check()) {
        return "customer";
    } elseif (\Illuminate\Support\Facades\Auth::guard('vendor-api')->check()) {
        return "vendor";
    }
}
function generateResponse($arr, $success, $message, $errors, $type = 'paginated')
{
    if ($type == 'paginated') {
        if (!isset($arr['data'])) {
            $arr['data'] = [];
        }
        $arr['success'] = $success;
        $arr['message'] = $message;
        $arr['errors'] = $errors;
        return $arr;
    } else {
        $response = [];
        $response['data'] = $arr;
        $response['success'] = $success;
        $response['message'] = $message;
        $response['errors'] = $errors;
        return $response;
    }
}

function get_converted_price($input_price)
{
    $current_currency = session('current_currency');
    $price =  floatval(str_replace(',', '', number_format($input_price, $current_currency->decimal_places))) * $current_currency->value;
    return number_format($price, $current_currency->decimal_places);
}
function get_display_price($input_price)
{
    $current_currency = session('current_currency');
    $price =  str_replace(',', '', number_format($input_price, $current_currency->decimal_places)) * $current_currency->value;
    if ($current_currency->direction == 'ltr') {
        return $current_currency->symbol . ' ' . number_format($price, $current_currency->decimal_places);
    } else {
        return number_format($price, $current_currency->decimal_places) . ' ' . $current_currency->symbol;
    }
}
function attachCurrencySymbol($price)
{
    $current_currency = session('current_currency');
    if ($current_currency->direction == 'ltr') {
        return $current_currency->symbol . ' ' . $price;
    } else {
        return  $price . ' ' . $current_currency->symbol;
    }
}
function attachCurrencyDecimal($price)
{
    $settings = Cache::get("general_settings");
    $current_currency = $settings['current_currency'];
    if ($current_currency->direction == 'ltr') {
        return $current_currency->symbol . ' ' .number_format(floatval($price), $current_currency->decimal_places);
    } else {
        return  number_format(floatval($price), $current_currency->decimal_places). ' ' . $current_currency->symbol;
    }
}
function get_converted_display_price($input_price)
{
    $current_currency = session('current_currency');
    $price =  floatval(str_replace(',', '', number_format($input_price, $current_currency->decimal_places)));
    if ($current_currency->direction == 'ltr') {
        return number_format($price, $current_currency->decimal_places);
    } else {
        return number_format($price, $current_currency->decimal_places);
    }
}

function get_default_price_from_converted($input_price)
{
    $current_currency = session('current_currency');
    $price =  floatval(str_replace(',', '', number_format($input_price, $current_currency->decimal_places))) / $current_currency->value;
    return number_format($price, $current_currency->decimal_places);
}
function get_price($input_price)
{
    $current_currency = session('current_currency');
    $price = floatval(str_replace(',', '', $input_price));
    $price = number_format($price, $current_currency->decimal_places);
    return $price;
}
function get_price_float($input_price)
{
    $current_currency = session('current_currency');
    $price = str_replace(',', '', $input_price);
    $price = floatval($price);
    return $price;
}
function get_current_currency_code()
{
    $current_currency = session('current_currency');
    return $current_currency->code;
}
function get_default_currency_code()
{
    $default_currency = session('default_currency');
    return $default_currency->code;
}
function get_currency_conversion_rate()
{
    $current_currency = session('current_currency');
    return $current_currency->value;
}
function get_display_price_with_currency($input_currency, $input_price)
{
    $current_currency = $input_currency;
    $price =  floatval(str_replace(',', '', number_format($input_price, $current_currency->decimal_places)));
    if ($current_currency->direction == 'ltr') {
        return $current_currency->symbol . ' ' . number_format($price, $current_currency->decimal_places);
    } else if ($current_currency->direction == 'rtl') {
        return number_format($price, $current_currency->decimal_places) . ' ' . $current_currency->symbol;
    } else {
        return number_format($price, $current_currency->decimal_places) . ' ' . $current_currency->symbol;
    }
}

function sendNotification($request)
{
    $allSettings = Setting::select('name', 'value')->pluck('value', 'name')->toArray();
    $is_notification_activated = (int)$allSettings['is_notification_activated'];
    if ($is_notification_activated) {

        $user_type = "";
        $product_ids = [];
        foreach ($request as $product) {
            array_push($product_ids, $product['product_id']);
        }
        $is_vendor = (int)$allSettings['is_multi_vendor'];
        if ($is_vendor) {
            $user_type = "vendor";
            $vendor_ids = Product::with('vendor')->whereIn('id', $product_ids)->pluck('vendor_id')->toArray();
        } else {
            $user_type = "admin";
            $vendor_ids[] = 1;
        }
        $fcm =  new FcmNotificationController();
        foreach ($vendor_ids as $id) {
            $apiData = [
                "user_id" => $id,
                "user_type" => $user_type,
                "title" => "New Order",
                "body" => "You have received a new order",
            ];
            $data = $fcm->sendPushNotification(new PushNotificationRequest($apiData));
        }
    }
}

function generateCustomBodyForPayment()
{
    $shipping =
        array(
            'id' => '',
            'first_name' => '',
            'last_name' => '',
            'email' => '',
            'city_id' => '',
            'state_id' => '',
            'country_id' => '',
            'zip_code' => '',
            'address' => '',
            'phone' => '',
        );
    return $shipping;
}
// calculate a commissions of orders

function calculateCommission($commission_type, $product_price, $rate, $rate_type, $commission_fixed_amount, $total_product_price)
{
    // commission type means that which type of commission admin sets... like commission is on sales or on categories
    // dd($commission_type, $product_price, $rate, $rate_type, $commission_fixed_amount,$total_product_price);
    if ($commission_type == 0) {    // commission type 0 is category commission and 1 is sales commission
        if ($rate_type == 1) {  //rate_type  1 means percentage
            $calculate_commission = $product_price * $rate / 100;
        } else {
            // $total_product_price += $product_price;
            if ($product_price >= $commission_fixed_amount) {
                $calculate_commission = $rate;
            } else {
                $calculate_commission = 0;
            }
        }
    }

    return $calculate_commission;
}

function UpdateCacheSettings()
{
    $general_settings = allSettings();
    Cache::put('general_settings', $general_settings);
}
