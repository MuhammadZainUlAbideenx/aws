<?php

namespace App\Exports\CMS;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
class CustomerReportExport implements FromArray,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $customers;
    public function __construct($customers)
    {
        $this->customers = $customers;
    }
    public function array(): array
    {
      $data = [];
      foreach ($this->customers as $customer) {
        $single = [$customer->id,$customer->first_name,$customer->last_name,$customer->dob,$customer->phone,$customer->email,$customer->gender, $customer->status];
        $data[] = $single;
      }
      return $data;
    }
    public function headings(): array{
      return ["id","First Name","Last Name","Date of Birth","Phone","Email", "Gender", "Status"];
    }
}
