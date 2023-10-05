<?php

namespace App\Models\CMSModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CMSModels\Country;
use App\Models\CMSModels\State;
use App\Models\CMSModels\TaxRate;

class Zone extends Model
{
    use HasFactory;
    protected $fillable = ['name','country_id','code','is_active'];
    public function scopeWithAll($query)
    {
     return $query->with('countries');
   }
    public function countries()
    {
        return $this->belongsTo(Country::class,'country_id');
    }
    public function tax_rate()
    {
        return $this->hasOne(TaxRate::class,'zone_id');
    }
    public function state()
    {
        return $this->hasOne(State::class,'zone_id');
    }

}
