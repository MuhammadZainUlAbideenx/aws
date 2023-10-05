<?php

namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\Zone;
use App\Http\Requests\CMS\Zones\CreateRequest;
use App\Http\Resources\CMS\ZonesResource;
use Excel;
use App\Exports\CMS\ZonesExport;
use App\Http\Requests\CMS\Zones\UpdateRequest;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Setting;
use PDF;
class ZonesController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
      $this->middleware('auth:api',['except' =>['activeZones'] ]);
      $this->middleware('permission:zones.index,guard:api',['except' =>['activeZones'] ]);
      $this->middleware('permission:zones.create,guard:api',['only' => ['store']]);
      $this->middleware('permission:zones.update,guard:api',['only' => ['update']]);
      $this->middleware('permission:zones.delete,guard:api',['only' => ['destroy']]);
      $this->middleware('permission:zones.update|zones.is_active,guard:api',['only' => ['updateStatus']]);
  }

  /********* Getter For Pagination, Searching And Sorting  ***********/
  public function getter($req = null,$export = null)
  {
    if($req != null){
      $zones =  Zone::withAll();
      if($req->column && $req->column != null && $req->search && $req->search != null){
        $zones = $zones->whereLike($req->column,$req->search);
        }
       else if($req->search && $req->search != null){
            $zones = $zones->whereLike(['name','code','countries.name'],$req->search);
        }
      if($req->sort !=null && $req->sort["field"] != null && $req->sort["type"] != null){
        $zones = $zones->OrderBy($req->sort["field"],$req->sort["type"]);
      }
      else
      {
        $zones = $zones->OrderBy('id','desc');
      }
      if($export != null){ // for export do not paginate
        $zones = $zones->get();
        return $zones;
      }
      $totalZones = $zones->count();
      $zones = $zones->paginate($req->perPage);
      $zones = ZonesResource::collection($zones)->response()->getData(true);
      return $zones;
    }
    $zones = Zone::withAll()->orderBy('id','desc')->paginate(10);
    $zones = ZonesResource::collection($zones)->response()->getData(true);
    return $zones;
  }

  /********* FETCH ALL Zones ***********/
    public function index()
    {
        $arrayName = array('zones' => $this->getter());
        return response($arrayName);
    }
      /********* Export PDF , CSV And Excel  **********/
    public function export(Request $request)
    {
        $zones = $this->getter($request,"export");
        if ($request->export == 'pdf') {
            $allSettings = Setting::where('name', 'web_logo_image_id')->first();
            $logo = Media::find((int)$allSettings->value);
            $new_logo = str_replace("/api/", "", $logo->original_media_path);
            $data['general'] = [
                'currentDate' => date("Y-m-d"),
                'fileName' => "Zones",
                'reportName' => "Zones",
                'logo' => $new_logo,
            ];
            $data['tableHeaders'] = ["Sr#", "Country Name", "Zone Name", "Code", "Status"];
            $data['tableData'] = [];
            foreach ($zones as $key => $zone) {
                if ($zone->is_active == 1) {
                    $is_active = "Active";
                } else {
                    $is_active = "Inactive";
                }

                $result = [++$key, $zone->countries->name, $zone->name, $zone->code,$is_active];
                $data['tableData'][] = $result;
            }
            $pdf = PDF::loadView('pdf.pages', $data);
            return $pdf->setPaper('A4', 'potrait')->download('zones.pdf');
        }
        $filename = "zones.".$request->export;
        return Excel::download(new ZonesExport($zones), $filename);
    }

  /********* FILTER Zones FOR Search ***********/
   public function filter(Request $request){
       return response()->json(["state" => "success", "message" =>  trans('messages.response.zones.filter_success'),"zones" => $this->getter($request)] );
   }

    /********* ADD NEW Zone ***********/
    public function store(CreateRequest $request)
    {
      Zone::create($request->all());
      return response(["message" => trans('messages.response.zones.create_success')]);
    }

    /********* View RECORD TO EDIT Or Display ***********/
    public function show($zone)
    {
        $zone = Zone::withAll()->find($zone);
        return new ZonesResource($zone);
    }

    /********* UPDATE Zone ***********/
    public function update(UpdateRequest $request, Zone $zone)
    {
        $zone->update($request->all());
        return response(["message" => trans('messages.response.zones.update_success')]);
    }

    /********* UPDATE Manufacturer Status***********/
    public function updateStatus(Request $request,Zone $zone){
        $zone->update([
          'is_active' => $zone->is_active == 1 ? 0:1
        ]);
        return response()->json(["state" => "success", "message" => trans('messages.response.zones.update_status_success'),"zones" => $this->getter($request)] );
    }

    /********* DELETE LANGUAGE ***********/
    public function destroy(Request $request,Zone $zone)
    {
        if($zone->tax_rate){
          $zone->tax_rate()->delete();
        }
        if($zone->state){
          $zone->state()->delete();
        }
          $zone->delete();
          return response()->json(["state" => "success", "message" =>trans('messages.response.zones.delete_success'),"zones" => $this->getter($request)] );
    }
}
