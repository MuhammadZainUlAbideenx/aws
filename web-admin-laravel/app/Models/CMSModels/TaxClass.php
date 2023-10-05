<?php

namespace App\Models\CMSModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CMSModels\Product;
use App\Models\CMSModels\TaxRate;
use Spatie\Translatable\HasTranslations;

class TaxClass extends Model
{
    use HasFactory;
    use HasTranslations;
    public $translatable = ['name','description'];
    protected $fillable = ['name','description','is_active'];
    public function tax_rate()
    {
        return $this->hasOne(TaxRate::class,'tax_class_id');
    }

}
