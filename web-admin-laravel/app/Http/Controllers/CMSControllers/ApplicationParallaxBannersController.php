<?php

namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\ApplicationParallaxBanner;
use App\Http\Requests\CMS\ApplicationParallaxBanners\CreateRequest;
use App\Http\Resources\CMS\ApplicationParallaxBannersResource;
use Excel;
use App\Exports\CMS\ApplicationParallaxBannersExport;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Setting;
use PDF;
class ApplicationParallaxBannersController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
      $this->middleware('auth:api');
      $this->middleware('permission:application_parallax_banners.index,guard:api');
      $this->middleware('permission:application_parallax_banners.create,guard:api',['only' => ['store']]);
      $this->middleware('permission:application_parallax_banners.update,guard:api',['only' => ['update']]);
      $this->middleware('permission:application_parallax_banners.delete,guard:api',['only' => ['destroy']]);
      $this->middleware('permission:application_parallax_banners.update|application_parallax_banners.is_active,guard:api',['only' => ['updateStatus']]);
  }

  /********* Getter For Pagination, Searching And Sorting  ***********/
  public function getter($req = null,$export = null)
  {
    if($req != null){
      $application_parallax_banners = new ApplicationParallaxBanner;
      if($req->column && $req->column != null && $req->search && $req->search != null){
        if($req->column == 'name'){
          $application_parallax_banners = $application_parallax_banners->whereLike($req->column.'->'.app()->getLocale(),$req->search);
        }
        else{
          $application_parallax_banners = $application_parallax_banners->whereLike($req->column,$req->search);
          }
        }
       else if($req->search && $req->search != null){
            $application_parallax_banners = $application_parallax_banners->whereLike(['name->'.app()->getLocale()],$req->search);
        }
      if($req->sort !=null && $req->sort["field"] != null && $req->sort["type"] != null){
        $application_parallax_banners = $application_parallax_banners->OrderBy($req->sort["field"],$req->sort["type"]);
      }
      else
      {
        $application_parallax_banners = $application_parallax_banners->OrderBy('id','desc');

      }
      if($export != null){ // for export do not paginate
        $application_parallax_banners = $application_parallax_banners->get();
        return $application_parallax_banners;
      }
      $totalApplicationParallaxBanners = $application_parallax_banners->count();
      $application_parallax_banners = $application_parallax_banners->paginate($req->perPage);
      $application_parallax_banners = ApplicationParallaxBannersResource::collection($application_parallax_banners)->response()->getData(true);
      return $application_parallax_banners;
    }
    $application_parallax_banners = ApplicationParallaxBannersResource::collection(ApplicationParallaxBanner::orderBy('id','desc')->paginate(10))->response()->getData(true);
    return $application_parallax_banners;
  }

  /********* FETCH ALL ApplicationParallaxBanners ***********/
    public function index()
    {
        $arrayName = array('application_parallax_banners' => $this->getter());
        return response($arrayName);
    }
      /********* Export PDF , CSV And Excel  **********/
    public function export(Request $request)
    {
        $application_parallax_banners = $this->getter($request,"export");
        if ($request->export == 'pdf') {
            $allSettings = Setting::where('name', 'web_logo_image_id')->first();
            $logo = Media::find((int)$allSettings->value);
            $new_logo = str_replace("/api/", "", $logo->original_media_path);
            $data['general'] = [
                'currentDate' => date("Y-m-d"),
                'fileName' => "Application Parallax Banners",
                'reportName' => "Application Parallax Banners",
                'logo' => $new_logo,
            ];
            $data['tableHeaders'] = ["Sr#", "Name", "Description", "Expiry Date", "Status"];
            $data['tableData'] = [];
            foreach ($application_parallax_banners as $key => $application_parallax_banner) {
                if ($application_parallax_banner->is_active == 1) {
                    $is_active = "Active";
                } else {
                    $is_active = "Inactive";
                }

                $result = [++$key, $application_parallax_banner->name, strip_tags($application_parallax_banner->description),date('d-m-Y', strtotime($application_parallax_banner->expiry_date)),$is_active];
                $data['tableData'][] = $result;
            }
            $pdf = PDF::loadView('pdf.pages', $data);
            return $pdf->setPaper('A4', 'potrait')->download('application_parallax_banner.pdf');
        }
        $filename = "application_parallax_banners.".$request->export;
        return Excel::download(new ApplicationParallaxBannersExport($application_parallax_banners), $filename);
    }

  /********* FILTER ApplicationParallaxBanners FOR Search ***********/
   public function filter(Request $request){
       return response()->json(["state" => "success", "message" => trans('messages.response.application_parallax_banners.filter_success'),"application_parallax_banners" => $this->getter($request)] );
   }

    /********* ADD NEW ApplicationParallaxBanner ***********/
    public function store(CreateRequest $request)
    {
      $application_parallax_banner = ApplicationParallaxBanner::create($request->all());
      return response(["message" => trans('messages.response.application_parallax_banners.create_success')]);
    }

    /********* View RECORD TO EDIT Or Display ***********/
    public function show(ApplicationParallaxBanner $application_parallax_banner)
    {
        return new ApplicationParallaxBannersResource($application_parallax_banner);
    }

    /********* UPDATE ApplicationParallaxBanner ***********/
    public function update(CreateRequest $request, ApplicationParallaxBanner $application_parallax_banner)
    {
      $application_parallax_banner->update($request->all());
        return response(["message" => trans('messages.response.application_parallax_banners.update_success')]);

    }

    /********* UPDATE Manufacturer Status***********/
    public function updateStatus(Request $request,ApplicationParallaxBanner $application_parallax_banner){
        $application_parallax_banner->update([
          'is_active' => $application_parallax_banner->is_active == 1 ? 0:1
        ]);
        return response()->json(["state" => "success", "message" => trans('messages.response.application_parallax_banners.update_status_success'),"application_parallax_banners" => $this->getter($request)] );
    }

    /********* DELETE LANGUAGE ***********/
    public function destroy(Request $request,ApplicationParallaxBanner $application_parallax_banner)
    {
          $application_parallax_banner->delete();
          return response()->json(["state" => "success", "message" => trans('messages.response.application_parallax_banners.delete_success'),"application_parallax_banners" => $this->getter($request)] );
    }
}
