<?php

namespace App\Exports\CMS;

use App\Models\CMSModels\Commission;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
class CommissionsExport implements FromArray,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $commissions;
    public function __construct($commissions)
    {
        $this->commissions = $commissions;
    }
    public function array(): array
    {
      $data = [];
      foreach ($this->commissions as $commission) {
        $single = [$commission->id,$commission->name,$commission->iso_code_2,$commission->iso_code_3];
        $data[] = $single;
      }
      return $data;
    }
    public function headings(): array{
      return ["id","name","iso_code_2","iso_code_3"];
    }
}
