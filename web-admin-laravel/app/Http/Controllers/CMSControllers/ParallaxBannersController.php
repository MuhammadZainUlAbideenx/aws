<?php

namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\ParallaxBanner;
use App\Http\Requests\CMS\ParallaxBanners\CreateRequest;
use App\Http\Resources\CMS\ParallaxBannersResource;
use Excel;
use App\Exports\CMS\ParallaxBannersExport;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Setting;
use PDF;
class ParallaxBannersController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
      $this->middleware('auth:api');
      $this->middleware('permission:parallax_banners.index,guard:api');
      $this->middleware('permission:parallax_banners.create,guard:api',['only' => ['store']]);
      $this->middleware('permission:parallax_banners.update,guard:api',['only' => ['update']]);
      $this->middleware('permission:parallax_banners.delete,guard:api',['only' => ['destroy']]);
      $this->middleware('permission:parallax_banners.update|parallax_banners.is_active,guard:api',['only' => ['updateStatus']]);
  }

  /********* Getter For Pagination, Searching And Sorting  ***********/
  public function getter($req = null,$export = null)
  {
    if($req != null){
      $parallax_banners = new ParallaxBanner;
      if($req->column && $req->column != null && $req->search && $req->search != null){
        if($req->column == 'name'){
          $parallax_banners = $parallax_banners->whereLike($req->column.'->'.app()->getLocale(),$req->search);
        }
        else{
          $parallax_banners = $parallax_banners->whereLike($req->column,$req->search);
          }
        }
       else if($req->search && $req->search != null){
            $parallax_banners = $parallax_banners->whereLike(['name->'.app()->getLocale()],$req->search);
        }
      if($req->sort !=null && $req->sort["field"] != null && $req->sort["type"] != null){
        $parallax_banners = $parallax_banners->OrderBy($req->sort["field"],$req->sort["type"]);
      }
      else
      {
        $parallax_banners = $parallax_banners->OrderBy('id','desc');
      }
      if($export != null){ // for export do not paginate
        $parallax_banners = $parallax_banners->get();
        return $parallax_banners;
      }
      $totalParallaxBanners = $parallax_banners->count();
      $parallax_banners = $parallax_banners->paginate($req->perPage);
      $parallax_banners = ParallaxBannersResource::collection($parallax_banners)->response()->getData(true);
      return $parallax_banners;
    }
    $parallax_banners = ParallaxBannersResource::collection(ParallaxBanner::orderBy('id','desc')->paginate(10))->response()->getData(true);
    return $parallax_banners;
  }

  /********* FETCH ALL ParallaxBanners ***********/
    public function index()
    {
        $arrayName = array('parallax_banners' => $this->getter());
        return response($arrayName);
    }
      /********* Export PDF , CSV And Excel  **********/
    public function export(Request $request)
    {
        $parallax_banners = $this->getter($request,"export");
        if ($request->export == 'pdf') {
            $allSettings = Setting::where('name', 'web_logo_image_id')->first();
            $logo = Media::find((int)$allSettings->value);
            $new_logo = str_replace("/api/", "", $logo->original_media_path);
            $data['general'] = [
                'currentDate' => date("Y-m-d"),
                'fileName' => "Parallax Banners",
                'reportName' => "Parallax Banners",
                'logo' => $new_logo,
            ];
            $data['tableHeaders'] = ["Sr#", "Name", "Description", "Expiry Date", "Status"];
            $data['tableData'] = [];
            foreach ($parallax_banners as $key => $parallax_banner) {
                if ($parallax_banner->is_active == 1) {
                    $is_active = "Active";
                } else {
                    $is_active = "Inactive";
                }

                $result = [++$key, $parallax_banner->name, strip_tags($parallax_banner->description),date('d-m-Y',strtotime($parallax_banner->expiry_date)),$is_active];
                $data['tableData'][] = $result;
            }
            $pdf = PDF::loadView('pdf.pages', $data);
            return $pdf->setPaper('A4', 'potrait')->download('parallax_banners.pdf');
        }
        $filename = "parallax_banners.".$request->export;
        return Excel::download(new ParallaxBannersExport($parallax_banners), $filename);
    }

  /********* FILTER ParallaxBanners FOR Search ***********/
   public function filter(Request $request){
       return response()->json(["state" => "success", "message" =>trans('messages.response.parallax_banners.filter_success'),"parallax_banners" => $this->getter($request)] );
   }

    /********* ADD NEW ParallaxBanner ***********/
    public function store(CreateRequest $request)
    {
      $parallax_banner = ParallaxBanner::create($request->all());
      return response(["message" => trans('messages.response.parallax_banners.create_success')]);
    }

    /********* View RECORD TO EDIT Or Display ***********/
    public function show(ParallaxBanner $parallax_banner)
    {
        return new ParallaxBannersResource($parallax_banner);
    }

    /********* UPDATE ParallaxBanner ***********/
    public function update(CreateRequest $request, ParallaxBanner $parallax_banner)
    {
      $parallax_banner->update($request->all());
        return response(["message" => trans('messages.response.parallax_banners.update_success')]);

    }

    /********* UPDATE Manufacturer Status***********/
    public function updateStatus(Request $request,ParallaxBanner $parallax_banner){
        $parallax_banner->update([
          'is_active' => $parallax_banner->is_active == 1 ? 0:1
        ]);
        return response()->json(["state" => "success", "message" => trans('messages.response.parallax_banners.update_status_success'),"parallax_banners" => $this->getter($request)] );
    }

    /********* DELETE LANGUAGE ***********/
    public function destroy(Request $request,ParallaxBanner $parallax_banner)
    {
          $parallax_banner->delete();
          return response()->json(["state" => "success", "message" => trans('messages.response.parallax_banners.delete_success'),"parallax_banners" => $this->getter($request)] );
    }
}
