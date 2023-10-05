<?php

namespace App\Exports\CMS;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
class ProductReportExport implements FromArray,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $products;
    public function __construct($products)
    {
        $this->products = $products;
    }
    public function array(): array
    {
      $data = [];
      foreach ($this->products as $product) {
        $single = [$product->id,$product->name,$product->manufacturer->name,$product->price,$product->product_type,$product->sku,$product->stock,$product->product_ordered,$product->is_active,$product->is_feature];
        $data[] = $single;
      }
      return $data;
    }
    public function headings(): array{
      return ["id","Name","Manufacturer","Price","Product Type","SKU", "Stock","Orders","Status", "Feature"];
    }
}
