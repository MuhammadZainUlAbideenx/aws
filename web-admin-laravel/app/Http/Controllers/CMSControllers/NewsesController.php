<?php

namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\News;
use App\Http\Requests\CMS\Newses\CreateRequest;
use App\Http\Resources\CMS\NewsesResource;
use Excel;
use Auth;
use Str;
use PDF;
use App\Exports\CMS\NewsesExport;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Setting;

class NewsesController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
      $this->middleware('auth:api');
      $this->middleware('permission:newses.index,guard:api');
      $this->middleware('permission:newses.create,guard:api',['only' => ['store']]);
      $this->middleware('permission:newses.update,guard:api',['only' => ['update']]);
      $this->middleware('permission:newses.delete,guard:api',['only' => ['destroy']]);
      $this->middleware('permission:newses.update|newses.is_active,guard:api',['only' => ['updateStatus']]);
  }

  /********* Getter For Pagination, Searching And Sorting  ***********/
  public function getter($req = null,$export = null)
  {
    if($req != null){
      $newses =  News::withAll();
      if($req->column && $req->column != null && $req->search && $req->search != null){
        if($req->column == 'name'){
          $newses = $newses->whereLike($req->column.'->'.app()->getLocale(),$req->search);
        }
        else{
          $newses = $newses->whereLike($req->column,$req->search);
          }
        }
       else if($req->search && $req->search != null){
            $newses = $newses->whereLike(['name->'.app()->getLocale()],$req->search);
        }
      if($req->sort !=null && $req->sort["field"] != null && $req->sort["type"] != null){
        $newses = $newses->OrderBy($req->sort["field"],$req->sort["type"]);
      }
      else
      {
        $newses = $newses->OrderBy('id','desc');
      }
      if($export != null){ // for export do not paginate
        $newses = $newses->get();
        return $newses;
      }
      $totalNewses = $newses->count();
      $newses = $newses->paginate($req->perPage);
      $newses = NewsesResource::collection($newses)->response()->getData(true);
      return $newses;
    }
    $newses = NewsesResource::collection(News::WithAll()->orderBy('id','desc')->paginate(10))->response()->getData(true);
    return $newses;
  }

  /********* FETCH ALL Newses ***********/
    public function index()
    {
        $arrayName = array('newses' => $this->getter());
        return response($arrayName);
    }
      /********* Export PDF , CSV And Excel  **********/
    public function export(Request $request)
    {
        $newses = $this->getter($request,"export");
        if ($request->export == 'pdf') {
            $allSettings = Setting::where('name', 'web_logo_image_id')->first();
            $logo = Media::find((int)$allSettings->value);
            $new_logo = str_replace("/api/", "", $logo->original_media_path);
            $data['general'] = [
                'currentDate' => date("Y-m-d"),
                'fileName' => "Newses",
                'reportName' => "Newses",
                'logo' => $new_logo,
            ];
            $data['tableHeaders'] = ["Sr#", "Name","Slug", "Category", "Description", "Status"];
            $data['tableData'] = [];
            foreach ($newses as $key => $news) {
                if ($news->is_active == 1) {
                    $is_active = "Active";
                } else {
                    $is_active = "Inactive";
                }

                $result = [++$key, $news->name, $news->slug, $news->news_category ? $news->news_category->name : "" , strip_tags($news->description),$is_active];
                $data['tableData'][] = $result;
            }
            $pdf = PDF::loadView('pdf.pages', $data);
            return $pdf->setPaper('A4', 'potrait')->download('news.pdf');
        }
        $filename = "newses.".$request->export;
        return Excel::download(new NewsesExport($newses), $filename);
    }

  /********* FILTER Newses FOR Search ***********/
   public function filter(Request $request){
       return response()->json(["state" => "success", "message" => trans('messages.response.newses.filter_success'),"newses" => $this->getter($request)] );
   }

    /********* ADD NEW News ***********/
    public function store(CreateRequest $request)
    {
      $default_language = defaultLanguage();
      $admin = auth()->user();
      $name = $request->name;
      $name=$name[$default_language->code];
      $slug = Str::slug($name);
      $request->merge(["slug"=> $slug]);
      $news = $admin->newses()->create($request->all());
      return response(["message" => trans('messages.response.newses.create_success')]);
    }

    /********* View RECORD TO EDIT Or Display ***********/
    public function show($news)
    {
        $news = News::withAll()->find($news);
        return  new NewsesResource($news);
    }

    /********* UPDATE News ***********/
    public function update(CreateRequest $request, News $news)
    {
        $default_language = defaultLanguage();
        $name = $request->name;
        $data = $request->all();
        $name=$name[$default_language->code];
        $slug = Str::slug($name);
        $data["slug"] = $slug;
        $news->update($data);
        return response(["message" => trans('messages.response.newses.update_success')]);
    }

    /********* UPDATE News Status***********/
    public function updateStatus(Request $request,News $news){
        $news->update([
          'is_active' => $news->is_active == 1 ? 0:1
        ]);
        return response()->json(["state" => "success", "message" =>trans('messages.response.newses.update_status_success'),"newses" => $this->getter($request)] );
    }


    /********* DELETE LANGUAGE ***********/
    public function destroy(Request $request,News $news)
    {

          $news->delete();
          return response()->json(["state" => "success", "message" => trans('messages.response.newses.delete_success'),"newses" => $this->getter($request)] );
    }
}
