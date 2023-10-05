<?php

namespace App\Exports\CMS;

use App\Models\CMSModels\Language;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
class PermissionsExport implements FromArray,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $permissions;
    public function __construct($permissions)
    {
        $this->permissions = $permissions;
    }
    public function array(): array
    {
      $data = [];
      foreach ($this->permissions as $permission) {
        $single = [$permission->id,$permission->name,$permission->display_name,strip_tags($permission->description)];
        $data[] = $single;
      }
      return $data;
    }
    public function headings(): array{
      return ["id","name","display_name","description"];
    }
}
