<?php

namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\SliderImage;
use App\Http\Requests\CMS\SliderImages\CreateRequest;
use App\Http\Resources\CMS\SliderImagesResource;
use Excel;
use App\Exports\CMS\SliderImagesExport;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Setting;
use PDF;

class SliderImagesController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
      $this->middleware('auth:api');
      $this->middleware('permission:slider_images.index,guard:api');
      $this->middleware('permission:slider_images.create,guard:api',['only' => ['store']]);
      $this->middleware('permission:slider_images.update,guard:api',['only' => ['update']]);
      $this->middleware('permission:slider_images.delete,guard:api',['only' => ['destroy']]);
      $this->middleware('permission:slider_images.update|slider_images.is_active,guard:api',['only' => ['updateStatus']]);
  }

  /********* Getter For Pagination, Searching And Sorting  ***********/
  public function getter($req = null,$export = null)
  {
    if($req != null){
      $slider_images = new SliderImage;
      if($req->column && $req->column != null && $req->search && $req->search != null){
        if($req->column == 'name'){
          $slider_images = $slider_images->whereLike($req->column.'->'.app()->getLocale(),$req->search);
        }
        else{
          $slider_images = $slider_images->whereLike($req->column,$req->search);
          }
        }
       else if($req->search && $req->search != null){
            $slider_images = $slider_images->whereLike(['name->'.app()->getLocale()],$req->search);
        }
      if($req->sort !=null && $req->sort["field"] != null && $req->sort["type"] != null){
        $slider_images = $slider_images->OrderBy($req->sort["field"],$req->sort["type"]);
      }
      else
      {
        $slider_images = $slider_images->OrderBy('id','desc');
      }
      if($export != null){ // for export do not paginate
        $slider_images = $slider_images->get();
        return $slider_images;
      }
      $totalSliderImages = $slider_images->count();
      $slider_images = $slider_images->paginate($req->perPage);
      $slider_images = SliderImagesResource::collection($slider_images)->response()->getData(true);
      return $slider_images;
    }
    $slider_images = SliderImagesResource::collection(SliderImage::orderBy('id','desc')->paginate(10))->response()->getData(true);
    return $slider_images;
  }

  /********* FETCH ALL SliderImages ***********/
    public function index()
    {
        $arrayName = array('slider_images' => $this->getter());
        return response($arrayName);
    }
      /********* Export PDF , CSV And Excel  **********/
    public function export(Request $request)
    {
        $slider_images = $this->getter($request,"export");
        if ($request->export == 'pdf') {
            $allSettings = Setting::where('name', 'web_logo_image_id')->first();
            $logo = Media::find((int)$allSettings->value);
            $new_logo = str_replace("/api/", "", $logo->original_media_path);
            $data['general'] = [
                'currentDate' => date("Y-m-d"),
                'fileName' => "Slider Images",
                'reportName' => "Slider Images",
                'logo' => $new_logo,
            ];
            $data['tableHeaders'] = ["Sr#", "Name", "Slider Type",  "Description", "Expiry Date", "Status"];
            $data['tableData'] = [];
            foreach ($slider_images as $key => $slider_image) {
                if ($slider_image->is_active == 1) {
                    $is_active = "Active";
                } else {
                    $is_active = "Inactive";
                }

                $result = [++$key, $slider_image->name, $slider_image->slider_type, strip_tags($slider_image->description),date('d-m-Y', strtotime($slider_image->expiry_date)),$is_active];
                $data['tableData'][] = $result;
            }
            $pdf = PDF::loadView('pdf.pages', $data);
            return $pdf->setPaper('A4', 'potrait')->download('slider_images.pdf');
        }
        $filename = "slider_images.".$request->export;
        return Excel::download(new SliderImagesExport($slider_images), $filename);
    }

  /********* FILTER SliderImages FOR Search ***********/
   public function filter(Request $request){
       return response()->json(["state" => "success", "message" =>  trans('messages.response.slider_images.filter_success'),"slider_images" => $this->getter($request)] );
   }

    /********* ADD NEW SliderImage ***********/
    public function store(CreateRequest $request)
    {
      $slider_image = SliderImage::create($request->all());
      return response(["message" => trans('messages.response.slider_images.create_success')]);
    }

    /********* View RECORD TO EDIT Or Display ***********/
    public function show(SliderImage $slider_image)
    {
        return new SliderImagesResource($slider_image);
    }

    /********* UPDATE SliderImage ***********/
    public function update(CreateRequest $request, SliderImage $slider_image)
    {
      $slider_image->update($request->all());
        return response(["message" => trans('messages.response.slider_images.update_success')]);

    }

    /********* UPDATE Manufacturer Status***********/
    public function updateStatus(Request $request,SliderImage $slider_image){
        $slider_image->update([
          'is_active' => $slider_image->is_active == 1 ? 0:1
        ]);
        return response()->json(["state" => "success", "message" => trans('messages.response.slider_images.update_status_success'),"slider_images" => $this->getter($request)] );
    }

    /********* DELETE LANGUAGE ***********/
    public function destroy(Request $request,SliderImage $slider_image)
    {
          $slider_image->delete();
          return response()->json(["state" => "success", "message" => trans('messages.response.slider_images.delete_success'),"slider_images" => $this->getter($request)] );
    }
}
