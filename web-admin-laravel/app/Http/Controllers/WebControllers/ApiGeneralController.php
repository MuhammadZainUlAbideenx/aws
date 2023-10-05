<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\validateShippingAddressRequest\validateShippingAddressRequest;
use App\Http\Resources\CMS\OrderStatusesResource;
use App\Http\Resources\Web\CategoriesResource;
use Illuminate\Http\Request;
use App\Models\CMSModels\Language;
use App\Http\Resources\Web\LanguagesResource;
use App\Models\CMSModels\Currency;
use App\Http\Resources\Web\CurrenciesResource;
use App\Models\CMSModels\Setting;
use App\Http\Resources\Web\CouponsResource;
use App\Http\Resources\Web\MediaResource;
use App\Models\CMSModels\Media;
use Illuminate\Support\Facades\App;
use App\Models\CMSModels\ShippingMethod;
use App\Http\Resources\Web\ShippingMethodsResource;
use App\Models\CMSModels\Cart;
use App\Models\CMSModels\Category;
use App\Models\CMSModels\Coupon;
use App\Models\CMSModels\Order;
use App\Models\CMSModels\OrderStatus;
use App\Models\CMSModels\Product;
use App\Models\CMSModels\ProductVariant;
use App\Models\CMSModels\RiderShipping;
use App\Models\CMSModels\SeoPage;
use App\Models\CMSModels\ThemeSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;

