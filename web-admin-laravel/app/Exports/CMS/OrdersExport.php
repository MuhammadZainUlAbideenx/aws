<?php

namespace App\Exports\CMS;

use App\Models\CMSModels\Order;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
class OrdersExport implements FromArray,WithHeadings,ShouldAutoSize, WithEvents, WithTitle, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $orders;
    public function __construct($orders)
    {
        $this->orders = $orders;
    }
    public function styles(Worksheet $sheet)
    {
        // $sheet->getStyle('A1:W1')->getFont()->getBold();
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
         ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A:W'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            },
        ];
    }
    public function title(): string
    {
        return 'Orders';
    }
    public function array(): array
    {
      $data = [];
      foreach ($this->orders as $key=>$order) {
        if($order->payment_method_id == 1 ){
            $payment_method = "Direct Bank Transfer";
        }
        else if($order->payment_method_id == 2 ){
            $payment_method = "Cash on Delivery";
        }
        else if ($order->payment_method_id == 8){
            $payment_method = "Wallet";
        }
        else if ($order->payment_method_id == 4){
            $payment_method = "Through Stripe";
        }
        else if($order->payment_method_id == 5){
            $payment_method = "Through Braintree";
        }
        else if($order->payment_method_id == 3){
            $payment_method = "Through Paypal";
        }
        else if($order->payment_method_id == 9){
            $payment_method = "Through Razorpay";
        }
        else if($order->payment_method_id == 10){
            $payment_method = "Through Flutterwave";
        }

        if ($order->is_paid == 1) {
            $is_paid = "Yes";
        } else {
            $is_paid = "No";
        }
        if ($order->is_active == 1) {
            $is_active = "Active";
        } else {
            $is_active = "Inactive";
        }
        $single = [++$key,$order->order_number,$order->order_status? $order->order_status->name:'',get_display_price($order->total),$is_paid,$payment_method,$is_active];
        $data[] = $single;
      }
      return $data;
    }
    public function headings(): array{
      return ["Sr","Number","Order Status","Total","Is Paid","Payment Method", "Status"];
    }
}
