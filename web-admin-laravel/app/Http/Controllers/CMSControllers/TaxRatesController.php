<?php

namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\TaxRate;
use App\Http\Requests\CMS\TaxRates\CreateRequest;
use App\Http\Resources\CMS\TaxRatesResource;
use Excel;
use App\Exports\CMS\TaxRatesExport;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Setting;
use PDF;
class TaxRatesController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
      $this->middleware('auth:api',['except' =>['activeTaxRates'] ]);
      $this->middleware('permission:tax_rates.index,guard:api',['except' =>['activeTaxRates'] ]);
      $this->middleware('permission:tax_rates.create,guard:api',['only' => ['store']]);
      $this->middleware('permission:tax_rates.update,guard:api',['only' => ['update']]);
      $this->middleware('permission:tax_rates.delete,guard:api',['only' => ['destroy']]);
      $this->middleware('permission:tax_rates.update|tax_rates.is_active,guard:api',['only' => ['updateStatus']]);
  }

  /********* Getter For Pagination, Searching And Sorting  ***********/
  public function getter($req = null,$export = null)
  {
    if($req != null){
      $tax_rates = TaxRate::withAll();
      if($req->column && $req->column != null && $req->search && $req->search != null){
        $tax_rates = $tax_rates->whereLike($req->column,$req->search);
        }
       else if($req->search && $req->search != null){
            $tax_rates = $tax_rates->whereLike(['rate','zone.name','tax_class.name'],$req->search);
        }
      if($req->sort !=null && $req->sort["field"] != null && $req->sort["type"] != null){
        $tax_rates = $tax_rates->OrderBy($req->sort["field"],$req->sort["type"]);
      }
      else
      {
        $tax_rates = $tax_rates->OrderBy('id','desc');
      }
      if($export != null){ // for export do not paginate
        $tax_rates = $tax_rates->get();
        return $tax_rates;
      }
      $totalTaxRates = $tax_rates->count();
      $tax_rates = $tax_rates->paginate($req->perPage);
      $tax_rates = TaxRatesResource::collection($tax_rates)->response()->getData(true);
      return $tax_rates;
    }
    $tax_rates = TaxRate::withAll()->orderBy('id','desc')->paginate(10);
    $tax_rates = TaxRatesResource::collection($tax_rates)->response()->getData(true);
    return $tax_rates;
  }

  /********* FETCH ALL TaxRates ***********/
    public function index()
    {
        $arrayName = array('tax_rates' => $this->getter());
        return response($arrayName);
    }
      /********* Export PDF , CSV And Excel  **********/
    public function export(Request $request)
    {
        $tax_rates = $this->getter($request,"export");
        if ($request->export == 'pdf') {
            $allSettings = Setting::where('name', 'web_logo_image_id')->first();
            $logo = Media::find((int)$allSettings->value);
            $new_logo = str_replace("/api/", "", $logo->original_media_path);
            $data['general'] = [
                'currentDate' => date("Y-m-d"),
                'fileName' => "Tax Rate",
                'reportName' => "Tax Rate",
                'logo' => $new_logo,
            ];
            $data['tableHeaders'] = ["Sr#", "Rate", "Zone", "Tax Class", "Status"];
            $data['tableData'] = [];
            foreach ($tax_rates as $key => $tax_rate) {
                if ($tax_rate->is_active == 1) {
                    $is_active = "Active";
                } else {
                    $is_active = "Inactive";
                }

                $result = [++$key, $tax_rate->rate, $tax_rate->zone ? $tax_rate->zone->name : "",$tax_rate->tax_class ? $tax_rate->tax_class->name : "",$is_active];
                $data['tableData'][] = $result;
            }
            $pdf = PDF::loadView('pdf.pages', $data);
            return $pdf->setPaper('A4', 'potrait')->download('tax_rate.pdf');
        }
        $filename = "tax_rates.".$request->export;
        return Excel::download(new TaxRatesExport($tax_rates), $filename);
    }

  /********* FILTER TaxRates FOR Search ***********/
   public function filter(Request $request){
       return response()->json(["state" => "success", "message" => trans('messages.response.tax_rates.filter_success'),"tax_rates" => $this->getter($request)] );
   }

    /********* ADD NEW TaxRate ***********/
    public function store(CreateRequest $request)
    {
      TaxRate::create($request->all());
      return response(["message" => trans('messages.response.tax_rates.create_success')]);
    }

    /********* View RECORD TO EDIT Or Display ***********/
    public function show( $tax_rate)
    {
        $tax_rate = TaxRate::withAll()->find($tax_rate);
        return new TaxRatesResource($tax_rate);
    }

    /********* UPDATE TaxRate ***********/
    public function update(CreateRequest $request, TaxRate $tax_rate)
    {
        $tax_rate->update($request->all());
        return response(["message" => trans('messages.response.tax_rates.update_success')]);
    }

    /********* UPDATE Manufacturer Status***********/
    public function updateStatus(Request $request,TaxRate $tax_rate){
        $tax_rate->update([
          'is_active' => $tax_rate->is_active == 1 ? 0:1
        ]);
        return response()->json(["state" => "success", "message" => trans('messages.response.tax_rates.update_status_success'),"tax_rates" => $this->getter($request)] );
    }

    /********* DELETE LANGUAGE ***********/
    public function destroy(Request $request,TaxRate $tax_rate)
    {
          $tax_rate->delete();
          return response()->json(["state" => "success", "message" => trans('messages.response.tax_rates.delete_success'),"tax_rates" => $this->getter($request)] );
    }
}
