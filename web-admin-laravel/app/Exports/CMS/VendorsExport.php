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
class VendorsExport implements FromArray,WithHeadings,ShouldAutoSize, WithEvents, WithTitle, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $vendors;
    public function __construct($vendors)
    {
        $this->vendors = $vendors;
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
        return 'Vendors';
    }
    public function array(): array
    {
      $data = [];
      foreach ($this->vendors as $key=>$vendor) {
        if ($vendor->is_active == 1) {
            $is_active = "Active";
        } else {
            $is_active = "Inactive";
        }
        $single = [++$key,$vendor->name,$vendor->email, $vendor->store ? $vendor->store->name :'', $vendor->store?$vendor->store->address: '', $vendor->store &&  $vendor->store->city ? $vendor->store->city->name : ' ', $vendor->store? $vendor->store->headline:'', $vendor->store? $vendor->store->postal_code:'', $vendor->store ?$vendor->store->phone:'',$is_active];
        $data[] = $single;
      }
      return $data;
    }
    public function headings(): array{
      return ["Sr","name","email", "store name","store address", "store city", "store headline", "postal code", "store phone", "Status"];
    }
}
