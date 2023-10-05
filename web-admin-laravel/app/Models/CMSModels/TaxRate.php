<?php

namespace App\Models\CMSModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CMSModels\TaxClass;
use App\Models\CMSModels\Zone;

class TaxRate extends Model
{
    use HasFactory;
    protected $fillable = ['rate','zone_id','tax_class_id','is_active'];
    public function scopeWithAll($query)
    {
     return $query->with('tax_class')->with('zone');
   }
    public function tax_class()
    {
        return $this->belongsTo(TaxClass::class,'tax_class_id');
    }
    public function zone()
    {
        return $this->belongsTo(Zone::class,'zone_id');
    }

}
