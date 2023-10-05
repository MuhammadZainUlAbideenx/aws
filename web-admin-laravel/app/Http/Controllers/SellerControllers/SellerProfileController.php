<?php

namespace App\Http\Controllers\SellerControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Http\Resources\Web\CustomerResource;
use App\Http\Requests\Vendor\VendorProfile\UpdateRequest;
use Carbon\Carbon;
use Hash;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Auth;

class SellerProfileController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
    public function __construct()
    {
      $this->middleware('auth:vendor-api');
      $this->middleware('scope:vendor');
    }
    public function updateVendorProfile (UpdateRequest $request){
      $vendor = Auth::user();
      $data = $request->except(['is_pass','password']);
      if($request->is_pass){
        $hashed_pass = Hash::make($request->password);
        $data['password'] = $hashed_pass;
      }
      $vendor = $vendor->update($data);
     return response(["message" => trans('messages.response.vendors.update_success')]);
    }



    public function updateProfileImage(Request $request)
    {
      if (!file_exists(public_path('vendors'))) {
          mkdir(public_path('vendors'), 0755, true);
      }
      if (!file_exists(public_path('vendors/profile_images'))) {
          mkdir(public_path('vendors/profile_images'), 0755, true);
      }
      $vendor = Auth::user();
      $file = $request->file('file');
      $type = $file->getMimeType();
      $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
      $filename = $vendor->name.'_'.$file->getClientOriginalName();
      $file_resize = Image::make($file->getRealPath());
      $file_resize->save(public_path('vendors/profile_images/'.$filename));
      $file_url = '/api/vendors/profile_images/'.$filename;
      if($vendor->profile_image_path){
        $old_profile_image = explode('/api',$vendor->profile_image_path);
        $old_profile_image = public_path().$old_profile_image[1];
        if(file_exists($old_profile_image)){
          unlink($old_profile_image);
        }
      }
      $vendor->update([
        'profile_image_path' => $file_url,
      ]);
        return response()->json(['profile_image_path' => $vendor->profile_image_path, 'success' => 'Your Profile image Has been Uploaded','message' => trans('messages.response.vendors.image_uploaded')], 200);
    }

}
