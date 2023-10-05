<?php

namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\Manufacturer;
use App\Http\Requests\CMS\Manufacturers\CreateRequest;
use App\Http\Resources\CMS\ManufacturersResource;
use DB;
use Excel;
use Str;
use App\Exports\CMS\ManufacturersExport;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Setting;
use PDF;

class ManufacturersController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
      $this->middleware('auth:api');
      $this->middleware('permission:manufacturers.index,guard:api');
      $this->middleware('permission:manufacturers.create,guard:api',['only' => ['store']]);
      $this->middleware('permission:manufacturers.update,guard:api',['only' => ['update']]);
      $this->middleware('permission:manufacturers.delete,guard:api',['only' => ['destroy']]);
      $this->middleware('permission:manufacturers.update|manufacturers.is_active,guard:api',['only' => ['updateStatus']]);
  }

  /********* Getter For Pagination, Searching And Sorting  ***********/
  public function getter($req = null,$export = null)
  {
    if($req != null){
      $manufacturers = Manufacturer::withAll();
      if($req->column && $req->column != null && $req->search && $req->search != null){
        if($req->column == 'name'){
          $manufacturers = $manufacturers->whereLike($req->column.'->'.app()->getLocale(),$req->search);
        }
        else{
          $manufacturers = $manufacturers->whereLike($req->column,$req->search);
          }
        }
       else if($req->search && $req->search != null){

            $manufacturers = $manufacturers->whereLike(['name->'.app()->getLocale()],$req->search);
        }
      if($req->sort !=null && $req->sort["field"] != null && $req->sort["type"] != null){
        if($req->sort["field"] == 'name'){
          $locale = app()->getLocale();
          $attribute = $req->sort['field'].'->'."'$.$locale'";
          $manufacturers = $manufacturers->OrderBy(DB::raw("lower($attribute)"),$req->sort["type"]);
        }
        else{
          $manufacturers = $manufacturers->OrderBy($req->sort["field"],$req->sort["type"]);
        }
      }
      else
    {
        $manufacturers = $manufacturers->OrderBy('id','desc');
    }
      if($export != null){ // for export do not paginate
        $manufacturers = $manufacturers->get();
        return $manufacturers;
      }
      $totalManufacturers = $manufacturers->count();
      $manufacturers = $manufacturers->paginate($req->perPage);
      $manufacturers = ManufacturersResource::collection($manufacturers)->response()->getData(true);

      return $manufacturers;
    }
    $manufacturers = ManufacturersResource::collection(Manufacturer::withAll()->orderBy('id','desc')->paginate(10))->response()->getData(true);

    return $manufacturers;
  }

  /********* FETCH ALL Manufacturers ***********/
    public function index()
    {
        $arrayName = array('manufacturers' => $this->getter());
        return response($arrayName);
    }
      /********* Export PDF , CSV And Excel  **********/
    public function export(Request $request)
    {
        $manufacturers = $this->getter($request,"export");
        if ($request->export == 'pdf') {
            $allSettings = Setting::where('name', 'web_logo_image_id')->first();
            $logo = Media::find((int)$allSettings->value);
            $new_logo = str_replace("/api/", "", $logo->original_media_path);
            $data['general'] = [
                'currentDate' => date("Y-m-d"),
                'fileName' => "ManufacturerExport",
                'reportName' => "Manufacturer Report",
                'logo' => $new_logo,
            ];
            $data['tableHeaders'] = ["Sr#", "Name", "Slug", "Status"];
            $data['tableData'] = [];
            foreach ($manufacturers as $key => $manufacturer) {
                if ($manufacturer->is_active == 1) {
                    $is_active = "Active";
                } else {
                    $is_active = "inactive";
                }
                $result = [++$key, $manufacturer->name, $manufacturer->slug,$is_active];
                $data['tableData'][] = $result;
            }
            $pdf = PDF::loadView('pdf.pages', $data);
            return $pdf->setPaper('A4', 'potrait')->download('manufacturer.pdf');
        }
        $filename = "manufacturers.".$request->export;
        return Excel::download(new ManufacturersExport($manufacturers), $filename);
    }

  /********* FILTER Manufacturers FOR Search ***********/
   public function filter(Request $request){
       return response()->json(["state" => "success", "message" => trans('messages.response.manufacturers.filter_success'),"manufacturers" => $this->getter($request)] );
   }

    /********* ADD NEW Manufacturer ***********/
    public function store(CreateRequest $request)
    {
      $default_language = defaultLanguage();
      $name = $request->name;
      foreach ($name as $key => $value) {
        if($key == $default_language->code){
          $_slug = $value;
        }
      }
      $slug = Str::slug($_slug);
      $request->merge(["slug"=> $slug]);
      $manufacturer = Manufacturer::create($request->all());
      return response(["message" =>  trans('messages.response.manufacturers.create_success')]);
    }

    /********* View RECORD TO EDIT Or Display ***********/
    public function show( $manufacturer)
    {
        $manufacturer = Manufacturer::withAll()->find($manufacturer);
        return new ManufacturersResource($manufacturer);
    }

    /********* UPDATE Manufacturer ***********/
    public function update(CreateRequest $request, Manufacturer $manufacturer)
    {
      $default_language = defaultLanguage();
      $name = $request->name;
      foreach ($name as $key => $value) {
        if($key == $default_language->code){
          $_slug = $value;
        }
      }
      $slug = Str::slug($_slug);
      $request->merge(["slug"=> $slug]);
      $manufacturer->update($request->all());

        return response(["message" => trans('messages.response.manufacturers.update_success')]);

    }

    /********* UPDATE Manufacturer Status***********/
    public function updateStatus(Request $request,Manufacturer $manufacturer){
        $manufacturer->update([
          'is_active' => $manufacturer->is_active == 1 ? 0:1
        ]);
        return response()->json(["state" => "success", "message" => trans('messages.response.manufacturers.update_status_success'),"manufacturers" => $this->getter($request)] );
    }


    /********* DELETE LANGUAGE ***********/
    public function destroy(Request $request,Manufacturer $manufacturer)
    {
          $manufacturer->delete();
          return response()->json(["state" => "success", "message" => trans('messages.response.manufacturers.delete_success'),"manufacturers" => $this->getter($request)] );
    }
}
