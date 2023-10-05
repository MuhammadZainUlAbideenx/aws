<?php

namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use App\Models\CMSModels\Setting;
use App\Models\CMSModels\Product;
use App\Models\Vendor;
use App\Models\VendorStore;
use App\Models\CMSModels\CommissionCategory;
use App\Models\CMSModels\CommissionSale;
use App\Http\Requests\CMS\Settings\CreateRequest;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\MediaDetail;
use App\Http\Resources\CMS\MediaResource;
use App\Models\CMSModels\Currency;
use Intervention\Image\ImageManagerStatic as Image;
use FFMpeg;
use Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\App;

class SettingsController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
  if (auth('vendor-api')->check() && auth('vendor-api')->user()->tokenCan('vendor')) {
        $this->middleware('auth:vendor-api');
        $this->guard = 'vendor';
    } elseif (auth('admin-api')->check() && auth('admin-api')->user()->tokenCan('admin')) {
        $this->middleware('auth:admin-api');
        $this->guard = 'admin';
    } else {
    }
    //   $this->middleware('permission:settings.index,guard:api');
    //   $this->middleware('permission:settings.update,guard:api',['only' => ['updateGeneralSettings']]);
    //   $this->middleware('permission:media_settings.update,guard:api',['only' => ['updateMediaSettings']]);

  }

  /********* FETCH ALL Categories ***********/
    public function index()
    {
        $default_currency = Currency::where('is_default',1)->first();
        $current_currency = $default_currency;
        $specificSettings = Setting::where('is_specific',1)->select('name','value')->pluck('value','name')->toArray();
        $generalSettings = Setting::where('is_specific',0)->select('name','value')->pluck('value','name')->toArray();
        $allSettings = Setting::select('name','value')->pluck('value','name')->toArray();
        $settings= [];
        $settings['specificSettings'] = $specificSettings;
        $settings['generalSettings'] = $generalSettings;
        $settings['current_currency'] = $current_currency->symbol;
        $favicon = Media::find($specificSettings['fav_icon_image_id']);
        $loader =  Media::find($specificSettings['web_loader_image_id']);
        $logo =  Media::find($specificSettings['web_logo_image_id']);
        $logo_dark=  Media::find($specificSettings['web_dark_logo_image_id']);
        if($favicon){
          $settings['media']['favicon'] = new MediaResource($favicon);
        }
        if($logo){
          $settings['media']['logo'] = new MediaResource($logo);
        }
        if($loader){
            $settings['media']['loader'] = new MediaResource($loader);
          }
        if($logo_dark){
            $settings['media']['logo_dark'] = new MediaResource($logo_dark);
          }
        $settings['settings'] = $allSettings;
        $settings['environment'] = App::environment();
        $settings = array('settings' => $settings,'fetched' => true);
        $arrayName = array('settings' => $settings);
        return response($arrayName);
    }

    /********* ADD OR UPDATE SETTINGS ***********/
    public function store(CreateRequest $request)
    {
      //previous settings
      if($request->settings == 'media_settings'){
        return $this->updateMediaSettings($request);
      }
      else if($request->settings == 'general_settings'){
        return $this->updateGeneralSettings($request);
      }
      else if($request->settings == 'store_settings'){
        return $this->updateStoreSettings($request);
      }
      else if($request->settings == 'facebook_settings'){
        return $this->updateFacebookSettings($request);
      }
      else if($request->settings == 'google_settings'){
        return $this->updateGoogleSettings($request);
      }
      else if($request->settings == 'apple_settings'){
        return $this->updateAppleSettings($request);
      }
      else if($request->settings == 'alert_settings'){
        return $this->updateAlertSettings($request);
      }
      else if($request->settings == 'api_protection_settings'){
        return $this->updateApiProtectionSettingsSettings($request);
      }
      else if($request->settings == 'main_settings'){
        return $this->updateMainSettings($request);
      }
    }
    /********* Update Genreral Settings ***********/
    public function updateGeneralSettings($request){
      $allSettings = allSettings();
      $data = $request->except(['settings']);
      foreach ($data as $key => $value) {
        if($key == 'is_multi_vendor' && (int)$allSettings['is_multi_vendor'] != (int)$value){
          $products = Product::get();
          if((int)$value == 1){
            foreach ($products as $product) {
              $product->categories()->detach();
              $product->media()->detach();
              $product->flash_sale()->delete();
              $product->special_sale()->delete();
              $product->delete();
            }
            Vendor::where('id','!=',1)->delete();
            VendorStore::where('id','!=',1)->delete();
          }
          else if((int)$value == 0){
            //empty Commssions data
            CommissionSale::truncate();
            CommissionCategory::truncate();
            //empty Commssions data
            VendorStore::where('id','!=',1)->delete();
            $vendors = Vendor::where('id','!=',1)->get();
            foreach ($vendors as $vendor) {
              $vendor->categories()->detach();
              $vendor->delete();
            }
            foreach ($products as $product) {
                $product->vendor_id = 1;
                $product->save();
            }
          }

        }
        $updated_settings = Setting::where('name',$key)->updateOrCreate([
          'name' => $key
        ],[
          'name' => $key,
          'value' => $value
        ]);
        UpdateCacheSettings();
      }
      Artisan::call('cache:clear');
      Artisan::call('config:cache');
      if($data['environment'] != App::environment()){
        if($data['environment'] == 'local' || $data['environment'] == 'development'){
          $this->changeEnv(['APP_ENV' => $data['environment'],'APP_DEBUG' => 'true']);
        }
        else if($data['environment'] == 'production'){
          $this->changeEnv(['APP_ENV' => $data['environment'],'APP_DEBUG' => 'false']);
        }
        else{

        }
      return response()->json(['message' => trans('messages.response.settings.settings_updated')], 200);
    }
    return response()->json(['message' => trans('messages.response.settings.settings_updated')], 200);
  }
