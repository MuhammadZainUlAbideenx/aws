<?php

namespace App\Models\CMSModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Models\CMSModels\Review;

class ReviewStatus extends Model
{
    use HasTranslations;
    use HasFactory;
    public $translatable = ['name','description'];
    protected $fillable = ['name','description','is_active','is_default'];
    public function scopeWithAll($query)
    {
     return $query->with('reviews');
   }
    public function reviews(){
      return $this->hasMany(Review::class,'review_status_id');
    }

}
