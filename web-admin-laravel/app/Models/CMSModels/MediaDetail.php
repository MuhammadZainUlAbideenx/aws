<?php

namespace App\Models\CMSModels;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CMSModels\Media;
class MediaDetail extends Model
{
  use HasFactory;
  protected $fillable = ['media_id','thumbnail','thumbnail_type','height','width'];
  public function scopeWithAll($query)
  {
   return $query->with('media');
 }
  public function media()
  {
      return $this->belongsTo(Media::class);
  }
}
