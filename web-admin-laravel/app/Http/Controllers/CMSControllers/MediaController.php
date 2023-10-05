<?php

namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\CMS\Media\CreateRequest;
use App\Http\Resources\CMS\ThumbnailResource;
use App\Http\Resources\CMS\MediaResource;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\MediaDetail;
use Intervention\Image\ImageManagerStatic as Image;
use FFMpeg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MediaController extends Controller
{
    public $guard;
  /********* Middlewares Initializations ***********/
  public function __construct(){
    // $this->middleware('auth:api');
    if (auth('customer-api')->check() && auth('customer-api')->user()->tokenCan('customer')) {
        $this->guard = 'customer-api';
    } elseif (auth('rider-api')->check() && auth('rider-api')->user()->tokenCan('rider')) {
        $this->guard = 'rider-api';
    } elseif (auth('vendor-api')->check() && auth('vendor-api')->user()->tokenCan('vendor')) {
        $this->guard = 'vendor-api';
    } elseif (auth('admin-api')->check() && auth('admin-api')->user()->tokenCan('admin')) {
        $this->guard = 'admin-api';
    } else {
    }
  }

  /********* Getter for getting all Pictures Thumbnails aor Getting single media with Defferent Id  ***********/
  public function getter($id = '',$req = null)
    {
        $user = auth($this->guard)->user();
        $user_type = $user->role->name;
        $user_id = $user->id;
       if($id != ''){
         $media = new Media;
         $media = $media->withAll()->orderBy('id','desc')->where('id',$id)->where('user_type',$user_type)->where('user_id',$user_id)->first();
         $media = new MediaResource($media);
         return $media;
       }
       else if($req != null && $req->search && $req->search != null){
            $media = Media::where('user_type',$user_type)->where('user_id',$user_id)->withAll();
            $media = $media->whereLike('name',$req->search);
            $media = $media->paginate(29);
            $media = MediaResource::collection($media)->response()->getData(true);
            return $media;
        }
       else{
        //$media = MediaDetail::where('thumbnail_type','small')->get();
        $media = Media::where('user_type',$user_type)->where('user_id',$user_id)->withAll()->orderBy('id','desc')->paginate(29);
        $media = MediaResource::collection($media)->response()->getData(true);
        //$media = ThumbnailResource::collection($media);
        return $media;
       }
    }

  /********* FETCH ALL Media Or Single Media ***********/
    public function fetchMedia($id = '')
    {
       $allMedia = $this->getter($id);
       $response = array('msg'=>'success','media' => $allMedia);
       return response()->json($response);
    }

    /********* Add New Media and Generate Thumbnails ***********/
    public function addMedia(CreateRequest $request)
    {
      if (!file_exists(public_path('media/image'))) {
          mkdir(public_path('media/image'), 0755, true);
      }
      if (!file_exists(public_path('media/image/thumbnails'))) {
          mkdir(public_path('media/image/thumbnails'), 0755, true);
      }
      if (!file_exists(public_path('media/video'))) {
          mkdir(public_path('media/video'), 0755, true);
      }
      if (!file_exists(public_path('media/video/thumbnails'))) {
          mkdir(public_path('media/video/thumbnails'), 0755, true);
      }
      $file = $request->file('file');
      $type = $file->getMimeType();
      $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
      $filename = time().'_'.$file->getClientOriginalName();
      // save genuine video or image
      if(strstr($type,'video/')){
        $type = 'video';
        $request->file('file')->storeAs('media/video/',$filename,'direct_public');
        $contents = FFMpeg::fromDisk('direct_public')->open('media/video/'.$filename)
              ->getFrameFromSeconds(2)
              ->export()
              ->getFrameContents();
        $image = Image::make($contents);
      }
      else if(strstr($type,'image/')){
        $type = 'image';
        $file_resize = Image::make($file->getRealPath());
        $file_resize->save(public_path('media/'.$type.'/' .$filename));
        $image = $file_resize;
      }
      $height =$image->height();
      $width =$image->width();
      $file_url = '/api/media/'.$type.'/'. $filename;
      $user = auth($this->guard)->user();
      $user_type = $user->role->name;
      $user_id = $user->id;
      $media = Media::create([
          'name' => $name,
          'mime_type' => $file->getClientOriginalExtension(),
          'original_media_path' => $file_url,
          'type' => $type,
          'width' => $width,
          'height' => $height,
          'user_type' => $user_type,
          'user_id' => $user_id
        ]);
      // generate thumbnails
      $media->generateThumbnails($image);
      return response()->json(['success' => true,'message' => trans('messages.response.media.your').$type.trans('messages.response.media.uploaded'),'media' => $media], 200);
    }

    /********* Delete Media with its Thumbnails ***********/
    public function deleteMedia($id)
    {
        $file = Media::where('id',$id)->first();
        $file->delete();
        $response = array('msg'=>'success','message' => trans('messages.response.media.delete_success'));
        return $response;
    }
    public function trashMedia($id)
    {
        $file = Media::where('id',$id)->first();
        $path = explode('/api',$file->original_media_path);
        $file_path = public_path().$path[1];
        if(file_exists($file_path)){
          unlink($file_path);
        }
        $thumbnails = $file->thumbnails;
        foreach ($thumbnails as $thumbnail) {
          $path = explode('/api',$thumbnail->thumbnail);
          $file_path = public_path().$path[1];
          if(file_exists($file_path)){
            unlink($file_path);
          }
        }
        $file->thumbnails()->delete();
        $file->delete();
        $response = array('msg'=>'success','message' => trans('messages.response.media.delete_success'));
        return $response;
    }

    public function filter(Request $request){
        return response()->json(["state" => "success", "message" => trans('messages.response.media.filter_success'),"media" => $this->getter(null,$request)] );
    }

}
