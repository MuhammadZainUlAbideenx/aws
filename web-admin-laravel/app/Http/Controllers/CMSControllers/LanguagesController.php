<?php

namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\Language;
use App\Http\Requests\CMS\Languages\CreateRequest;
use App\Http\Resources\CMS\LanguagesResource;
use Excel;
use App\Exports\CMS\LanguagesExport;
use App\Http\Requests\CMS\Languages\UpdateRequest;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Setting;
use PDF;

class LanguagesController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
      $this->middleware('auth:api');
      $this->middleware('permission:languages.index,guard:api');
      $this->middleware('permission:languages.create,guard:api',['only' => ['store']]);
      $this->middleware('permission:languages.update,guard:api',['only' => ['update']]);
      $this->middleware('permission:languages.delete,guard:api',['only' => ['destroy']]);
      $this->middleware('permission:languages.update|languages.is_active,guard:api',['only' => ['updateStatus']]);
  }

  /********* Getter For Pagination, Searching And Sorting  ***********/
  public function getter($req = null,$export = null)
  {
    if($req != null){
      $languages = new Language;
      if($req->column && $req->column != null && $req->search && $req->search != null){
        $languages = $languages->whereLike($req->column,$req->search);
        }
       else if($req->search && $req->search != null){
            $languages = $languages->whereLike(['name','code','direction'],$req->search);
        }
      if($req->sort !=null && $req->sort["field"] != null && $req->sort["type"] != null){
        $languages = $languages->OrderBy($req->sort["field"],$req->sort["type"]);
      }
      else
      {
        $languages = $languages->OrderBy('id','desc');
      }
      if($export != null){ // for export do not paginate
        $languages = $languages->get();
        return $languages;
      }
      $totalLanguages = $languages->count();
      $languages = $languages->paginate($req->perPage);
      $languages = LanguagesResource::collection($languages)->response()->getData(true);
      return $languages;
    }
    $languages = Language::orderBy('id','desc')->paginate(10);
    $languages = LanguagesResource::collection($languages)->response()->getData(true);
    return $languages;
  }

  /********* FETCH ALL Languages ***********/
    public function index()
    {
        $arrayName = array('languages' => $this->getter());
        return response($arrayName);
    }
      /********* Export PDF , CSV And Excel  **********/
    public function export(Request $request)
    {
        $languages = $this->getter($request,"export");
        if ($request->export == 'pdf') {
            $allSettings = Setting::where('name', 'web_logo_image_id')->first();
            $logo = Media::find((int)$allSettings->value);
            $new_logo = str_replace("/api/", "", $logo->original_media_path);
            $data['general'] = [
                'currentDate' => date("Y-m-d"),
                'fileName' => "LanguagesExport",
                'reportName' => "Languages",
                'logo' => $new_logo,
            ];
            $data['tableHeaders'] = ["Sr#", "Name", "Code", "Direction", "Status"];
            $data['tableData'] = [];
            $is_active = '';
            foreach ($languages as $key => $language) {
                if ($language->is_active == 1) {
                    $is_active = "Active";
                } else {
                    $is_active = "Inactive";
                }
                $result = [++$key, $language->name, $language->code, $language->direction, $is_active];
                $data['tableData'][] = $result;
            }
            $pdf = PDF::loadView('pdf.pages', $data);
            return $pdf->setPaper('A4', 'potrait')->download('languages.pdf');
        }
        else{
            $filename = "languages.".$request->export;
            return Excel::download(new LanguagesExport($languages), $filename);
        }

    }

  /********* FILTER Languages FOR Search ***********/
   public function filter(Request $request){
       return response()->json(["state" => "success", "message" => trans('messages.response.language.filter_success'),"languages" => $this->getter($request)] );
   }

    /********* ADD NEW Language ***********/
    public function store(CreateRequest $request)
    {

       $code_is_use = Language::where('code', $request->code)->first();
        if($code_is_use)
        {
       return response(["message" => trans('messages.response.language.already_used')]);
        }
        else
        {
            Language::create($request->all());
            return response(["message" => trans('messages.response.language.create_success')]);
        }

    }

    /********* View RECORD TO EDIT Or Display ***********/
    public function show(Language $language)
    {
        return new LanguagesResource($language);
    }

    /********* UPDATE Language ***********/
    public function update(UpdateRequest $request, Language $language)
    {
      if($language->code == 'en'){
        return response()->json(["state" => "fail","message" => trans('messages.response.language.cannot_update_english')]);
      }
      else{
        $language->update($request->all());
        return response(["message" => trans('messages.response.language.update_success')]);
      }
    }

    /********* UPDATE Language Status***********/
    public function updateStatus(Request $request,Language $language){
      if($language->code == 'en'){
        return response()->json(["state" => "fail","message" => trans('messages.response.language.cannot_disable_english')]);
      }
      else if($language->is_default){
        return response()->json(["state" => "fail","message" => trans('messages.response.language.cannot_disable_default')]);
      }
      else{
        $language->update([
          'is_active' => $language->is_active == 1 ? 0:1
        ]);
        return response()->json(["state" => "success", "message" => trans('messages.response.language.update_status_success'),"languages" => $this->getter($request)] );
      }
    }

    /********* UPDATE Default Language ***********/

    public function updateDefault(Request $request,Language $language){
      if($language->is_default){
        return response()->json(["state" => "fail","message" => trans('messages.response.language.one_must_default')]);
      }
      else{
        Language::where('is_default',1)->update([
          'is_default' => 0
        ]);
        $language->update([
          'is_default' => 1,
          'is_active' => 1
        ]);
        return response()->json(["state" => "success", "message" => trans('messages.response.language.change_default_success'),"languages" => $this->getter($request)] );
      }
    }





    /********* DELETE LANGUAGE ***********/
    public function destroy(Request $request,Language $language)
    {
        if($language->code == 'en'){
          return response()->json(["state" => "fail","message" => trans('messages.response.language.delete_success')]);
        }
        else if($language->is_default){
          return response()->json(["state" => "fail","message" => trans('messages.response.language.cannot_delete_english')]);
        }
        else{
          $language->delete();
          return response()->json(["state" => "success", "message" => trans('messages.response.language.delete_success'),"languages" => $this->getter($request)] );
        }
    }
}
