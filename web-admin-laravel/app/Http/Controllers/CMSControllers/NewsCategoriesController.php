<?php
namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\NewsCategory;
use App\Http\Requests\CMS\NewsCategories\CreateRequest;
use App\Http\Resources\CMS\NewsCategoriesResource;
use Excel;
use App\Exports\CMS\NewsCategoriesExport;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Setting;
use PDF;
class NewsCategoriesController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
      $this->middleware('auth:api');
      $this->middleware('permission:news_categories.index,guard:api');
      $this->middleware('permission:news_categories.create,guard:api',['only' => ['store']]);
      $this->middleware('permission:news_categories.update,guard:api',['only' => ['update']]);
      $this->middleware('permission:news_categories.delete,guard:api',['only' => ['destroy']]);
      $this->middleware('permission:news_categories.update|news_categories.is_active,guard:api',['only' => ['updateStatus']]);
  }

  /********* Getter For Pagination, Searching And Sorting  ***********/
  public function getter($req = null,$export = null)
  {
    if($req != null){
      $news_categories = NewsCategory::WithAll();
      if($req->column && $req->column != null && $req->search && $req->search != null){
        if($req->column == 'name'){
          $news_categories = $news_categories->whereLike($req->column.'->'.app()->getLocale(),$req->search);
        }
        else{
          $news_categories = $news_categories->whereLike($req->column,$req->search);
          }
        }
       else if($req->search && $req->search != null){
            $news_categories = $news_categories->whereLike(['name->'.app()->getLocale()],$req->search);
        }
      if($req->sort !=null && $req->sort["field"] != null && $req->sort["type"] != null){
        $news_categories = $news_categories->OrderBy($req->sort["field"],$req->sort["type"]);
      }
      else
      {
        $news_categories = $news_categories->OrderBy('id','desc');
      }
      if($export != null){ // for export do not paginate
        $news_categories = $news_categories->get();
        return $news_categories;
      }
      $totalNewsCategories = $news_categories->count();
      $news_categories = $news_categories->paginate($req->perPage);
      $news_categories = NewsCategoriesResource::collection($news_categories)->response()->getData(true);
      return $news_categories;
    }
    $news_categories = NewsCategoriesResource::collection(NewsCategory::WithAll()->orderBy('id','desc')->paginate(10))->response()->getData(true);
    return $news_categories;
  }

  /********* FETCH ALL NewsCategories ***********/
    public function index()
    {
        $arrayName = array('news_categories' => $this->getter());
        return response($arrayName);
    }
      /********* Export PDF , CSV And Excel  **********/
    public function export(Request $request)
    {
        $news_categories = $this->getter($request,"export");
        if ($request->export == 'pdf') {
            $allSettings = Setting::where('name', 'web_logo_image_id')->first();
            $logo = Media::find((int)$allSettings->value);
            $new_logo = str_replace("/api/", "", $logo->original_media_path);
            $data['general'] = [
                'currentDate' => date("Y-m-d"),
                'fileName' => "News Category",
                'reportName' => "News Category",
                'logo' => $new_logo,
            ];
            $data['tableHeaders'] = ["Sr#", "Name", "Description", "Status"];
            $data['tableData'] = [];
            foreach ($news_categories as $key => $news_category) {
                if ($news_category->is_active == 1) {
                    $is_active = "Active";
                } else {
                    $is_active = "Inactive";
                }

                $result = [++$key, $news_category->name, strip_tags($news_category->description),$is_active];
                $data['tableData'][] = $result;
            }
            $pdf = PDF::loadView('pdf.pages', $data);
            return $pdf->setPaper('A4', 'potrait')->download('news_category.pdf');
        }
        $filename = "news_categories.".$request->export;
        return Excel::download(new NewsCategoriesExport($news_categories), $filename);
    }

  /********* FILTER NewsCategories FOR Search ***********/
   public function filter(Request $request){
       return response()->json(["state" => "success", "message" => trans('messages.response.news_categories.filter_success'),"news_categories" => $this->getter($request)] );
   }

    /********* ADD NEW NewsCategory ***********/
    public function store(CreateRequest $request)
    {
      $news_category = NewsCategory::create($request->all());
      return response(["message" => trans('messages.response.news_categories.create_success')]);
    }

    /********* View RECORD TO EDIT Or Display ***********/
    public function show($news_category)
    {
        $news_category = NewsCategory::WithAll()->find($news_category);
        return new NewsCategoriesResource($news_category);
    }

    /********* UPDATE NewsCategory ***********/
    public function update(CreateRequest $request, NewsCategory $news_category)
    {
      $news_category->update($request->all());
        return response(["message" => trans('messages.response.news_categories.update_success')]);

    }

    /********* UPDATE NewsCategory Status***********/
    public function updateStatus(Request $request,NewsCategory $news_category){
        $news_category->update([
          'is_active' => $news_category->is_active == 1 ? 0:1
        ]);
        return response()->json(["state" => "success", "message" => trans('messages.response.news_categories.update_status_success'),"news_categories" => $this->getter($request)] );
    }


    /********* DELETE LANGUAGE ***********/
    public function destroy(Request $request,NewsCategory $news_category)
    {
          $news_category->delete();
          return response()->json(["state" => "success", "message" => trans('messages.response.news_categories.delete_success'),"news_categories" => $this->getter($request)] );
    }

}
