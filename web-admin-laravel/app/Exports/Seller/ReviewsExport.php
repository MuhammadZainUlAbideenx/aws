<?php

namespace App\Exports\Seller;

use App\Models\CMSModels\Review;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
class ReviewsExport implements FromArray,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $reviews;
    public function __construct($reviews)
    {
        $this->reviews = $reviews;
    }
    public function array(): array
    {
      $data = [];
      foreach ($this->reviews as $review) {
        $single = [$review->id,$review->customer->first_name,$review->product->name,$review->rating,$review->description,$review->review_status->name];
        $data[] = $single;
      }
      return $data;
    }
    public function headings(): array{
      return ["id","customer","product","rating","description","reviewstatus"];
    }
}
