<?php

namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\ApplicationSliderImage;
use App\Http\Requests\CMS\ApplicationSliderImages\CreateRequest;
use App\Http\Resources\CMS\ApplicationSliderImagesResource;
use Excel;
use App\Exports\CMS\ApplicationSliderImagesExport;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Setting;
use PDF;
class ApplicationSliderImagesController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
      $this->middleware('auth:api');
      $this->middleware('permission:application_slider_images.index,guard:api');
      $this->middleware('permission:application_slider_images.create,guard:api',['only' => ['store']]);
      $this->middleware('permission:application_slider_images.update,guard:api',['only' => ['update']]);
      $this->middleware('permission:application_slider_images.delete,guard:api',['only' => ['destroy']]);
      $this->middleware('permission:application_slider_images.update|application_slider_images.is_active,guard:api',['only' => ['updateStatus']]);
  }

  /********* Getter For Pagination, Searching And Sorting  ***********/
  public function getter($req = null,$export = null)
  {
    if($req != null){
      $application_slider_images = new ApplicationSliderImage;
      if($req->column && $req->column != null && $req->search && $req->search != null){
        if($req->column == 'name'){
          $application_slider_images = $application_slider_images->whereLike($req->column.'->'.app()->getLocale(),$req->search);
        }
        else{
          $application_slider_images = $application_slider_images->whereLike($req->column,$req->search);
          }
        }
       else if($req->search && $req->search != null){
            $application_slider_images = $application_slider_images->whereLike(['name->'.app()->getLocale()],$req->search);
        }
      if($req->sort !=null && $req->sort["field"] != null && $req->sort["type"] != null){
        $application_slider_images = $application_slider_images->OrderBy($req->sort["field"],$req->sort["type"]);
      }
      else
      {
        $application_slider_images = $application_slider_images->OrderBy('id','desc');

      }
      if($export != null){ // for export do not paginate
        $application_slider_images = $application_slider_images->get();
        return $application_slider_images;
      }
      $totalApplicationSliderImages = $application_slider_images->count();
      $application_slider_images = $application_slider_images->paginate($req->perPage);
      $application_slider_images = ApplicationSliderImagesResource::collection($application_slider_images)->response()->getData(true);
      return $application_slider_images;
    }
    $application_slider_images = ApplicationSliderImagesResource::collection(ApplicationSliderImage::orderBy('id','desc')->paginate(10))->response()->getData(true);
    return $application_slider_images;
  }

  /********* FETCH ALL ApplicationSliderImages ***********/
    public function index()
    {
        $arrayName = array('application_slider_images' => $this->getter());
        return response($arrayName);
    }
      /********* Export PDF , CSV And Excel  **********/
    public function export(Request $request)
    {
        $application_slider_images = $this->getter($request,"export");
        if ($request->export == 'pdf') {
            $allSettings = Setting::where('name', 'web_logo_image_id')->first();
            $logo = Media::find((int)$allSettings->value);
            $new_logo = str_replace("/api/", "", $logo->original_media_path);
            $data['general'] = [
                'currentDate' => date("Y-m-d"),
                'fileName' => "Application Slider Image",
                'reportName' => "Application Slider Image",
                'logo' => $new_logo,
            ];
            $data['tableHeaders'] = ["Sr#", "Name", "Description", "Slider Type", "Expiry Date", "Status"];
            $data['tableData'] = [];
            foreach ($application_slider_images as $key => $application_slider_image) {
                if ($application_slider_image->is_active == 1) {
                    $is_active = "Active";
                } else {
                    $is_active = "Inactive";
                }

                $result = [++$key, $application_slider_image->name, strip_tags($application_slider_image->description),$application_slider_image->slider_type,date('d-m-Y', strtotime($application_slider_image->expiry_date)),$is_active];
                $data['tableData'][] = $result;
            }
            $pdf = PDF::loadView('pdf.pages', $data);
            return $pdf->setPaper('A4', 'potrait')->download('application_slider_images.pdf');
        }
        $filename = "application_slider_images.".$request->export;
        return Excel::download(new ApplicationSliderImagesExport($application_slider_images), $filename);
    }

  /********* FILTER ApplicationSliderImages FOR Search ***********/
   public function filter(Request $request){
       return response()->json(["state" => "success", "message" => trans('messages.response.application_slider_images.filter_success'),"application_slider_images" => $this->getter($request)] );
   }

    /********* ADD NEW ApplicationSliderImage ***********/
    public function store(CreateRequest $request)
    {
      $application_slider_image = ApplicationSliderImage::create($request->all());
      return response(["message" => trans('messages.response.application_slider_images.create_success')]);
    }

    /********* View RECORD TO EDIT Or Display ***********/
    public function show(ApplicationSliderImage $application_slider_image)
    {
        return new ApplicationSliderImagesResource($application_slider_image);
    }

    /********* UPDATE ApplicationSliderImage ***********/
    public function update(CreateRequest $request, ApplicationSliderImage $application_slider_image)
    {
      $application_slider_image->update($request->all());
        return response(["message" => trans('messages.response.application_slider_images.update_success')]);

    }

    /********* UPDATE Manufacturer Status***********/
    public function updateStatus(Request $request,ApplicationSliderImage $application_slider_image){
        $application_slider_image->update([
          'is_active' => $application_slider_image->is_active == 1 ? 0:1
        ]);
        return response()->json(["state" => "success", "message" => trans('messages.response.application_slider_images.update_status_success'),"application_slider_images" => $this->getter($request)] );
    }

    /********* DELETE LANGUAGE ***********/
    public function destroy(Request $request,ApplicationSliderImage $application_slider_image)
    {
          $application_slider_image->delete();
          return response()->json(["state" => "success", "message" => trans('messages.response.application_slider_images.delete_success'),"application_slider_images" => $this->getter($request)] );
    }
}
