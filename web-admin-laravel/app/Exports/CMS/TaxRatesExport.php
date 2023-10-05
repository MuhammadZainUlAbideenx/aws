<?php

namespace App\Exports\CMS;

use App\Models\CMSModels\TaxRate;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
class TaxRatesExport implements FromArray,WithHeadings,ShouldAutoSize, WithEvents, WithTitle, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $tax_rates;
    public function __construct($tax_rates)
    {
        $this->tax_rates = $tax_rates;
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
        return 'Tax Rates';
    }
    public function array(): array
    {
      $data = [];
      foreach ($this->tax_rates as $key=>$tax_rate) {
        if ($tax_rate->is_active == 1) {
            $is_active = "Active";
        } else {
            $is_active = "Inactive";
        }
          if($tax_rate->zone){
              $zone_name= $tax_rate->zone->name;
          }
          else
          {
              $zone_name= '';
          }
          if($tax_rate->tax_class){
            $tax_class_name= $tax_rate->tax_class->name;
        }
        else
        {
            $tax_class_name= '';
        }
        $single = [++$key,$tax_rate->rate,$zone_name,$tax_class_name, $is_active];
        $data[] = $single;
      }
      return $data;
    }
    public function headings(): array{
      return ["Sr","Rate","Zone","Tax Class", "Status"];
    }
}
