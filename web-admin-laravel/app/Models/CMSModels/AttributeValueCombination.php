<?php

namespace App\Models\CMSModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValueCombination extends Model
{
    use HasFactory;
    protected $fillable = ['name','description'];
    public function scopeWithAll($query)
    {
     return $query->with('attribute')->with('value');
   }
   public function attribute(){
     return $this->belongsTo(Attribute::class,'attribute_id')->with('values');
   }
   public function value(){
     return $this->belongsTo(AttributeValue::class,'attribute_value_id');
   }
}
