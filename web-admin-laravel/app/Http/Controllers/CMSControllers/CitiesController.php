<?php

namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\City;
use App\Http\Requests\CMS\Cities\CreateRequest;
use App\Http\Resources\CMS\CitiesResource;
use Excel;
use App\Exports\CMS\CitiesExport;
use App\Http\Requests\CMS\Cities\UpdateRequest;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Setting;
use PDF;

class CitiesController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
      $this->middleware('auth:api');
      $this->middleware('permission:cities.index,guard:api');
      $this->middleware('permission:cities.create,guard:api',['only' => ['store']]);
      $this->middleware('permission:cities.update,guard:api',['only' => ['update']]);
      $this->middleware('permission:cities.delete,guard:api',['only' => ['destroy']]);
      $this->middleware('permission:cities.update|cities.is_active,guard:api',['only' => ['updateStatus']]);
  }

  /********* Getter For Pagination, Searching And Sorting  ***********/
  public function getter($req = null,$export = null)
  {

      if($req != null){
          $cities = City::withAll();
      if($req->column && $req->column != null && $req->search && $req->search != null){
        $cities = $cities->whereLike($req->column,$req->search);
        }
       else if($req->search && $req->search != null){
            $cities = $cities->whereLike(['name','code','countries.name','state.name'],$req->search);
        }
      if($req->sort !=null && $req->sort["field"] != null && $req->sort["type"] != null){
        $cities = $cities->OrderBy($req->sort["field"],$req->sort["type"]);
      }
      else
    {
        $cities = $cities->OrderBy('id','desc');
    }
      if($export != null){ // for export do not paginate
        // $cities = $cities->take($req->perPage)->get();
        $cities = $cities->get();
        return $cities;
      }
      $totalCities = $cities->count();
      $cities = $cities->paginate($req->perPage);
      $cities = CitiesResource::collection($cities)->response()->getData(true);
      return $cities;
    }
    $cities = City::withAll()->orderBy('id','desc')->paginate(10);
    $cities = CitiesResource::collection($cities)->response()->getData(true);
    return $cities;
  }

  /********* FETCH ALL Cities ***********/
    public function index()
    {
        $arrayName = array('cities' => $this->getter());
        return response($arrayName);
    }
      /********* Export PDF , CSV And Excel  **********/
    public function export(Request $request)
    {
        $cities = $this->getter($request,"export");
        if ($request->export == 'pdf') {
            $allSettings = Setting::where('name', 'web_logo_image_id')->first();
            $logo = Media::find((int)$allSettings->value);
            $new_logo = str_replace("/api/", "", $logo->original_media_path);
            $data['general'] = [
                'currentDate' => date("Y-m-d"),
                'fileName' => "Cities",
                'reportName' => "Cities",
                'logo' => $new_logo,
            ];
            $data['tableHeaders'] = ["Sr#", "Name", "Code", "Country", "State", "Status"];
            $data['tableData'] = [];
            foreach ($cities as $key => $city) {
                if ($city->is_active == 1) {
                    $is_active = "Active";
                } else {
                    $is_active = "Inactive";
                }
                $result = [++$key, $city->name, $city->code, $city->countries ? $city->countries->name : "", $city->state ? $city->state->name : "", $is_active];
                $data['tableData'][] = $result;
            }
            $pdf = PDF::loadView('pdf.pages', $data);
            return $pdf->setPaper('A4', 'potrait')->download('cities.pdf');
        }
        $filename = "cities.".$request->export;
        return Excel::download(new CitiesExport($cities), $filename);
    }

  /********* FILTER Cities FOR Search ***********/
   public function filter(Request $request){
       return response()->json(["state" => "success", "message" => trans('messages.response.cities.filter_success'),"cities" => $this->getter($request)] );
   }

    /********* ADD NEW City ***********/
    public function store(CreateRequest $request)
    {
      City::create($request->all());
      return response(["message" => trans('messages.response.cities.create_success')]);
    }

    /********* View RECORD TO EDIT Or Display ***********/
    public function show($city)
    {
        $city = City::withAll()->find($city);
        return new CitiesResource($city);
    }

    /********* UPDATE City ***********/
    public function update(UpdateRequest $request, City $city)
    {
        $city->update($request->all());
        return response(["message" => trans('messages.response.cities.update_success')]);
    }

    /********* UPDATE Manufacturer Status***********/
    public function updateStatus(Request $request,City $city){
        $city->update([
          'is_active' => $city->is_active == 1 ? 0:1
        ]);
        return response()->json(["state" => "success", "message" => trans('messages.response.cities.update_status_success'),"cities" => $this->getter($request)] );
    }

    /********* DELETE LANGUAGE ***********/
    public function destroy(Request $request,City $city)
    {
          $city->delete();
          return response()->json(["state" => "success", "message" => trans('messages.response.cities.delete_success'),"cities" => $this->getter($request)] );
    }
}
