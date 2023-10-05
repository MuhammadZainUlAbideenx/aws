<?php

namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\ApplicationBanner;
use App\Http\Requests\CMS\ApplicationBanners\CreateRequest;
use App\Http\Resources\CMS\ApplicationBannersResource;
use Excel;
use App\Exports\CMS\ApplicationBannersExport;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Setting;
use PDF;
class ApplicationBannersController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
      $this->middleware('auth:api');
      $this->middleware('permission:application_banners.index,guard:api');
      $this->middleware('permission:application_banners.create,guard:api',['only' => ['store']]);
      $this->middleware('permission:application_banners.update,guard:api',['only' => ['update']]);
      $this->middleware('permission:application_banners.delete,guard:api',['only' => ['destroy']]);
      $this->middleware('permission:application_banners.update|application_banners.is_active,guard:api',['only' => ['updateStatus']]);
  }

  /********* Getter For Pagination, Searching And Sorting  ***********/
  public function getter($req = null,$export = null)
  {
    if($req != null){
      $application_banners = new ApplicationBanner;
      if($req->column && $req->column != null && $req->search && $req->search != null){
        if($req->column == 'name'){
          $application_banners = $application_banners->whereLike($req->column.'->'.app()->getLocale(),$req->search);
        }
        else{
          $application_banners = $application_banners->whereLike($req->column,$req->search);
          }
        }
       else if($req->search && $req->search != null){
            $application_banners = $application_banners->whereLike(['name->'.app()->getLocale()],$req->search);
        }
      if($req->sort !=null && $req->sort["field"] != null && $req->sort["type"] != null){
        $application_banners = $application_banners->OrderBy($req->sort["field"],$req->sort["type"]);
      }
      else
      {
        $application_banners = $application_banners->OrderBy('id','desc');
      }
      if($export != null){ // for export do not paginate
        $application_banners = $application_banners->get();
        return $application_banners;
      }
      $totalApplicationBanners = $application_banners->count();
      $application_banners = $application_banners->paginate($req->perPage);
      $application_banners = ApplicationBannersResource::collection($application_banners)->response()->getData(true);
      return $application_banners;
    }
    $application_banners = ApplicationBannersResource::collection(ApplicationBanner::orderBy('id','desc')->paginate(10))->response()->getData(true);
    return $application_banners;
  }

  /********* FETCH ALL ApplicationBanners ***********/
    public function index()
    {
        $arrayName = array('application_banners' => $this->getter());
        return response($arrayName);
    }
      /********* Export PDF , CSV And Excel  **********/
    public function export(Request $request)
    {
        $application_banners = $this->getter($request,"export");
        if ($request->export == 'pdf') {
            $allSettings = Setting::where('name', 'web_logo_image_id')->first();
            $logo = Media::find((int)$allSettings->value);
            $new_logo = str_replace("/api/", "", $logo->original_media_path);
            $data['general'] = [
                'currentDate' => date("Y-m-d"),
                'fileName' => "Application Banners",
                'reportName' => "Application Banners",
                'logo' => $new_logo,
            ];
            $data['tableHeaders'] = ["Sr#", "Name", "Description", "Expiry Date", "Status"];
            $data['tableData'] = [];
            foreach ($application_banners as $key => $application_banner) {
                if ($application_banner->is_active == 1) {
                    $is_active = "Active";
                } else {
                    $is_active = "Inactive";
                }

                $result = [++$key, $application_banner->name, strip_tags($application_banner->description), date('d-m-Y', strtotime($application_banner->expiry_date)),$is_active];
                $data['tableData'][] = $result;
            }
            $pdf = PDF::loadView('pdf.pages', $data);
            return $pdf->setPaper('A4', 'potrait')->download('application_banners.pdf');
        }
        $filename = "application_banners.".$request->export;
        return Excel::download(new ApplicationBannersExport($application_banners), $filename);
    }

  /********* FILTER ApplicationBanners FOR Search ***********/
   public function filter(Request $request){
       return response()->json(["state" => "success", "message" => trans('messages.response.application_banners.filter_success'),"application_banners" => $this->getter($request)] );
   }

    /********* ADD NEW ApplicationBanner ***********/
    public function store(CreateRequest $request)
    {
      $application_banner = ApplicationBanner::create($request->all());
      return response(["message" => trans('messages.response.application_banners.create_success')]);
    }

    /********* View RECORD TO EDIT Or Display ***********/
    public function show(ApplicationBanner $application_banner)
    {
        return new ApplicationBannersResource($application_banner);
    }

    /********* UPDATE ApplicationBanner ***********/
    public function update(CreateRequest $request, ApplicationBanner $application_banner)
    {
      $application_banner->update($request->all());
        return response(["message" => trans('messages.response.application_banners.update_success')]);

    }

    /********* UPDATE Manufacturer Status***********/
    public function updateStatus(Request $request,ApplicationBanner $application_banner){
        $application_banner->update([
          'is_active' => $application_banner->is_active == 1 ? 0:1
        ]);
        return response()->json(["state" => "success", "message" => trans('messages.response.application_banners.update_status_success'),"application_banners" => $this->getter($request)] );
    }

    /********* DELETE LANGUAGE ***********/
    public function destroy(Request $request,ApplicationBanner $application_banner)
    {
          $application_banner->delete();
          return response()->json(["state" => "success", "message" => trans('messages.response.application_banners.delete_success'),"application_banners" => $this->getter($request)] );
    }
}
