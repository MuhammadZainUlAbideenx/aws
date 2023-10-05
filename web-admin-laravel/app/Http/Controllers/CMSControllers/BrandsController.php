<?php

namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\Brand;
use App\Http\Requests\CMS\Brands\CreateRequest;
use App\Http\Resources\CMS\BrandsResource;
use Excel;
use Str;
use DB;
use App\Exports\CMS\BrandsExport;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Setting;
use PDF;

class BrandsController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
      $this->middleware('auth:api');
      $this->middleware('permission:brands.index,guard:api');
      $this->middleware('permission:brands.create,guard:api',['only' => ['store']]);
      $this->middleware('permission:brands.update,guard:api',['only' => ['update']]);
      $this->middleware('permission:brands.delete,guard:api',['only' => ['destroy']]);
      $this->middleware('permission:brands.update|brands.is_active,guard:api',['only' => ['updateStatus']]);
  }

  /********* Getter For Pagination, Searching And Sorting  ***********/
  public function getter($req = null,$export = null)
  {
    if($req != null){
      $brands =  Brand::withAll();
      if($req->column && $req->column != null && $req->search && $req->search != null){
        if($req->column == 'name'){
          $brands = $brands->whereLike($req->column.'->'.app()->getLocale(),$req->search);
        }
        else{
          $brands = $brands->whereLike($req->column,$req->search);
          }
        }
       else if($req->search && $req->search != null){

            $brands = $brands->whereLike(['name->'.app()->getLocale()],$req->search);
        }
      if($req->sort !=null && $req->sort["field"] != null && $req->sort["type"] != null){
        if($req->sort["field"] == 'name'){
          $locale = app()->getLocale();
          $attribute = $req->sort['field'].'->'."'$.$locale'";
          $brands = $brands->OrderBy(DB::raw("lower($attribute)"),$req->sort["type"]);
        }
        else{
          $brands = $brands->OrderBy($req->sort["field"],$req->sort["type"]);
        }
      }
      else
      {
        $brands = $brands->OrderBy('id','desc');
      }
      if($export != null){ // for export do not paginate
        $brands = $brands->get();
        return $brands;
      }
      $totalBrands = $brands->count();
      $brands = $brands->paginate($req->perPage);
      $brands = BrandsResource::collection($brands)->response()->getData(true);

      return $brands;
    }
    $brands = BrandsResource::collection(Brand::withAll()->orderBy('id','desc')->paginate(10))->response()->getData(true);
    return $brands;
  }

  /********* FETCH ALL Brands ***********/
    public function index()
    {
        $arrayName = array('brands' => $this->getter());
        return response($arrayName);
    }
      /********* Export PDF , CSV And Excel  **********/
    public function export(Request $request)
    {
        $brands = $this->getter($request,"export");
        if ($request->export == 'pdf') {
            $allSettings = Setting::where('name', 'web_logo_image_id')->first();
            $logo = Media::find((int)$allSettings->value);
            $new_logo = str_replace("/api/", "", $logo->original_media_path);
            $data['general'] = [
                'currentDate' => date("Y-m-d"),
                'fileName' => "Brands",
                'reportName' => "Brands",
                'logo' => $new_logo,
            ];
            $data['tableHeaders'] = ["Sr#", "Name", "Featured", "Status"];
            $data['tableData'] = [];
            foreach ($brands as $key => $brand) {
                if ($brand->is_active == 1) {
                    $is_active = "Active";
                } else {
                    $is_active = "Inactive";
                }
                if ($brand->is_featured == 1) {
                    $is_featured = "Yes";
                } else {
                    $is_featured = "No";
                }
                $result = [++$key, $brand->name, $is_featured,$is_active];
                $data['tableData'][] = $result;
            }
            $pdf = PDF::loadView('pdf.pages', $data);
            return $pdf->setPaper('A4', 'potrait')->download('brand.pdf');
        }
        $filename = "brands.".$request->export;
        return Excel::download(new BrandsExport($brands), $filename);
    }

  /********* FILTER Brands FOR Search ***********/
   public function filter(Request $request){
       return response()->json(["state" => "success", "message" =>trans('messages.response.brands.filter_success'),"brands" => $this->getter($request)] );
   }

    /********* ADD NEW Brand ***********/
    public function store(CreateRequest $request)
    {
      $brand = Brand::create($request->all());
      return response(["message" =>  trans('messages.response.brands.create_success')]);
    }

    /********* View RECORD TO EDIT Or Display ***********/
    public function show( $brand)
    {
        $brand = Brand::withAll()->find($brand);
        return new BrandsResource($brand);
    }

    /********* UPDATE Brand ***********/
    public function update(CreateRequest $request, Brand $brand)
    {
        $brand->update($request->all());
        return response(["message" => trans('messages.response.brands.update_success')]);
    }

    /********* UPDATE Brand Status***********/
    public function updateStatus(Request $request,Brand $brand){
        $brand->update([
          'is_active' => $brand->is_active == 1 ? 0:1
        ]);
        return response()->json(["state" => "success", "message" => trans('messages.response.brands.update_status_success'),"brands" => $this->getter($request)] );
    }


    /********* DELETE LANGUAGE ***********/
    public function destroy(Request $request,Brand $brand)
    {
          $brand->delete();
          return response()->json(["state" => "success", "message" => trans('messages.response.brands.delete_success'),"brands" => $this->getter($request)] );
    }
}
