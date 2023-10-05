<?php

namespace App\Exports\CMS;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
class ReviewsExport implements FromArray,WithHeadings,ShouldAutoSize, WithEvents, WithTitle, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $reviews;
    public function __construct($reviews)
    {
        $this->reviews = $reviews;
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
        return 'Reviews';
    }
    public function array(): array
    {
      $data = [];
      foreach ($this->reviews as $key=>$review) {
        if ($review->is_active == 1) {
            $is_active = "Active";
        } else {
            $is_active = "Inactive";
        }
        $single = [++$key,$review->customer->first_name,$review->product->name,$review->rating,$review->review_status->name, $is_active];
        $data[] = $single;
      }
      return $data;
    }
    public function headings(): array{
      return ["Sr","Customer","Product","Rating","Review Status", "Status"];
    }
}
