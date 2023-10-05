<?php

namespace App\Exports\CMS;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
class OrderReportExport implements FromArray,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $orders;
    public function __construct($orders)
    {
        $this->orders = $orders;
    }
    public function array(): array
    {
      $data = [];
      foreach ($this->orders as $order) {
        $single = [$order->id,$order->order_number,$order->customer_id,$order->order_status_id,$order->payment_method->name,$order->sub_total,$order->shipping_price,$order->coupon_amount,$order->total];
        $data[] = $single;
      }
      return $data;
    }
    public function headings(): array{
      return ["id","Number","Customer Name","Order Status","Payment Method","Sub Total", "Shipping Amount","Coupon Amount","Total"];
    }
}
