<?php

namespace App\Exports\CMS;

use App\Models\CMSModels\Language;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
class CouponsExport implements FromArray,WithHeadings,ShouldAutoSize, WithEvents, WithTitle, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $coupons;
    public function __construct($coupons)
    {
        $this->coupons = $coupons;
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
        return 'Coupons';
    }
    public function array(): array
    {
      $data = [];
      foreach ($this->coupons as $key=>$coupon) {
        if ($coupon->is_active == 1) {
            $is_active = "Active";
        } else {
            $is_active = "Inactive";
        }
        $single = [++$key,$coupon->code,$coupon->vendor?$coupon->vendor->name:'',$coupon->amount,date('d-m-Y', strtotime($coupon->expiry_date)),$coupon->usage_limit,$coupon->user_limit,$coupon->minimum_spend,$coupon->maximum_spend,  $is_active ];
        $data[] = $single;
      }
      return $data;
    }
    public function headings(): array{
      return ["Sr","Code","Vendor","Amount","Expiry Date","Usage Limit","User Limit","Minimum Spend","Maximum Spend", "Status"];
    }
}