class ApiGeneralController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
    public function __construct()
    {
    }
    public function applicationDefaultSettings()
    {
        // Default Language
        $language = Language::where('is_default', 1)->first();
        $language = new LanguagesResource($language);
        // default Currency
        $currency = Currency::where('is_default', 1)->first();
        $currency = new CurrenciesResource($currency);
        $rider_shipping = ShippingMethod::where('id', 6)->first();
        $theme_settings = ThemeSetting::get();
        $rider_shipping = $rider_shipping->is_default;
        //pages design settings
        $allSettings = Setting::select('name', 'value')->pluck('value', 'name')->toArray();
        $theme = [];
        $theme['home_page'] = $allSettings['application_home_page'] ? (int)$allSettings['application_home_page'] : 1;
        $theme['shop_page'] = $allSettings['application_shop_page'] ? (int)$allSettings['application_shop_page'] : 1;
        $theme['product_page'] = $allSettings['application_product_page'] ? (int)$allSettings['application_product_page'] : 1;
        $theme['checkout_page'] = $allSettings['application_checkout_page'] ? (int)$allSettings['application_checkout_page'] : 1;
        //application settings
        $application = [];
        $application['is_multi_vendor'] = $allSettings['application_home_page'] ? (int)$allSettings['is_multi_vendor'] : 1;
        $application['environment'] = App::environment();
        $application['is_notification_activated'] = (int)$allSettings['is_notification_activated'];
        $application['is_chat_enabled'] = (int)$allSettings['is_chat_enabled'];
        $application['is_web_chat_enabled'] = (int)$allSettings['is_web_chat_enabled'];
        $application['zendesk_api_key'] = $allSettings['zendesk_api_key'];
        $application['is_rider_shipping'] =  $rider_shipping;
        // generate and send response
        $arr = ['language' => $language, 'currency' => $currency, 'theme' => $theme, 'general_settings' => $application, "theme_settings" => $theme_settings];
        $response = generateResponse($arr, true, '', [], 'collection');
        return response($response);
    }
    public function websiteDefaultSettings()
    {
        // Default Language
        $language = Language::where('is_default', 1)->first();
        $language = new LanguagesResource($language);
        $currency = Currency::where('is_default', 1)->first();
        $currency = new CurrenciesResource($currency);
        $rider_shipping = ShippingMethod::where('id', 6)->first();
        $rider_shipping = $rider_shipping->is_default;
        $allSettings = Setting::select('name', 'value')->pluck('value', 'name')->toArray();
        $theme_settings = ThemeSetting::get();
        $loader = Media::withAll()->find((int)$allSettings['web_loader_image_id']);
        if ($loader) {
            $loader = new MediaResource($loader);
        } else {
            $loader = null;
        }
        $logo = Media::withAll()->find((int)$allSettings['web_logo_image_id']);
        if ($logo) {
            $logo = new MediaResource($logo);
        } else {
            $logo = null;
        }
        $logo_dark = Media::withAll()->find((int)$allSettings['web_dark_logo_image_id']);
        if ($logo_dark) {
            $logo_dark = new MediaResource($logo_dark);
        } else {
            $logo_dark = null;
        }
        $web_name = $allSettings['web_name'];
        $name_or_logo = $allSettings['name_or_logo'];
        $contact_number = $allSettings['contact_number'];

        $website = [];
        $website['is_multi_vendor'] = isset($allSettings['is_multi_vendor']) ? (int)$allSettings['is_multi_vendor'] : 1;
        $website['environment'] = App::environment();
        $website['logo'] = $logo;
        $website['loader'] = $loader;
        $website['logo_dark'] = $logo_dark;
        $website['web_name'] = $web_name;
        $website['name_or_logo'] = $name_or_logo;
        $website['contact_number'] = $contact_number;
        $website['facebook_url'] = $allSettings['facebook_url'];
        $website['twitter_url'] = $allSettings['twitter_url'];
        $website['linked_in_url'] = $allSettings['linked_in_url'];
        $website['instagram_url'] = $allSettings['instagram_url'];
        $website['contact_map'] = $allSettings['contact_map'];
        $website['copyright_text'] = $allSettings['copyright_text'];
        $website['contact_address'] = $allSettings['contact_address'];
        $website['contact_email'] = $allSettings['contact_email'];
        $website['is_notification_activated'] = (int)$allSettings['is_notification_activated'];
        $website['is_chat_enabled'] = (int)$allSettings['is_chat_enabled'];
        $website['is_web_chat_enabled'] = (int)$allSettings['is_web_chat_enabled'];
        $website['zendesk_api_key'] = $allSettings['zendesk_api_key'];
        $website['currently_active_theme'] = $allSettings['currently_active_theme'];
        $website['is_rider_shipping'] = $rider_shipping;


        $seo = SeoPage::where('static_page_id', '!=', null)->get()->keyBy('static_page_id')->map(function ($item, $key) {
            return  [
                'title' => $item['title'],
                'description' => $item['description'],
                'meta_tags' =>  $item['meta_tags'],
                'keywords' => $item['keywords']
            ];
        });
        // generate and send response
        $arr = ['language' => $language, 'currency' => $currency, 'general_settings' => $website,'theme_settings' => $theme_settings, 'seo' => $seo];
        $response = generateResponse($arr, true, '', [], 'collection');
        return response($response);
    }
    public function environment()
    {
        $arrayName = array('environment' => App::environment());
        return response($arrayName);
    }
    // Languages
    public function allLanguages()
    {
        $languages = Language::where('is_active', 1)->OrderBY('is_default', 'DESC')->get();
        $languages = LanguagesResource::collection($languages);
        $response = generateResponse($languages, count($languages) > 0 ? true : false, '', [], 'collection');
        return response($response);
    }
    // Currencies
    public function allCurrencies()
    {
        $currencies = Currency::where('is_active', 1)->OrderBY('is_default', 'DESC')->get();
        $currencies = CurrenciesResource::collection($currencies);
        $response = generateResponse($currencies, count($currencies) > 0 ? true : false, '', [], 'collection');
        return response($response);
    }
    // Settings
    public function allSettings()
    {
        $allSettings = Setting::select('name', 'value')->pluck('value', 'name')->toArray();
        $allSettings['environment'] = App::environment();
        $response = generateResponse($allSettings, count($allSettings) > 0 ? true : false, '', [], 'collection');
        return response($response);
    }
    public function allShippingMethods()
    {
        $shipping_methods = ShippingMethod::where('is_active', 1)->get();
        $shipping_methods = ShippingMethodsResource::collection($shipping_methods);
        $response = generateResponse($shipping_methods, count($shipping_methods) > 0 ? true : false, '', [], 'collection');
        return response($response);
    }

    public function orderTracking(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_number' => 'required',
        ]);
        if ($validator->fails()) {
            $response = generateResponse('', false, '', $validator->errors(), 'object');
            return $response;
        }
        $order = Order::where('order_number', $request->order_number)->first();
        $status = OrderStatus::where('status_code', $order->order_status_id)->first();
        // dd($status);
        if ($order) {
            $order = new OrderStatusesResource($status);
            $message = trans('messages.response.web.order_found');
            $response = generateResponse($order, true, $message, [], 'collection');
            return $response;
        } else {
            $message = trans('messages.response.web.order_not_found');
            $response = generateResponse($order, true, $message, [], 'collection');
            return $response;
        }
    }

    public function allCoupons()
    {
        $coupons = Coupon::where('is_active', 1)->where('is_featured', 1)->where('expiry_date', '>=', Carbon::now()->toISOString())->orderBy('id', 'desc')->get()->take(4);
        $coupons = CouponsResource::collection($coupons)->response()->getData(true);
        return $coupons;
    }

    public function FeaturedCategories()
    {
        $featured_categories = Category::with('image')->where('parent_id', 0)->where('is_active', 1)->where('is_featured', 1)->get()->take(5);

        foreach ($featured_categories as $key => $category) {
            $simple_product_ids = $category->products()->where('product_type', 1)->pluck('products.id')->toArray();
            $variable_product_ids = $category->products()->where('product_type', 2)->pluck('products.id')->toArray();
            $min_simple_price = Product::whereIn('id', $simple_product_ids)->min('price');
            $min_variable_price = ProductVariant::whereIn('product_id', $variable_product_ids)->min('price');
            if ($min_simple_price && $min_variable_price) {
                $category->min_price = $min_simple_price < $min_variable_price ? ($min_simple_price ?? 0) : ($min_variable_price ?? 0);
            } elseif ($min_simple_price && !$min_variable_price) {
                $category->min_price = $min_simple_price ?? 0;
            } else {
                $category->min_price = $min_variable_price ?? 0;
            }
        }

        $featured_categories = CategoriesResource::collection($featured_categories)->response()->getData(true);
        return $featured_categories;
    }
    public function validateAndCalculateShipping(validateShippingAddressRequest $request)
    {
        $allShippingMethods = ShippingMethod::with('settings')->where('is_active', 1)->get();

        $settings = Cache::get("general_settings");
        $is_multi_vendor = (int)$settings['is_multi_vendor'];
        if (auth('customer-api')->check() && auth('customer-api')->user()->tokenCan('customer')) {
            $customer = auth('customer-api')->user();
            $cart_items = $customer->cartItems()->where('is_ordered', 0)->get();
        } else {
            $session_token = $request->cookie('session_token');
            $cart_items = Cart::withAll()->where('session_token', $session_token)->get();
        }

        if ($is_multi_vendor == 0) {

            foreach ($allShippingMethods as $key => $shippingMethod) {
                if ($shippingMethod->id == 2) {
                    // free shipping
                    $data[$key]['shipping_value'] =  0;
                    $data[$key]['shipping_id'] =  $shippingMethod->id;
                }
                if ($shippingMethod->id == 3) {
                    // local pickup  shipping
                    $data[$key]['shipping_value'] =  0;
                    $data[$key]['shipping_id'] =  $shippingMethod->id;
                }
                if ($shippingMethod->id == 6) {
                    $total = 0;
                    // shipping by rider
                    foreach ($cart_items as $cart) {
                        $vendor_id = $cart->product->vendor_id;
                        $riderCommission = RiderShipping::where('vendor_id', $vendor_id)->first();


                        if ($riderCommission) {
                            $commission_type =  $riderCommission->commission_type;
                            $commission_rate =  $riderCommission->commission_rate;

                            if ($commission_type == 0) {
                                // percentage commission
                                if ($cart->product_id == $cart->product->id) {
                                    $qty = $cart->quantity;
                                    if ($cart->variant != null) {
                                        $variant = $cart->variant;
                                        foreach ($cart->product->variants as $product_variant) {
                                            if ($variant ==  $product_variant->variant) {
                                                $total += $product_variant->price * $qty;
                                            }
                                        }
                                    } else {
                                        if ($cart->product->special_sale && $cart->product->special_sale->is_active == 1) {
                                            $total += $cart->product->special_sale->special_price * $qty;
                                        } else if ($cart->product->flash_sale && $cart->product->flash_sale->is_active == 1) {
                                            $total += $cart->product->flash_sale->product_price * $qty;
                                        } else {
                                            $total += $cart->product->price * $qty;
                                        }
                                    }
                                }
                            }
                            if ($commission_type == 1) {
                                // fixed commission
                                $data[$key]['shipping_value'] = $commission_rate;
                                $data[$key]['shipping_id'] = $shippingMethod->id;
                            }
                        }
                    }
                    // calculating the percentage of products total for rider shipping
                    if ($riderCommission) {
                        if ($commission_type == 0) {
                            // percentage commission
                            $percentage_amt = $total / 100 * $riderCommission->commission_rate;
                            $data[$key]['shipping_value'] = number_format((float)$percentage_amt, 2, '.', '');
                            $data[$key]['shipping_id'] = $shippingMethod->id;
                        }
                    }
                }
                foreach ($shippingMethod->settings as $shippingMethodSetting) {
                    if ($shippingMethodSetting->shipping_method_id == 1) {
                        // fixed shipping
                        if ($shippingMethodSetting->name == 'rate') {
                            $data[$key]['shipping_value'] =  $shippingMethodSetting->value;
                            $data[$key]['shipping_id'] =  $shippingMethodSetting->shipping_method_id;
                        }
                    }

                    if ($shippingMethodSetting->shipping_method_id == 5) {
                        // shipping by weight
                        if ($shippingMethodSetting->name == 'rate') {
                            $weightValue = $shippingMethodSetting->value;
                            $data[$key]['shipping_value'] = 0;
                            $data[$key]['shipping_id'] = $shippingMethodSetting->shipping_method_id;
                            foreach ($cart_items as $cart) {
                                $productWeight = $cart->product->shipping_weight * $cart->quantity;
                                $data[$key]['shipping_value'] += $productWeight * $weightValue;
                            }
                        }
                    }
                }
            }
        }
        if ($is_multi_vendor == 1) {

            foreach ($allShippingMethods as $key => $shippingMethod) {
                if ($shippingMethod->id == 2) {
                    // free shipping
                    $data[$key]['shipping_value'] =  0;
                    $data[$key]['shipping_id'] =  $shippingMethod->id;
                }
                if ($shippingMethod->id == 3) {
                    // local pickup  shipping
                    $data[$key]['shipping_value'] =  0;
                    $data[$key]['shipping_id'] =  $shippingMethod->id;
                }
                if ($shippingMethod->id == 6) {
                    $total_commission_rate = 0;
                    $total_commission_percentage = 0;
                    $vendor_ids = array();
                    // shipping by rider
                    foreach ($cart_items as $cart) {
                        $vendor_ids[] = $cart->product->vendor_id;
                    }
                    $vendor_ids = (array_unique($vendor_ids));
                    foreach ($vendor_ids as $vendor_id) {
                        $riderCommission = RiderShipping::where('vendor_id', $vendor_id)->first();


                        if ($riderCommission) {
                            $commission_type =  $riderCommission->commission_type;
                            $commission_rate =  $riderCommission->commission_rate;

                            if ($commission_type == 0) {
                                // percentage commission
                                foreach ($cart_items as $cart) {

                                    if ($vendor_id == $cart->product->vendor_id) {
                                        $qty = $cart->quantity;
                                        if ($cart->variant != null) {

                                            $variant = $cart->variant;
                                            foreach ($cart->product->variants as $product_variant) {
                                                if ($variant ==  $product_variant->variant) {
                                                    $total = $product_variant->price * $qty;
                                                    $total_commission_percentage += $total / 100 * $riderCommission->commission_rate;
                                                }
                                            }
                                        } else {

                                            if ($cart->product->special_sale && $cart->product->special_sale->is_active == 1) {

                                                $total = $cart->product->special_sale->special_price * $qty;
                                                $percentage = $total / 100 * $riderCommission->commission_rate;
                                            } else if ($cart->product->flash_sale && $cart->product->flash_sale->is_active == 1) {

                                                $total = $cart->product->flash_sale->product_price * $qty;
                                                $percentage = $total / 100 * $riderCommission->commission_rate;
                                            } else {

                                                $total = $cart->product->price * $qty;

                                                $percentage = $total / 100 * $riderCommission->commission_rate;
                                            }

                                            $total_commission_percentage = $total_commission_percentage + $percentage;
                                        }
                                    }
                                }
                            }
                            if ($commission_type == 1) {
                                // fixed commission
                                $commission = $commission_rate;
                                $total_commission_rate = $total_commission_rate + $commission;
                            }
                        }
                    }



                    $percentage_amt = $total_commission_percentage + $total_commission_rate;
                    $data[$key]['shipping_value'] = number_format((float)$percentage_amt, 2, '.', '');
                    $data[$key]['shipping_id'] = $shippingMethod->id;
                }
                foreach ($shippingMethod->settings as $shippingMethodSetting) {
                    if ($shippingMethodSetting->shipping_method_id == 1) {
                        // fixed shipping
                        if ($shippingMethodSetting->name == 'rate') {
                            $count_vendor = array();
                            foreach ($cart_items as $cart) {
                                $vendor_ids = $cart->product->vendor_id;
                                array_push($count_vendor, $vendor_ids);
                            }
                            $vendors = count(array_unique($count_vendor));
                            $data[$key]['shipping_value'] =  $shippingMethodSetting->value * $vendors;
                            $data[$key]['shipping_id'] =  $shippingMethodSetting->shipping_method_id;
                        }
                    }

                    if ($shippingMethodSetting->shipping_method_id == 5) {
                        // shipping by weight
                        if ($shippingMethodSetting->name == 'rate') {
                            $weightValue = $shippingMethodSetting->value;

                            $data[$key]['shipping_value'] = 0;
                            $data[$key]['shipping_id'] = $shippingMethodSetting->shipping_method_id;
                            foreach ($cart_items as $cart) {
                                $productWeight = $cart->product->shipping_weight * $cart->quantity;
                                $data[$key]['shipping_value'] += $productWeight * $weightValue;
                            }
                        }
                    }
                }
            }
        }
        $new_data = [];
        if (isset($data)) {
            foreach ($data as $key => $d) {
                $old = $d;
                unset($data[$key]);
                array_push($new_data, $old);
            }
        }

        return response()->json(['data' => $new_data, 'state' => 'success']);
    }

}
