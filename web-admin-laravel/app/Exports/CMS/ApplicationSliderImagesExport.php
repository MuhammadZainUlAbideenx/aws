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
class ApplicationSliderImagesExport implements FromArray,WithHeadings,ShouldAutoSize, WithEvents, WithTitle, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $application_slider_images;
    public function __construct($application_slider_images)
    {
        $this->application_slider_images = $application_slider_images;
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
        return 'Application Slider Images';
    }
    public function array(): array
    {
      $data = [];
      foreach ($this->application_slider_images as $key=>$application_slider_image) {
        if ($application_slider_image->is_active == 1) {
            $is_active = "Active";
        } else {
            $is_active = "Inactive";
        }
        $single = [++$key,$application_slider_image->name,date('d-m-Y', strtotime($application_slider_image->expiry_date)),$application_slider_image->slider_type,$is_active ];
        $data[] = $single;
      }
      return $data;
    }
    public function headings(): array{
      return ["Sr","Name","Expiry Date","Slider Type","Status"];
    }
}
