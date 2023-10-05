<?php

namespace App\Models\CMSModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CMSModels\Product;
use App\Models\CMSModels\Category;
use App\Models\CMSModels\ContentPage;

class SeoPage extends Model
{
    use HasFactory;
    protected $fillable = ['title','description','keywords','meta_tags','product_id','category_id','static_page_id','content_page_id'];
    protected $casts = [
      'meta_tags' => 'array',
    ];
    public function scopeWithAll($query)
    {
     return $query->with('product')->with('category')->with('content_page');
   }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function content_page()
    {
        return $this->belongsTo(ContentPage::class);
    }
}
