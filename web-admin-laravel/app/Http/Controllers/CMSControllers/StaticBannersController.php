<?php

namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\StaticBanner;
use App\Http\Requests\CMS\StaticBanners\CreateRequest;
use App\Http\Resources\CMS\StaticBannersResource;
use Excel;
use App\Exports\CMS\StaticBannersExport;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Setting;
use PDF;
class StaticBannersController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
      $this->middleware('auth:api');
      $this->middleware('permission:static_banners.index,guard:api');
      $this->middleware('permission:static_banners.create,guard:api',['only' => ['store']]);
      $this->middleware('permission:static_banners.update,guard:api',['only' => ['update']]);
      $this->middleware('permission:static_banners.delete,guard:api',['only' => ['destroy']]);
      $this->middleware('permission:static_banners.update|static_banners.is_active,guard:api',['only' => ['updateStatus']]);
  }

  /********* Getter For Pagination, Searching And Sorting  ***********/
  public function getter($req = null,$export = null)
  {
    if($req != null){
      $static_banners = new StaticBanner;
      if($req->column && $req->column != null && $req->search && $req->search != null){
        if($req->column == 'name'){
          $static_banners = $static_banners->whereLike($req->column.'->'.app()->getLocale(),$req->search);
        }
        else{
          $static_banners = $static_banners->whereLike($req->column,$req->search);
          }
        }
       else if($req->search && $req->search != null){
            $static_banners = $static_banners->whereLike(['name->'.app()->getLocale()],$req->search);
        }
      if($req->sort !=null && $req->sort["field"] != null && $req->sort["type"] != null){
        $static_banners = $static_banners->OrderBy($req->sort["field"],$req->sort["type"]);
      }
      else
      {
        $static_banners = $static_banners->OrderBy('id','desc');
      }
      if($export != null){ // for export do not paginate
        $static_banners = $static_banners->get();
        return $static_banners;
      }
      $totalStaticBanners = $static_banners->count();
      $static_banners = $static_banners->paginate($req->perPage);
      $static_banners = StaticBannersResource::collection($static_banners)->response()->getData(true);
      return $static_banners;
    }
    $static_banners = StaticBannersResource::collection(StaticBanner::orderBy('id','desc')->paginate(10))->response()->getData(true);
    return $static_banners;
  }

  /********* FETCH ALL StaticBanners ***********/
    public function index()
    {
        $arrayName = array('static_banners' => $this->getter());
        return response($arrayName);
    }
      /********* Export PDF , CSV And Excel  **********/
    public function export(Request $request)
    {
        $static_banners = $this->getter($request,"export");
        if ($request->export == 'pdf') {
            $allSettings = Setting::where('name', 'web_logo_image_id')->first();
            $logo = Media::find((int)$allSettings->value);
            $new_logo = str_replace("/api/", "", $logo->original_media_path);
            $data['general'] = [
                'currentDate' => date("Y-m-d"),
                'fileName' => "Static Banners",
                'reportName' => "Static Banners",
                'logo' => $new_logo,
            ];
            $data['tableHeaders'] = ["Sr#", "Name","Type",  "Description", "Expiry Date" , "Status"];
            $data['tableData'] = [];
            foreach ($static_banners as $key => $static_banner) {
                if ($static_banner->is_active == 1) {
                    $is_active = "Active";
                } else {
                    $is_active = "Inactive";
                }
                $result = [++$key, $static_banner->name, $static_banner->type, strip_tags($static_banner->description),date('d-m-Y', strtotime($static_banner->expiry_date)),$is_active];
                $data['tableData'][] = $result;
            }
            $pdf = PDF::loadView('pdf.pages', $data);
            return $pdf->setPaper('A4', 'potrait')->download('static_banners.pdf');
        }
        $filename = "static_banners.".$request->export;
        return Excel::download(new StaticBannersExport($static_banners), $filename);
    }

  /********* FILTER StaticBanners FOR Search ***********/
   public function filter(Request $request){
       return response()->json(["state" => "success", "message" =>  trans('messages.response.static_banners.filter_success'),"static_banners" => $this->getter($request)] );
   }

    /********* ADD NEW StaticBanner ***********/
    public function store(CreateRequest $request)
    {
      $static_banner = StaticBanner::create($request->all());
      return response(["message" => trans('messages.response.static_banners.create_success')]);
    }

    /********* View RECORD TO EDIT Or Display ***********/
    public function show(StaticBanner $static_banner)
    {
        return new StaticBannersResource($static_banner);
    }

    /********* UPDATE StaticBanner ***********/
    public function update(CreateRequest $request, StaticBanner $static_banner)
    {
      $static_banner->update($request->all());
        return response(["message" => trans('messages.response.static_banners.update_success')]);

    }

    /********* UPDATE Manufacturer Status***********/
    public function updateStatus(Request $request,StaticBanner $static_banner){
        $static_banner->update([
          'is_active' => $static_banner->is_active == 1 ? 0:1
        ]);
        return response()->json(["state" => "success", "message" => trans('messages.response.static_banners.update_status_success'),"static_banners" => $this->getter($request)] );
    }

    /********* DELETE LANGUAGE ***********/
    public function destroy(Request $request,StaticBanner $static_banner)
    {
          $static_banner->delete();
          return response()->json(["state" => "success", "message" => trans('messages.response.static_banners.delete_success'),"static_banners" => $this->getter($request)] );
    }
}
