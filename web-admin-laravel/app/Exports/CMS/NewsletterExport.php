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
class NewsletterExport implements FromArray,WithHeadings,ShouldAutoSize, WithEvents, WithTitle, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $newsletters;
    public function __construct($newsletters)
    {
        $this->newsletters = $newsletters;
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
        return 'Newsletter';
    }
    public function array(): array
    {
      $data = [];
      foreach ($this->newsletters as $key=>$newsletter) {
        if ($newsletter->is_active == 1) {
            $is_active = "Active";
        } else {
            $is_active = "Inactive";
        }
        $single = [++$key,$newsletter->email, $is_active];
        $data[] = $single;
      }
      return $data;
    }
    public function headings(): array{
      return ["Sr","Email", "Status"];
    }
}