protected function changeEnv($data = array()){
    if(count($data) > 0){
        $env = file_get_contents(base_path() . '/.env');
        $env = preg_split('/\s+/', $env);;
        foreach((array)$data as $key => $value){
            foreach($env as $env_key => $env_value){
                $entry = explode("=", $env_value, 2);

                if($entry[0] == $key){
                    $env[$env_key] = $key . "=" . $value;
                } else {
                    $env[$env_key] = $env_value;
                }
            }
        }
        $env = implode("\n", $env);
        file_put_contents(base_path() . '/.env', $env);
        return true;
    } else {
        return false;
    }
}
    /********* Update media Settings ***********/
    public function updateMediaSettings($request){
      $data = $request->except(['settings','regenerate']);
      foreach ($data as $key => $value) {
        Setting::where('name',$key)->update([
          'value' => $value
        ]);
      }
      if($request->regenerate){
        $this->regenerate();
        return response()->json(['message' =>  trans('messages.response.settings.settings_updated_with_all_thumbnails')], 200);
      }
      return response()->json(['message' => trans('messages.response.settings.settings_updated')], 200);
    }
    /********* Regenerate Thumbnails ***********/
    public function regenerate()
    {
      $allMedia = Media::get();
      foreach ($allMedia as $media) {
        foreach ($media->thumbnails as $thumbnail) {
          $path = explode('/api',$thumbnail->thumbnail);
          $file_path = public_path().$path[1];
          if(file_exists($file_path)){
            unlink($file_path);
          }
        }
        $media->thumbnails()->delete();
        if($media->type == 'video'){
          $type = 'video';
          $path = explode('/api',$media->original_media_path);
          $contents = FFMpeg::fromDisk('direct_public')->open($path[1])
                ->getFrameFromSeconds(2)
                ->export()
                ->getFrameContents();
          $image = Image::make($contents);
          $media->generateThumbnails($image);
        }
        else if($media->type == 'image'){
          $type = 'image';
          $path = explode('/api',$media->original_media_path);
          if(File::exists(public_path($path[1]))){
            $image = Image::make(public_path($path[1]));
            $media->generateThumbnails($image);
          }
        }
      }
    }
    public function updateStoreSettings($request){
      $data = $request->except(['settings']);
      foreach ($data as $key => $value) {
        Setting::where('name',$key)->update([
          'name' => $key,
          'value' => $value,
        ]);
      }
      return response()->json(['message' => trans('messages.response.settings.store_settings_updated')], 200);
    }
    public function updateFacebookSettings($request){
      $data = $request->except(['settings']);
      foreach ($data as $key => $value) {
        Setting::where('name',$key)->update([
          'name' => $key,
          'value' => $value,
        ]);
      }
      return response()->json(['message' =>  trans('messages.response.settings.facebook_settings_updated')], 200);
    }
    public function updateGoogleSettings($request){
      $data = $request->except(['settings']);
      foreach ($data as $key => $value) {
        Setting::where('name',$key)->update([
          'name' => $key,
          'value' => $value,
        ]);
      }
      return response()->json(['message' =>  trans('messages.response.settings.google_settings_updated')], 200);
    }
    public function updateAlertSettings($request){
      $data = $request->except(['settings']);
      foreach ($data as $key => $value) {
        Setting::where('name',$key)->update([
          'name' => $key,
          'value' => $value,
        ]);
      }
      return response()->json(['message' =>  trans('messages.response.settings.alert_settings_updated')], 200);
    }
    public function updateApiProtectionSettingsSettings($request){
      $data = $request->except(['settings']);
      foreach ($data as $key => $value) {
        Setting::where('name',$key)->update([
          'name' => $key,
          'value' => $value
        ]);
      }
      return response()->json(['message' =>  trans('messages.response.settings.apiprotection_settings_updated')], 200);
    }
    public function updateAppleSettings($request){
      $data = $request->except(['settings']);
      foreach ($data as $key => $value) {
        Setting::where('name',$key)->update([
          'name' => $key,
          'value' => $value,
        ]);
      }
      return response()->json(['message' => trans('messages.response.settings.apple_settings_updated')], 200);
    }
    public function updateMainSettings($request){
      $data = $request->except(['settings']);
      foreach ($data as $key => $value) {
        if ($key == 'fav_icon_image_id'){
            $image = Media::where('id', $value)->first();
            $file = $image->original_media_path;
            if ($image && $file){
            $file = explode('/api'.'/',$file);
            $file = $file[1];
            $contents = file_get_contents(public_path($file));
            file_put_contents(public_path('favicon.png'),$contents);
        }
    }
        Setting::where('name',$key)->update([
          'name' => $key,
          'value' => $value,
        ]);
      }
      return response()->json(['message' => trans('messages.response.settings.main_settings_updated')], 200);
    }

}
