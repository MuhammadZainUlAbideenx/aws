<?php

namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\Currency;
use App\Http\Requests\CMS\Currencies\CreateRequest;
use App\Http\Resources\CMS\CurrenciesResource;
use Excel;
use App\Exports\CMS\CurrenciesExport;
use App\Http\Requests\CMS\Currencies\UpdateRequest;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Setting;
use PDF;

class CurrenciesController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
      $this->middleware('auth:api');
      $this->middleware('permission:currencies.index,guard:api');
      $this->middleware('permission:currencies.create,guard:api',['only' => ['store']]);
      $this->middleware('permission:currencies.update,guard:api',['only' => ['update']]);
      $this->middleware('permission:currencies.delete,guard:api',['only' => ['destroy']]);
      $this->middleware('permission:currencies.update|currencies.is_active,guard:api',['only' => ['updateStatus']]);
  }

  /********* Getter For Pagination, Searching And Sorting  ***********/
  public function getter($req = null,$export = null)
  {
    if($req != null){
      $currencies = new Currency;
      if($req->column && $req->column != null && $req->search && $req->search != null){
        $currencies = $currencies->whereLike($req->column,$req->search);
        }
       else if($req->search && $req->search != null){
            $currencies = $currencies->whereLike(['name','code','symbol'],$req->search);
        }
      if($req->sort !=null && $req->sort["field"] != null && $req->sort["type"] != null){
        $currencies = $currencies->OrderBy($req->sort["field"],$req->sort["type"]);
      }
      else
      {
        $currencies = $currencies->OrderBy('id','desc');
      }
      if($export != null){ // for export do not paginate
        $currencies = $currencies->get();
        return $currencies;
      }
      $totalCurrencies = $currencies->count();
      $currencies = $currencies->paginate($req->perPage);
      $currencies = CurrenciesResource::collection($currencies)->response()->getData(true);
      return $currencies;
    }
    $currencies = Currency::orderBy('id','desc')->paginate(10);
    $currencies = CurrenciesResource::collection($currencies)->response()->getData(true);
    return $currencies;
  }

  /********* FETCH ALL Currencies ***********/
    public function index()
    {
        $arrayName = array('currencies' => $this->getter());
        return response($arrayName);
    }
      /********* Export PDF , CSV And Excel  **********/
    public function export(Request $request)
    {
        $currencies = $this->getter($request,"export");
        if ($request->export == 'pdf') {
            $allSettings = Setting::where('name', 'web_logo_image_id')->first();
            $logo = Media::find((int)$allSettings->value);
            $new_logo = str_replace("/api/", "", $logo->original_media_path);
            $data['general'] = [
                'currentDate' => date("Y-m-d"),
                'fileName' => "Currencies",
                'reportName' => "Currencies",
                'logo' => $new_logo,
            ];
            $data['tableHeaders'] = ["Sr#", "Name", "Code", "Symbol", "Direction", "Value", "Status"];
            $data['tableData'] = [];
            foreach ($currencies as $key => $currency) {
                if ($currency->is_active == 1) {
                    $is_active = "Active";
                } else {
                    $is_active = "Inactive";
                }

                $result = [++$key, $currency->name, $currency->code, $currency->symbol, $currency->direction, $currency->value, $is_active];
                $data['tableData'][] = $result;
            }
            $pdf = PDF::loadView('pdf.pages', $data);
            return $pdf->setPaper('A4', 'potrait')->download('currencies.pdf');
        }
        $filename = "currencies.".$request->export;
        return Excel::download(new CurrenciesExport($currencies), $filename);
    }

  /********* FILTER Currencies FOR Search ***********/
   public function filter(Request $request){
       return response()->json(["state" => "success", "message" => trans('messages.response.currencies.filter_success'),"currencies" => $this->getter($request)] );
   }

    /********* ADD NEW Currency ***********/
    public function store(CreateRequest $request)
    {
      if($request->is_default){
        Currency::where('is_default',1)->update([
          'is_default' => 0
        ]);
      }

      Currency::create($request->all());
      UpdateCacheSettings();
      return response(["message" => trans('messages.response.currencies.create_success')]);
    }

    /********* View RECORD TO EDIT Or Display ***********/
    public function show(Currency $currency)
    {
        return new CurrenciesResource($currency);
    }

    /********* UPDATE Currency ***********/
    public function update(UpdateRequest $request, Currency $currency)
    {
      if($currency->code == 'USD' || $currency->code == 'usd'){
        $data = $request->except(['code']);
      }
      else{
        $data = $request->all();
      }
      if($request->is_default && !$currency->is_default){
        Currency::where('is_default',1)->update([
          'is_default' => 0
        ]);
        $data['value'] = 1;
        $currency->update($data);
        UpdateCacheSettings();
        return response(["message" => trans('messages.response.currencies.update_success')]);
      }
      else if($currency->is_default && !$request->is_default){
        return response(["state" => "fail","message" => trans('messages.response.currencies.one_must_default')]);
      }
      else{
        $currency->update($data);
        UpdateCacheSettings();
        return response(["message" => trans('messages.response.currencies.update_success')]);
      }

    }

    /********* UPDATE Currency Status***********/
    public function updateStatus(Request $request,Currency $currency){
       if($currency->is_default){
        return response()->json(["state" => "fail","message" => trans('messages.response.currencies.cannot_desable_default')]);
      }
      else{
        $currency->update([
          'is_active' => $currency->is_active == 1 ? 0:1
        ]);
        UpdateCacheSettings();
        return response()->json(["state" => "success", "message" => trans('messages.response.currencies.update_status_success'),"currencies" => $this->getter($request)] );
      }
    }

    /********* UPDATE Default Currency ***********/

    public function updateDefault(Request $request,Currency $currency){
      if($currency->is_default){
        return response()->json(["state" => "fail","message" => trans('messages.response.currencies.one_must_default')]);
      }
      else{
        Currency::where('is_default',1)->update([
          'is_default' => 0
        ]);
        $currency->update([
          'is_default' => 1,
          'value' => 1,
          'is_active' => 1
        ]);
        UpdateCacheSettings();
        return response()->json(["state" => "success", "message" => trans('messages.response.currencies.update_default_success'),"currencies" => $this->getter($request)] );
      }
    }

    /********* DELETE LANGUAGE ***********/
    public function destroy(Request $request,Currency $currency)
    {
        if($currency->code == 'USD' || $currency->code == 'usd'){
          return response()->json(["state" => "fail","message" => trans('messages.response.currencies.cannot_delete_usd')]);
        }
        else if($currency->is_default){
          return response()->json(["state" => "fail","message" => trans('messages.response.currencies.cannot_delete_default')]);
        }
        else{
          $currency->delete();
          return response()->json(["state" => "success", "message" => trans('messages.response.currencies.delete_success'),"currencies" => $this->getter($request)] );
        }
    }
}
