<?php

namespace App\Exports\CMS;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
class SaleReportExport implements FromArray,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $sales;
    public function __construct($sales)
    {
        $this->sales = $sales;
    }
    public function array(): array
    {
      $data = [];
      foreach ($this->sales as $sale) {
        $single = [$sale->id,$sale->order_number,$sale->payment_method->name,$sale->sub_total,$sale->shipping_price,$sale->coupon_amount,$sale->total];
        $data[] = $single;
      }
      return $data;
    }
    public function headings(): array{
      return ["id","order number","payment method","sub total","shipping price","coupon amount", "total"];
    }
}
