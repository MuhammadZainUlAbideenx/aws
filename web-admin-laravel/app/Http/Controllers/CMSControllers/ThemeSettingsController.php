<?php

namespace App\Http\Controllers\CMSControllers;

use App\Http\Controllers\Controller;
use App\Models\CMSModels\Setting;
use App\Models\CMSModels\ThemeSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ThemeSettingsController extends Controller
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
    }


    /********* Fetch Theme Settings ***********/
    public function index()
    {
        $themeSettings = ThemeSetting::get()->toArray();
        $active_template_setting = Setting::where('name','currently_active_theme')->first()->toArray();
        array_push($themeSettings,$active_template_setting);
        $arrayName = array('themeSettings' => $themeSettings);
        return response($arrayName);

    }

    /********* Update Genreral Settings ***********/
    public function update(Request $request)
    {
        if ($request->currently_active_theme) {
            Setting::where('name','currently_active_theme')->update([
                'value' => $request->currently_active_theme
              ]);
              UpdateCacheSettings();
        }
        $data = $request->except(['currently_active_theme']);
        ThemeSetting::truncate();
        foreach ($data as $key => $value) {

           $update =  ThemeSetting::create([
                'name' => $key,
                'value' => $value,
            ]);
        }


        if ($update){
            return response()->json(['message' => trans('messages.response.settings.settings_updated')], 200);
        }
        else{
            return response()->json(['message' => trans('messages.response.settings.settings_not_updated')], 200);
        }

    }
}
