<?php

namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\Review;
use App\Models\CMSModels\Customer;
use App\Models\CMSModels\Product;
use App\Http\Requests\CMS\Reviews\CreateRequest;
use App\Http\Resources\CMS\ReviewsResource;
use App\Http\Resources\CMS\CustomersRecourse;
use App\Http\Resources\CMS\ProductsRecourse;
use Excel;
use App\Exports\CMS\ReviewsExport;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Setting;
use PDF;

class ReviewsController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
      $this->middleware('auth:api');
      $this->middleware('permission:reviews.index,guard:api');
      $this->middleware('permission:reviews.create,guard:api',['only' => ['store']]);
      $this->middleware('permission:reviews.update,guard:api',['only' => ['update']]);
      $this->middleware('permission:reviews.delete,guard:api',['only' => ['destroy']]);
      $this->middleware('permission:reviews.update|reviews.is_active,guard:api',['only' => ['updateStatus']]);
  }

  /********* Getter For Pagination, Searching And Sorting  ***********/
  public function getter($req = null,$export = null)
  {
    if($req != null){
      $reviews = Review::withAll();
      if($req->column && $req->column != null && $req->search && $req->search != null){
        if($req->column == 'name'){
          $reviews = $reviews->whereLike(['customer.first_name','customer.last_name'],$req->search);
        }else{
          $reviews = $reviews->whereLike($req->column,$req->search);
        }
      }else if($req->search && $req->search != null){
            $reviews = $reviews->whereLike(['customer.first_name','customer.last_name','rating','product.name'],$req->search);
        }
      if($req->sort !=null && $req->sort["field"] != null && $req->sort["type"] != null){
        $reviews = $reviews->OrderBy($req->sort["field"],$req->sort["type"]);
      }
      else
      {
        $reviews = $reviews->OrderBy('id','desc');
      }
      if($export != null){ // for export do not paginate
        $reviews = $reviews->get();
        return $reviews;
      }
      $totalReviews = $reviews->count();
      $reviews = $reviews->paginate($req->perPage);
      $reviews = ReviewsResource::collection($reviews)->response()->getData(true);
      return $reviews;
    }
    $reviews = Review::withAll()->orderBy('id','desc')->paginate(10);
    $reviews = ReviewsResource::collection($reviews)->response()->getData(true);
    return $reviews;
  }

  /********* FETCH ALL Reviews ***********/
    public function index()
    {
        $arrayName = array('reviews' => $this->getter());
        return response($arrayName);
    }
      /********* Export PDF , CSV And Excel  **********/
    public function export(Request $request)
    {
        $reviews = $this->getter($request,"export");
        if ($request->export == 'pdf') {
            $allSettings = Setting::where('name', 'web_logo_image_id')->first();
            $logo = Media::find((int)$allSettings->value);
            $new_logo = str_replace("/api/", "", $logo->original_media_path);
            $data['general'] = [
                'currentDate' => date("Y-m-d"),
                'fileName' => "Reviews",
                'reportName' => "Reviews",
                'logo' => $new_logo,
            ];
            $data['tableHeaders'] = ["Sr#", "Name", "Product","Rating", "Review Status","Status"];
            $data['tableData'] = [];
            foreach ($reviews as $key => $review) {
                if ($review->is_active == 1) {
                    $is_active = "Active";
                } else {
                    $is_active = "Inactive";
                }

                $result = [++$key, $review->name, $review->product->name, $review->rating, $review->review_status->name,$is_active];
                $data['tableData'][] = $result;
            }
            $pdf = PDF::loadView('pdf.pages', $data);
            return $pdf->setPaper('A4', 'potrait')->download('review.pdf');
        }
        $filename = "reviews.".$request->export;
        return Excel::download(new ReviewsExport($reviews), $filename);
    }

  /********* FILTER Reviews FOR Search ***********/
   public function filter(Request $request){
       return response()->json(["state" => "success", "message" => trans('messages.response.reviews.filter_success'),"reviews" => $this->getter($request)] );
   }

    /********* ADD NEW Review ***********/
    public function store(CreateRequest $request)
    {
      Review::create($request->all());
      return response(["message" => trans('messages.response.reviews.create_success')]);
    }

    /********* View RECORD TO EDIT Or Display ***********/
    public function show( $review)
    {
        $review = Review::withAll()->find($review);
        return new ReviewsResource($review);
    }

    /********* UPDATE Review ***********/
    public function update(CreateRequest $request, Review $review)
    {
        $review->update($request->all());
        return response(["message" => trans('messages.response.reviews.update_success')]);
    }

    /********* UPDATE Manufacturer Status***********/
    public function updateStatus(Request $request,Review $review){
        $review->update([
          'is_active' => $review->is_active == 1 ? 0:1
        ]);
        return response()->json(["state" => "success", "message" => trans('messages.response.reviews.update_status_success'),"reviews" => $this->getter($request)] );
    }

    /********* DELETE LANGUAGE ***********/
    public function destroy(Request $request,Review $review)
    {
        $review->delete();
          return response()->json(["state" => "success", "message" => trans('messages.response.reviews.delete_success'),"reviews" => $this->getter($request)] );
    }
}
