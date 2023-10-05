<?php

namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\ReviewStatus;
use App\Http\Requests\CMS\ReviewStatuses\CreateRequest;
use App\Http\Resources\CMS\ReviewStatusesResource;
use Excel;
use DB;
use App\Exports\CMS\ReviewStatusesExport;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Setting;
use PDF;

class ReviewStatusesController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
      $this->middleware('auth:api');
      $this->middleware('permission:review_statuses.index,guard:api');
      $this->middleware('permission:review_statuses.create,guard:api',['only' => ['store']]);
      $this->middleware('permission:review_statuses.update,guard:api',['only' => ['update']]);
      $this->middleware('permission:review_statuses.delete,guard:api',['only' => ['destroy']]);
      $this->middleware('permission:review_statuses.update|review_statuses.is_active,guard:api',['only' => ['updateStatus']]);
  }

  /********* Getter For Pagination, Searching And Sorting  ***********/
  public function getter($req = null,$export = null)
  {
    if($req != null){
      $review_statuses = ReviewStatus::withAll();
      if($req->column && $req->column != null && $req->search && $req->search != null){
        if($req->column == 'name'){
          $review_statuses = $review_statuses->whereLike($req->column.'->'.app()->getLocale(),$req->search);
        }
        else{
          $review_statuses = $review_statuses->whereLike($req->column,$req->search);
          }
        }
       else if($req->search && $req->search != null){
            $review_statuses = $review_statuses->whereLike(['name->'.app()->getLocale()],$req->search);
        }
      if($req->sort !=null && $req->sort["field"] != null && $req->sort["type"] != null){
        if($req->sort["field"] == 'name'){
          $locale = app()->getLocale();
          $attribute = $req->sort['field'].'->'."'$.$locale'";
          $review_statuses = $review_statuses->OrderBy(DB::raw("lower($attribute)"),$req->sort["type"]);
        }
        else{
          $review_statuses = $review_statuses->OrderBy($req->sort["field"],$req->sort["type"]);
        }
      }
      else
      {
        $review_statuses = $review_statuses->OrderBy('id','desc');
      }
        if($export != null){ // for export do not paginate
        $review_statuses = $review_statuses->get();
        return $review_statuses;
      }
      $totalReviewStatuses = $review_statuses->count();
      $review_statuses = $review_statuses->paginate($req->perPage);
      $review_statuses = ReviewStatusesResource::collection($review_statuses)->response()->getData(true);
      return $review_statuses;
    }
    $review_statuses = ReviewStatusesResource::collection(ReviewStatus::withAll()->orderBy('id','desc')->paginate(10))->response()->getData(true);
    return $review_statuses;
  }

  /********* FETCH ALL ReviewStatuses ***********/
    public function index()
    {
        $arrayName = array('review_statuses' => $this->getter());
        return response($arrayName);
    }
      /********* Export PDF , CSV And Excel  **********/
    public function export(Request $request)
    {
        $review_statuses = $this->getter($request,"export");
        if ($request->export == 'pdf') {
            $allSettings = Setting::where('name', 'web_logo_image_id')->first();
            $logo = Media::find((int)$allSettings->value);
            $new_logo = str_replace("/api/", "", $logo->original_media_path);
            $data['general'] = [
                'currentDate' => date("Y-m-d"),
                'fileName' => "Review Statuses",
                'reportName' => "Review Statuses",
                'logo' => $new_logo,
            ];
            $data['tableHeaders'] = ["Sr#", "Name", "Description", "Status"];
            $data['tableData'] = [];
            foreach ($review_statuses as $key => $review_statuse) {
                if ($review_statuse->is_active == 1) {
                    $is_active = "Active";
                } else {
                    $is_active = "Inactive";
                }

                $result = [++$key, $review_statuse->name,strip_tags($review_statuse->description), $is_active];
                $data['tableData'][] = $result;
            }
            $pdf = PDF::loadView('pdf.pages', $data);
            return $pdf->setPaper('A4', 'potrait')->download('review_statuses.pdf');
        }
        $filename = "review_statuses.".$request->export;
        return Excel::download(new ReviewStatusesExport($review_statuses), $filename);
    }

  /********* FILTER ReviewStatuses FOR Search ***********/
   public function filter(Request $request){
       return response()->json(["state" => "success", "message" => trans('messages.response.review_statuses.filter_success'),"review_statuses" => $this->getter($request)] );
   }

    /********* ADD NEW ReviewStatus ***********/
    public function store(CreateRequest $request)
    {
      if($request->is_default){
        ReviewStatus::where('is_default',1)->update([
          'is_default' => 0
        ]);
      }
      $review_status = ReviewStatus::create($request->all());
      return response(["message" => trans('messages.response.review_statuses.create_success')]);
    }

    /********* View RECORD TO EDIT Or Display ***********/
    public function show( $review_status)
    {
        $review_status = ReviewStatus::withAll()->find($review_status);
        return new ReviewStatusesResource($review_status);
    }

    /********* UPDATE ReviewStatus ***********/
    public function update(CreateRequest $request, ReviewStatus $review_status)
    {
      if($review_status->status == 'published' || $review_status->status == 'rejected' || $review_status->status == 'pending'){
        $data = $request->except('is_active');
        $review_status->update($data);
        return response(["message" => trans('messages.response.review_statuses.update_success')]);
      }else{
        if($request->is_default && !$review_status->is_default){
          ReviewStatus::where('is_default',1)->update([
            'is_default' => 0
          ]);
          $review_status->update($request->all());
          return response(["message" => trans('messages.response.review_statuses.update_success')]);
        }
        else if($review_status->is_default && !$request->is_default){
          return response(["state" => "fail","message" => trans('messages.response.review_statuses.atlleast_one_must_default')]);
        }
        else{
          $review_status->update($request->all());
          return response(["message" => trans('messages.response.review_statuses.update_success')]);
        }
    }
  }

    /********* UPDATE ReviewStatus Status***********/
    public function updateStatus(Request $request,ReviewStatus $review_status){
      if($review_status->status == 'published' || $review_status->status == 'rejected' || $review_status->status == 'pending'){
        return response()->json(["state" => "fail","message" =>  trans('messages.response.review_statuses.cannot_disable_default')]);
      }else{
      if($review_status->is_default){
        return response()->json(["state" => "fail","message" => trans('messages.response.review_statuses.cannot_disable_default')]);
      }
      else{
        $review_status->update([
          'is_active' => $review_status->is_active == 1 ? 0:1
        ]);
        return response()->json(["state" => "success", "message" => trans('messages.response.review_statuses.update_status_success'),"review_statuses" => $this->getter($request)] );
      }
    }
}
    /********* UPDATE default ReviewStatus Status***********/

    public function updateDefault(Request $request,ReviewStatus $review_status){
      if($review_status->is_default){
        return response()->json(["state" => "fail","message" => trans('messages.response.review_statuses.one_must_default')]);
      }
      else{
        ReviewStatus::where('is_default',1)->update([
          'is_default' => 0
        ]);
        $review_status->update([
          'is_default' => 1,
          'is_active' => 1
        ]);
        return response()->json(["state" => "success", "message" => trans('messages.response.review_statuses.update_default_status_success'),"review_statuses" => $this->getter($request)] );
      }
    }


    /********* DELETE LANGUAGE ***********/
    public function destroy(Request $request,ReviewStatus $review_status)
    {
    if($review_status->status == 'published' || $review_status->status == 'rejected' || $review_status->status == 'pending'){
      return response()->json(["state" => "fail","message" =>  trans('messages.response.review_statuses.delete_fail')]);
    }else{
      if($review_status->is_default){
        return response()->json(["state" => "fail","message" =>  trans('messages.response.review_statuses.delete_fail')]);
      }else{
        if($review_status->reviews()){
          $reviews = $review_status->reviews()->get();
          $defaultReview = ReviewStatus::where('is_default',1)->first();
          foreach ($reviews as $review) {
                  $review->update([
                    'review_status_id' => $defaultReview->id
                  ]);
            }
        }
        $review_status->delete();
        return response()->json(["state" => "success", "message" => trans('messages.response.review_statuses.delete_success'),"review_statuses" => $this->getter($request)] );
      }
    }
  }
}
