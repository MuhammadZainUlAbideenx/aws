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
class ProductsExport implements FromArray,WithHeadings,ShouldAutoSize, WithEvents, WithTitle, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $products;
    public function __construct($products)
    {
        $this->products = $products;
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
        return 'Products';
    }
    public function array(): array
    {
      $data = [];
      foreach ($this->products as $key=>$product) {
        $product_name = $product->name;
        if (isset($product->flash_sale)){
            $product_name = $product->name. " (Flash Sale)";
        }
        if (isset($product->special_sale)){
            $product_name = $product->name. " (Special Sale)";
        }
        if ($product->is_active == 1) {
            $is_active = "Active";
        } else {
            $is_active = "Inactive";
        }
        if ($product->product_type == 1) {
            $product_type = "Simple";
        } else {
            $product_type = "Variable";
        }
        $single = [++$key,$product_name,$product->modal,$product_type , get_display_price($product->price),$product->sku,$product->stock,$product->weight,$product->unit ? $product->unit->name : '', $product->manufacturer ? $product->manufacturer->name :'', $product->brand ? $product->brand->name : '', $product->tax_class ? $product->tax_class->name : '', $product->slug, $product->min_order, $product->max_order,$is_active];
        $data[] = $single;
      }
      return $data;
    }
    public function headings(): array{
      return ["Sr","Name","Modal","Product Type","Price","Sku","Stock","Weight","Unit","Manufacturer","Brand","Tax Class","Slug","Min Order", "Max Order", "Status"];
    }
}
