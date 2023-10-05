<?php

namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\Country;
use App\Http\Requests\CMS\Countries\CreateRequest;
use App\Http\Resources\CMS\CountriesResource;
use Excel;
use App\Exports\CMS\CountriesExport;
use App\Http\Requests\CMS\Countries\UpdateRequest;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Setting;
use PDF;


class CountriesController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
      $this->middleware('auth:api');
      $this->middleware('permission:countries.index,guard:api');
      $this->middleware('permission:countries.create,guard:api',['only' => ['store']]);
      $this->middleware('permission:countries.update,guard:api',['only' => ['update']]);
      $this->middleware('permission:countries.delete,guard:api',['only' => ['destroy']]);
      $this->middleware('permission:countries.update|countries.is_active,guard:api',['only' => ['updateStatus']]);
  }

  /********* Getter For Pagination, Searching And Sorting  ***********/
  public function getter($req = null,$export = null)
  {
    if($req != null){
      $countries = new  Country;
      if($req->column && $req->column != null && $req->search && $req->search != null){
        $countries = $countries->whereLike($req->column,$req->search);
        }
       else if($req->search && $req->search != null){
            $countries = $countries->whereLike(['name','iso_code_2','iso_code_3'],$req->search);
        }
      if($req->sort !=null && $req->sort["field"] != null && $req->sort["type"] != null){
        $countries = $countries->OrderBy($req->sort["field"],$req->sort["type"]);
      }
      else
      {
        $countries = $countries->OrderBy('id','desc');
      }
      if($export != null){ // for export do not paginate
        $countries = $countries->get();
        return $countries;
      }
      $totalCountries = $countries->count();
      $countries = $countries->paginate($req->perPage);
      $countries = CountriesResource::collection($countries)->response()->getData(true);
      return $countries;
    }
    $countries = Country::orderBy('id','desc')->paginate(10);
    $countries = CountriesResource::collection($countries)->response()->getData(true);
    return $countries;
  }

  /********* FETCH ALL Countries ***********/
    public function index()
    {
        $arrayName = array('countries' => $this->getter());
        return response($arrayName);
    }
      /********* Export PDF , CSV And Excel  **********/
    public function export(Request $request)
    {
        $countries = $this->getter($request,"export");
        if ($request->export == 'pdf') {
            $allSettings = Setting::where('name', 'web_logo_image_id')->first();
            $logo = Media::find((int)$allSettings->value);
            $new_logo = str_replace("/api/", "", $logo->original_media_path);
            $data['general'] = [
                'currentDate' => date("Y-m-d"),
                'fileName' => "Countries",
                'reportName' => "Countries",
                'logo' => $new_logo,
            ];
            $data['tableHeaders'] = ["Sr#", "Name", "ISO Code 2", "ISO Code 3", "Phone Code", "Capital", "Currency", "Currency Symbol", "Region", "Status"];
            $data['tableData'] = [];
            foreach ($countries as $key => $country) {
                if ($country->is_active == 1) {
                    $is_active = "Active";
                } else {
                    $is_active = "Inactive";
                }

                $result = [++$key, $country->name, $country->iso_code_2, $country->iso_code_3, $country->phone_code ,$country->capital, $country->currency, $country->currency_symbol,$country->region, $is_active];
                $data['tableData'][] = $result;
            }
            $pdf = PDF::loadView('pdf.pages', $data);
            return $pdf->setPaper('A4', 'potrait')->download('countries.pdf');
        }
        $filename = "countries.".$request->export;
        return Excel::download(new CountriesExport($countries), $filename);
    }

  /********* FILTER Countries FOR Search ***********/
   public function filter(Request $request){
       return response()->json(["state" => "success", "message" =>  trans('messages.response.countries.filter_success'),"countries" => $this->getter($request)] );
   }

    /********* ADD NEW Country ***********/
    public function store(CreateRequest $request)
    {
      Country::create($request->all());
      return response(["message" => trans('messages.response.countries.create_success')]);
    }

    /********* View RECORD TO EDIT Or Display ***********/
    public function show($country)
    {
        $country = Country::find($country);
        return new CountriesResource($country);
    }

    /********* UPDATE Country ***********/
    public function update(UpdateRequest $request, Country $country)
    {
        $country->update($request->all());
        return response(["message" =>  trans('messages.response.countries.update_success')]);
    }

    /********* UPDATE Manufacturer Status***********/
    public function updateStatus(Request $request,Country $country){
        $country->update([
          'is_active' => $country->is_active == 1 ? 0:1
        ]);
        return response()->json(["state" => "success", "message" =>  trans('messages.response.countries.update_status_success'),"countries" => $this->getter($request)] );
    }

    /********* DELETE LANGUAGE ***********/
    public function destroy(Request $request,Country $country)
    {
      if($country->cities){
        $country->cities()->delete();
      }
      if($country->zones){
        $country->zones()->delete();
      }
      if($country->states){
        $country->states()->delete();
      }
        $country->delete();
          return response()->json(["state" => "success", "message" =>  trans('messages.response.countries.delete_success'),"countries" => $this->getter($request)] );
    }
}
