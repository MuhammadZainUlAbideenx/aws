<?php

namespace App\Models\CMSModels;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CMSModels\Setting;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\CMSModels\MediaDetail;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
  use HasFactory,SoftDeletes;
  protected $fillable = ['original_media_path','type','mime_type','name','width','height','user_type','user_id'];

  public function thumbnails(){
    return $this->hasMany(MediaDetail::class,'media_id');
  }
  public function small_thumbnail(){
    return $this->thumbnails()->where('thumbnail_type','small');
  }
  public function scopeWithAll($query)
  {
   return $query->with('thumbnails');
 }

  public function createThumbnail($image,$width,$height,$size){
    $filename    = time().'_'.$this->name.'_'.$size.'.png';
    $file_resize = $image;
    if($this->width < $width && $this->height < $height)
    {
        $width=$this->width;
        $height=$this->height;
    }
    $file_resize->resize($width, $height, function ($constraint) {
        $constraint->aspectRatio();
        $constraint->upsize();
    });
    $file_resize->save(public_path('media/'.$this->type.'/thumbnails'.'/'.$filename));
        $file_url = '/api/media/'.$this->type.'/thumbnails'.'/'. $filename;
        $this->thumbnails()->create([
          'thumbnail_type' => $size,
          'thumbnail' => $file_url,
          'height' => $file_resize->height(),
          'width' => $file_resize->width()
        ]);
  }

  public function generateThumbnails($image){
    //get thumbnail settings
    $media_thumbnails = ['large_thumbnail_width','small_thumbnail_width','medium_thumbnail_width'
                        ,'small_thumbnail_height','medium_thumbnail_height','large_thumbnail_height'];
    $mediaSetting = Setting::whereIn('name',$media_thumbnails)->select('name','value')->pluck('value','name')->toArray();

    $this->createThumbnail($image,(int)$mediaSetting['large_thumbnail_width'], (int)$mediaSetting['large_thumbnail_height'],'large');
    $this->createThumbnail($image,(int)$mediaSetting['medium_thumbnail_width'], (int)$mediaSetting['medium_thumbnail_height'],'medium');
    $this->createThumbnail($image,(int)$mediaSetting['small_thumbnail_width'], (int)$mediaSetting['small_thumbnail_height'],'small');
  }
}
