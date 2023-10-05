<?php

namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\Unit;
use App\Http\Requests\CMS\Units\CreateRequest;
use App\Http\Resources\CMS\UnitsResource;
use Excel;
use DB;
use App\Exports\CMS\UnitsExport;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Setting;
use PDF;

class UnitsController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
      $this->middleware('auth:api');
      $this->middleware('permission:units.index,guard:api');
      $this->middleware('permission:units.create,guard:api',['only' => ['store']]);
      $this->middleware('permission:units.update,guard:api',['only' => ['update']]);
      $this->middleware('permission:units.delete,guard:api',['only' => ['destroy']]);
      $this->middleware('permission:units.update|units.is_active,guard:api',['only' => ['updateStatus']]);
  }

  /********* Getter For Pagination, Searching And Sorting  ***********/
  public function getter($req = null,$export = null)
  {
    if($req != null){
      $units = new Unit;
      if($req->column && $req->column != null && $req->search && $req->search != null){
        if($req->column == 'name'){
          $units = $units->whereLike($req->column.'->'.app()->getLocale(),$req->search);
        }
        else{
          $units = $units->whereLike($req->column,$req->search);
          }
        }
       else if($req->search && $req->search != null){
            $units = $units->whereLike(['name->'.app()->getLocale()],$req->search);
        }
      if($req->sort !=null && $req->sort["field"] != null && $req->sort["type"] != null){
        if($req->sort["field"] == 'name'){
          $locale = app()->getLocale();
          $attribute = $req->sort['field'].'->'."'$.$locale'";
          $units = $units->OrderBy(DB::raw("lower($attribute)"),$req->sort["type"]);
        }
        else{
          $units = $units->OrderBy($req->sort["field"],$req->sort["type"]);
        }
      }
      else
      {
        $units = $units->OrderBy('id','desc');
      }
      if($export != null){ // for export do not paginate
        $units = $units->get();
        return $units;
      }
      $totalUnits = $units->count();
      $units = $units->paginate($req->perPage);
      $units = UnitsResource::collection($units)->response()->getData(true);
      return $units;
    }
    $units = UnitsResource::collection(Unit::orderBy('id','desc')->paginate(10))->response()->getData(true);
    return $units;
  }

  /********* FETCH ALL Units ***********/
    public function index()
    {
        $arrayName = array('units' => $this->getter());
        return response($arrayName);
    }
      /********* Export PDF , CSV And Excel  **********/
    public function export(Request $request)
    {
        $units = $this->getter($request,"export");
        if ($request->export == 'pdf') {
            $allSettings = Setting::where('name', 'web_logo_image_id')->first();
            $logo = Media::find((int)$allSettings->value);
            $new_logo = str_replace("/api/", "", $logo->original_media_path);
            $data['general'] = [
                'currentDate' => date("Y-m-d"),
                'fileName' => "Units",
                'reportName' => "Units",
                'logo' => $new_logo,
            ];
            $data['tableHeaders'] = ["Sr#", "Name", "Status"];
            $data['tableData'] = [];
            foreach ($units as $key => $unit) {
                if ($unit->is_active == 1) {
                    $is_active = "Active";
                } else {
                    $is_active = "Inactive";
                }

                $result = [++$key, $unit->name, $is_active];
                $data['tableData'][] = $result;
            }
            $pdf = PDF::loadView('pdf.pages', $data);
            return $pdf->setPaper('A4', 'potrait')->download('unit.pdf');
        }
        $filename = "units.".$request->export;
        return Excel::download(new UnitsExport($units), $filename);
    }

  /********* FILTER Units FOR Search ***********/
   public function filter(Request $request){
       return response()->json(["state" => "success", "message" =>trans('messages.response.units.filter_success'),"units" => $this->getter($request)] );
   }

    /********* ADD NEW Unit ***********/
    public function store(CreateRequest $request)
    {
      $unit = Unit::create($request->all());
      return response(["message" => trans('messages.response.units.create_success')]);
    }

    /********* View RECORD TO EDIT Or Display ***********/
    public function show(Unit $unit)
    {
        return new UnitsResource($unit);
    }

    /********* UPDATE Unit ***********/
    public function update(CreateRequest $request, Unit $unit)
    {
      $unit->update($request->all());
        return response(["message" => trans('messages.response.units.update_success')]);

    }

    /********* UPDATE Unit Status***********/
    public function updateStatus(Request $request,Unit $unit){
        $unit->update([
          'is_active' => $unit->is_active == 1 ? 0:1
        ]);
        return response()->json(["state" => "success", "message" => trans('messages.response.units.update_status_success'),"units" => $this->getter($request)] );
    }


    /********* DELETE LANGUAGE ***********/
    public function destroy(Request $request,Unit $unit)
    {
          $unit->delete();
          return response()->json(["state" => "success", "message" => trans('messages.response.units.delete_success'),"units" => $this->getter($request)] );
    }
}
