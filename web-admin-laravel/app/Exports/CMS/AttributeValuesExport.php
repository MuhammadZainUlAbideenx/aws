<?php

namespace App\Exports\CMS;

use App\Models\CMSModels\Language;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
class AttributeValuesExport implements FromArray,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $attribute_values;
    public function __construct($attribute_values)
    {
        $this->attribute_values = $attribute_values;
    }
    public function array(): array
    {
      $data = [];
      foreach ($this->attribute_values as $attribute_value) {
        $single = [$attribute_value->id,$attribute_value->name,strip_tags($attribute_value->description)];
        $data[] = $single;
      }
      return $data;
    }
    public function headings(): array{
      return ["id","name","description"];
    }
}
