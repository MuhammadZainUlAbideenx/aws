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
class PayoutRequestsExport implements FromArray,WithHeadings,ShouldAutoSize, WithEvents, WithTitle, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $payoutRequests;
    public function __construct($payoutRequests)
    {
        $this->payoutRequests = $payoutRequests;
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
      foreach ($this->payoutRequests as $key=>$payoutRequest) {
        if($payoutRequest->status == 1 ){
            $status = "Pending";
        }
        else if($payoutRequest->status == 2 ){
            $status = "Approved";
        }
        else {
            $status = "Rejected";
        }

        $single = [++$key,$payoutRequest->vendor->name,$payoutRequest->amount,$payoutRequest->note,$status,date('d-m-Y', strtotime($payoutRequest->created_at))];
        $data[] = $single;
      }
      return $data;
    }
    public function headings(): array{
      return ["Sr","Vendor Name","Amount","Note","Status","Date"];
    }
}
