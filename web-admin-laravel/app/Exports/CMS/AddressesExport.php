<?php

namespace App\Exports\CMS;

use App\Models\CMSModels\Address;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
class AddressesExport implements FromArray,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $addresses;
    public function __construct($addresses)
    {
        $this->addresses = $addresses;
    }
    public function array(): array
    {
      $data = [];
      foreach ($this->addresses as $address) {
        $single = [$address->id,$address->customer->first_name,$address->customer->last_name,$address->address,$address->country->name,$address->city->name,$address->state->name];
        $data[] = $single;
      }
      return $data;
    }
    public function headings(): array{
      return ["id","first name","last name","address","country","city","state"];
    }
}
