<?php

namespace App\Http\Requests\CMS\Settings;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

     public function attributes(){

       $allAttributes = [];
       //media-settings
       $allAttributes['small_thumbnail_width'] = trans('messages.fields.small_thumbnail_width');
       $allAttributes['small_thumbnail_height'] = trans('messages.fields.small_thumbnail_height');
       $allAttributes['medium_thumbnail_width'] = trans('messages.fields.medium_thumbnail_width');
       $allAttributes['medium_thumbnail_height'] = trans('messages.fields.medium_thumbnail_height');
       $allAttributes['large_thumbnail_width'] = trans('messages.fields.large_thumbnail_width');
       $allAttributes['large_thumbnail_height'] = trans('messages.fields.large_thumbnail_height');
       //media-settings

       //general-settings
       $allAttributes['is_all_translations_required'] = trans('messages.fields.is_all_translations_required');
       $allAttributes['is_multi_vendor'] = trans('messages.fields.is_multi_vendor');
       $allAttributes['vendor_commission_type'] = trans('messages.fields.vendor_commission_type');
      //general-settings

       //Store-Settings
       $allAttributes['city_id'] = trans('messages.fields.city_id');
       $allAttributes['state_id'] = trans('messages.fields.state_id');
       $allAttributes['country_id'] = trans('messages.fields.country_id');
       $allAttributes['zip_code'] = trans('messages.fields.zip_code');
       $allAttributes['address'] = trans('messages.fields.address');
       $allAttributes['phone'] = trans('messages.fields.phone');
       $allAttributes['web_mode'] = trans('messages.fields.web_mode');
       $allAttributes['maintenacne_text'] = trans('messages.fields.maintenacne_text');
       $allAttributes['web_url'] = trans('messages.fields.web_url');
       $allAttributes['android_app_link'] = trans('messages.fields.android_app_link');
       $allAttributes['apple_app_link'] = trans('messages.fields.apple_app_link');
       $allAttributes['app_name'] = trans('messages.fields.app_name');
       $allAttributes['new_product_duration'] = trans('messages.fields.new_product_duration');
       $allAttributes['google_map_api'] = trans('messages.fields.google_map_api');
       $allAttributes['contact_us_email'] = trans('messages.fields.contact_us_email');
       $allAttributes['min_order_price'] = trans('messages.fields.min_order_price');
       $allAttributes['free_ship_min_price'] = trans('messages.fields.free_ship_min_price');
       $allAttributes['latitude'] = trans('messages.fields.latitude');
       $allAttributes['longitude'] = trans('messages.fields.longitude');
       //Store-Settings

      //facebook_settings
      $allAttributes['facebook_login_is_active'] = trans('messages.fields.facebook_login_is_active');
      $allAttributes['facebook_app_url'] = trans('messages.fields.facebook_app_url');
      $allAttributes['facebook_app_id'] = trans('messages.fields.facebook_app_id');
      $allAttributes['facebook_secret'] = trans('messages.fields.facebook_secret');
      //facebook_settings

      //google_settings
      $allAttributes['google_login_is_active'] = trans('messages.fields.google_login_is_active');
      $allAttributes['google_app_url'] = trans('messages.fields.google_app_url');
      $allAttributes['google_app_id'] = trans('messages.fields.google_app_id');
      $allAttributes['google_secret'] = trans('messages.fields.google_secret');
      //google_settings

      //alert_settings
      $allAttributes['contact_us_send_email'] = trans('messages.fields.contact_us_send_email');
      $allAttributes['adding_news_send_notification'] = trans('messages.fields.adding_news_send_notification');
      $allAttributes['adding_news_send_email'] = trans('messages.fields.adding_news_send_email');
      $allAttributes['forgot_password_send_notification'] = trans('messages.fields.forgot_password_send_notification');
      $allAttributes['forgot_password_send_email'] = trans('messages.fields.forgot_password_send_email');
      $allAttributes['new_product_send_notification'] = trans('messages.fields.new_product_send_notification');
      $allAttributes['new_product_send_email'] = trans('messages.fields.new_product_send_email');
      $allAttributes['customer_welcome_send_email'] = trans('messages.fields.customer_welcome_send_email');
      $allAttributes['customer_welcome_send_notification'] = trans('messages.fields.customer_welcome_send_notification');
      $allAttributes['order_send_email'] = trans('messages.fields.order_send_email');
      $allAttributes['order_send_notification'] = trans('messages.fields.order_send_notification');
      $allAttributes['order_status_send_email'] = trans('messages.fields.order_status_send_email');
      $allAttributes['order_status_send_notification'] = trans('messages.fields.order_status_send_notification');
      $allAttributes['contact_address'] = trans('messages.fields.contact_address');
      $allAttributes['contact_phone'] = trans('messages.fields.contact_phone');
      $allAttributes['contact_email'] = trans('messages.fields.contact_email');

      //alert_settings

      //api_protection_settings
      $allAttributes['consumer_key'] = trans('messages.fields.consumer_key');
      $allAttributes['consumer_secret'] = trans('messages.fields.consumer_secret');
      //api_protection_settings

       // Single Lang Attribute Names
       return $allAttributes;
     }

    public function rules()
    {
      if($this->settings == 'media_settings'){
        return [
          'small_thumbnail_width' => 'required|numeric|min:50|lt:medium_thumbnail_width',
          'small_thumbnail_height' => 'required|numeric|min:50|lt:medium_thumbnail_width',
          'medium_thumbnail_width' => 'required|numeric|min:50|lt:large_thumbnail_width',
          'medium_thumbnail_height' => 'required|numeric|min:50|lt:large_thumbnail_width',
          'large_thumbnail_width' => 'required|numeric|min:50',
          'large_thumbnail_height' => 'required|numeric|min:50',
        ];
      }
      else if($this->settings == 'general_settings'){
          return [
            'is_all_translations_required' => 'required|boolean',
            'is_multi_vendor' => 'required|boolean',
            'timezone' => 'timezone',
            'vendor_commission_type' => 'required_if:is_multi_vendor,1',
          ];
      }
      else if($this->settings == 'store_settings'){
          return [
            'city_id' => 'required|exists:cities,id',
            'state_id' => 'required|exists:states,id',
            'country_id' => 'required|exists:countries,id',
            'zip_code' => 'required|numeric',
            'address' => 'required|string|max:255',
            'phone' => 'required|numeric',
            'web_mode' => 'required|string|max:255',
            'maintenance_text' => 'required|string|max:255',
            'web_url' => 'nullable|url',
            'android_app_link' => 'nullable|url',
            'apple_app_link' => 'nullable|url',
            'app_name' => 'required|string|max:255',
            'new_product_duration' => 'required|numeric',
            'google_map_api' => 'string|max:255',
            'contact_us_email' => 'required|email',
            'order_email' => 'required|email',
            'min_order_price' => 'required|numeric',
            'free_ship_min_price' => 'required|numeric',
            'latitude' => 'string|max:255',
            'longitude' => 'string|max:255',
          ];
      }
      else if($this->settings == 'facebook_settings'){
          return [
            'facebook_login_is_active' => 'required|bool',
            //'facebook_app_url' => 'required_if:facebook_login_is_active,1|url',
            'facebook_app_id' => 'required_if:facebook_login_is_active,1|string|nullable',
            'facebook_secret' => 'required_if:facebook_login_is_active,1|string|nullable',
          ];
      }
      else if($this->settings == 'google_settings'){
          return [
            'google_login_is_active' => 'required|bool',
            //'google_app_url' => 'required_if:google_login_is_active,1|url',
            'google_app_id' => 'required_if:google_login_is_active,1|string|nullable',
            'google_secret' => 'required_if:google_login_is_active,1|string|nullable',
          ];
      }
      else if($this->settings == 'apple_settings'){
          return [
            'apple_login_is_active' => 'required|bool',
            //'apple_app_url' => 'required_if:apple_login_is_active,1|url',
            'apple_client_id' => 'required_if:apple_login_is_active,1|string|nullable',
            'apple_client_secret' => 'required_if:apple_login_is_active,1|string|nullable',
          ];
      }
      else if($this->settings == 'alert_settings'){
          return [
            'contact_us_send_email' => 'required|bool',
            'adding_news_send_notification' => 'required|bool',
            'adding_news_send_email' => 'required|bool',
            'forgot_password_send_notification' => 'required|bool',
            'forgot_password_send_email' => 'required|bool',
            'new_product_send_notification' => 'required|bool',
            'new_product_send_email' => 'required|bool',
            'customer_welcome_send_email' => 'required|bool',
            'customer_welcome_send_notification' => 'required|bool',
            'order_send_email' => 'required|bool',
            'order_send_notification' => 'required|bool',
            'order_status_send_email' => 'required|bool',
            'order_status_send_notification' => 'required|bool',
          ];
      }
      else if($this->settings == 'api_protection_settings'){
          return [
            'consumer_key' => 'required|string',
            'consumer_secret' => 'required|string',
          ];
      }
      else if($this->settings == 'main_settings'){
          return [
            'name_or_logo' => 'required',
            'web_name' => 'required|string',
            'contact_address' => 'required|string',
            'contact_number' => 'required',
            'contact_email' => 'required|email',
            'web_logo_image_id' => 'required|exists:media,id',
            'fav_icon_image_id' => 'required|exists:media,id',
          ];
      }

    }
}
