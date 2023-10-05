<?php

namespace App\Exports\Seller;

use App\Models\CMSModels\Rider;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
class RidersExport implements FromArray,WithHeadings,ShouldAutoSize, WithEvents, WithTitle, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $riders;
    public function __construct($riders)
    {
        $this->riders = $riders;
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
        return 'Riders';
    }
    public function array(): array
    {
      $data = [];
      foreach ($this->riders as $key=>$rider) {
        if ($rider->is_active == 1) {
            $is_active = "Active";
        } else {
            $is_active = "Inactive";
        }
        $single = [++$key,$rider->first_name,$rider->last_name,$rider->gender,$rider->email,$rider->phone,$rider->address, date('d-m-Y', strtotime($rider->dob)), $is_active];
        $data[] = $single;
      }
      return $data;
    }
    public function headings(): array{
      return ["Sr","First Name","Last Name","Gender","Email","Phone","Address","Dob", "Status"];
    }
}
