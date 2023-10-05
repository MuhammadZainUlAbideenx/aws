<?php

namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\Attribute;
use App\Http\Requests\CMS\Attributes\CreateRequest;
use App\Http\Resources\CMS\AttributesResource;
use Excel;
use App\Models\CMSModels\Product;
use DB;
use App\Exports\CMS\AttributesExport;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Setting;
use PDF;

class AttributesController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
      $this->middleware('auth:api');
      $this->middleware('permission:attributes.index,guard:api');
      $this->middleware('permission:attributes.create,guard:api',['only' => ['store']]);
      $this->middleware('permission:attributes.update,guard:api',['only' => ['update']]);
      $this->middleware('permission:attributes.delete,guard:api',['only' => ['destroy']]);
      $this->middleware('permission:attributes.update|attributes.is_active,guard:api',['only' => ['updateStatus']]);
  }

  /********* Getter For Pagination, Searching And Sorting  ***********/
  public function getter($req = null,$export = null)
  {
    if($req != null){
      $attributes = Attribute::withAll();
      if($req->column && $req->column != null && $req->search && $req->search != null){
        if($req->column == 'name'){
          $attributes = $attributes->whereLike($req->column.'->'.app()->getLocale(),$req->search);
        }
        else{
          $attributes = $attributes->whereLike($req->column,$req->search);
          }
        }
       else if($req->search && $req->search != null){
            $attributes = $attributes->whereLike(['name->'.app()->getLocale()],$req->search);
        }
      if($req->sort !=null && $req->sort["field"] != null && $req->sort["type"] != null){
        if($req->sort["field"] == 'name' || $req->sort["field"] =='description'){
          $locale = app()->getLocale();
          $attribute = $req->sort['field'].'->'."'$.$locale'";
          $attributes = $attributes->OrderBy(DB::raw("lower($attribute)"),$req->sort["type"]);
        }
        else{
          $attributes = $attributes->OrderBy($req->sort["field"],$req->sort["type"]);
        }
      }
      else
      {
        $attributes = $attributes->OrderBy('id','desc');

      }
      if($export != null){ // for export do not paginate
        $attributes = $attributes->get();
        return $attributes;
      }
      $totalAttributes = $attributes->count();
      $attributes = $attributes->paginate($req->perPage);
      $attributes = AttributesResource::collection($attributes)->response()->getData(true);
      return $attributes;
    }
    $attributes = AttributesResource::collection(Attribute::orderBy('id','desc')->withAll()->paginate(10))->response()->getData(true);
    return $attributes;
  }

  /********* FETCH ALL Attributes ***********/
    public function index()
    {
        $arrayName = array('attributes' => $this->getter());
        return response($arrayName);
    }
      /********* Export PDF , CSV And Excel  **********/
    public function export(Request $request)
    {
        $attributes = $this->getter($request,"export");
        if ($request->export == 'pdf') {
            $allSettings = Setting::where('name', 'web_logo_image_id')->first();
            $logo = Media::find((int)$allSettings->value);
            $new_logo = str_replace("/api/", "", $logo->original_media_path);
            $data['general'] = [
                'currentDate' => date("Y-m-d"),
                'fileName' => "Attributes",
                'reportName' => "Attributes",
                'logo' => $new_logo,
            ];
            $data['tableHeaders'] = ["Sr#", "Name", "Description", "Status"];
            $data['tableData'] = [];
            foreach ($attributes as $key => $attribute) {
                if ($attribute->is_active == 1) {
                    $is_active = "Active";
                } else {
                    $is_active = "Inactive";
                }

                $result = [++$key, $attribute->name, strip_tags($attribute->description),$is_active];
                $data['tableData'][] = $result;
            }
            $pdf = PDF::loadView('pdf.pages', $data);
            return $pdf->setPaper('A4', 'potrait')->download('attribute.pdf');
        }
        $filename = "attributes.".$request->export;
        return Excel::download(new AttributesExport($attributes), $filename);
    }

  /********* FILTER Attributes FOR Search ***********/
   public function filter(Request $request){
       return response()->json(["state" => "success", "message" => trans('messages.response.attributes.filter_success'),"attributes" => $this->getter($request)] );
   }

    /********* ADD NEW Attribute ***********/
    public function store(CreateRequest $request)
    {
      $attribute = Attribute::create($request->all());
      return response(["message" => trans('messages.response.attributes.create_success')]);
    }

    /********* View RECORD TO EDIT Or Display ***********/
    public function show( $attribute)
    {
        $attribute = Attribute::withAll()->find($attribute);
        return new AttributesResource($attribute);
    }

    /********* UPDATE Attribute ***********/
    public function update(CreateRequest $request, Attribute $attribute)
    {
      $attribute->update($request->all());
        return response(["message" => trans('messages.response.attributes.update_success')]);

    }

    /********* UPDATE Attribute Status***********/
    public function updateStatus(Request $request,Attribute $attribute){
        $attribute->update([
          'is_active' => $attribute->is_active == 1 ? 0:1
        ]);
        return response()->json(["state" => "success", "message" => trans('messages.response.attributes.update_status_success'),"attributes" => $this->getter($request)] );
    }


    /********* DELETE LANGUAGE ***********/
    public function destroy(Request $request,Attribute $attribute)
    {
        $products = Product::with('attributes')->whereHas('attributes',function ($q) use ($attribute){
          $q->where('attributes.id',$attribute->id);
        })->get();
        if(count($products) > 0){
          return response(["message" => trans('messages.response.attributes.attribute_attached_to_product')],422);
        }
          $attribute->delete();
          return response()->json(["state" => "success", "message" => trans('messages.response.attributes.delete_success'),"attributes" => $this->getter($request)] );
    }
}
