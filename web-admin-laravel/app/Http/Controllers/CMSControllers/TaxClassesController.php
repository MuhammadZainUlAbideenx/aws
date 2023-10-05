<?php

namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\TaxClass;
use App\Http\Requests\CMS\TaxClasses\CreateRequest;
use App\Http\Resources\CMS\TaxClassesResource;
use Excel;
use App\Exports\CMS\TaxClassesExport;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Setting;
use App\Models\CMSModels\TaxRate;
use PDF;

class TaxClassesController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
      $this->middleware('auth:api');
      $this->middleware('permission:tax_classes.index,guard:api');
      $this->middleware('permission:tax_classes.create,guard:api',['only' => ['store']]);
      $this->middleware('permission:tax_classes.update,guard:api',['only' => ['update']]);
      $this->middleware('permission:tax_classes.delete,guard:api',['only' => ['destroy']]);
      $this->middleware('permission:tax_classes.update|tax_classes.is_active,guard:api',['only' => ['updateStatus']]);
  }

  /********* Getter For Pagination, Searching And Sorting  ***********/
  public function getter($req = null,$export = null)
  {
    if($req != null){
      $tax_classes = new TaxClass;
      if($req->column && $req->column != null && $req->search && $req->search != null){
        if($req->column == 'name'){
          $tax_classes = $tax_classes->whereLike($req->column.'->'.app()->getLocale(),$req->search);
        }
        else{
          $tax_classes = $tax_classes->whereLike($req->column,$req->search);
          }
        }
       else if($req->search && $req->search != null){
            $tax_classes = $tax_classes->whereLike(['name->'.app()->getLocale()],$req->search);
        }
      if($req->sort !=null && $req->sort["field"] != null && $req->sort["type"] != null){
        $tax_classes = $tax_classes->OrderBy($req->sort["field"],$req->sort["type"]);
      }
      else
      {
        $tax_classes = $tax_classes->OrderBy('id','desc');
      }
      if($export != null){ // for export do not paginate
        $tax_classes = $tax_classes->get();
        return $tax_classes;
      }
      $totalTaxClasses = $tax_classes->count();
      $tax_classes = $tax_classes->paginate($req->perPage);
      $tax_classes = TaxClassesResource::collection($tax_classes)->response()->getData(true);
      return $tax_classes;
    }
    $tax_classes = TaxClassesResource::collection(TaxClass::orderBy('id','desc')->paginate(10))->response()->getData(true);
    return $tax_classes;
  }

  /********* FETCH ALL TaxClasses ***********/
    public function index()
    {
        $arrayName = array('tax_classes' => $this->getter());
        return response($arrayName);
    }
      /********* Export PDF , CSV And Excel  **********/
    public function export(Request $request)
    {
        $tax_classes = $this->getter($request,"export");
        if ($request->export == 'pdf') {
            $allSettings = Setting::where('name', 'web_logo_image_id')->first();
            $logo = Media::find((int)$allSettings->value);
            $new_logo = str_replace("/api/", "", $logo->original_media_path);
            $data['general'] = [
                'currentDate' => date("Y-m-d"),
                'fileName' => "Tax Classes",
                'reportName' => "Tax Classes",
                'logo' => $new_logo,
            ];
            $data['tableHeaders'] = ["Sr#", "Name",  "Status"];
            $data['tableData'] = [];
            foreach ($tax_classes as $key => $tax_class) {
                if ($tax_class->is_active == 1) {
                    $is_active = "Active";
                } else {
                    $is_active = "Inactive";
                }

                $result = [++$key, $tax_class->name, $is_active];
                $data['tableData'][] = $result;
            }
            $pdf = PDF::loadView('pdf.pages', $data);
            return $pdf->setPaper('A4', 'potrait')->download('tax_class.pdf');
        }
        $filename = "tax_classes.".$request->export;
        return Excel::download(new TaxClassesExport($tax_classes), $filename);
    }

  /********* FILTER TaxClasses FOR Search ***********/
   public function filter(Request $request){
       return response()->json(["state" => "success", "message" => trans('messages.response.tax_classes.filter_success'),"tax_classes" => $this->getter($request)] );
   }

    /********* ADD NEW TaxClass ***********/
    public function store(CreateRequest $request)
    {
      $tax_class = TaxClass::create($request->all());
      return response(["message" => trans('messages.response.tax_classes.create_success')]);
    }

    /********* View RECORD TO EDIT Or Display ***********/
    public function show(TaxClass $tax_class)
    {
        return new TaxClassesResource($tax_class);
    }

    /********* UPDATE TaxClass ***********/
    public function update(CreateRequest $request, TaxClass $tax_class)
    {
      $tax_class->update($request->all());
        return response(["message" =>  trans('messages.response.tax_classes.update_success')]);

    }

    /********* UPDATE TaxClass Status***********/
    public function updateStatus(Request $request,TaxClass $tax_class){

        $tax_class->update([
          'is_active' => $tax_class->is_active == 1 ? 0:1
        ]);
        return response()->json(["state" => "success", "message" =>  trans('messages.response.tax_classes.update_status_success'),"tax_classes" => $this->getter($request)] );
    }


    /********* DELETE LANGUAGE ***********/
    public function destroy(Request $request,TaxClass $tax_class)
    {
          $tax_class->delete();
          return response()->json(["state" => "success", "message" => trans('messages.response.tax_classes.delete_success'),"tax_classes" => $this->getter($request)] );
    }
}
