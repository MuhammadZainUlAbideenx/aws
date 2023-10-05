<?php

namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\Category;
use App\Http\Requests\CMS\Categories\CreateRequest;
use App\Http\Resources\CMS\CategoriesResource;
use Excel;
use Str;
use DB;
use App\Exports\CMS\CategoriesExport;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Setting;
use PDF;
class CategoriesController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
      $this->middleware('auth:api');
      $this->middleware('permission:categories.index,guard:api');
      $this->middleware('permission:categories.create,guard:api',['only' => ['store']]);
      $this->middleware('permission:categories.update,guard:api',['only' => ['update']]);
      $this->middleware('permission:categories.delete,guard:api',['only' => ['destroy']]);
      $this->middleware('permission:categories.update|categories.is_active,guard:api',['only' => ['updateStatus']]);
  }

  /********* Getter For Pagination, Searching And Sorting  ***********/
  public function getter($req = null,$export = null)
  {
    if($req != null){
      $categories = Category::withAll();
      if($req->column && $req->column != null && $req->search && $req->search != null){
        if($req->column == 'name'){
          $categories = $categories->whereLike($req->column.'->'.app()->getLocale(),$req->search);
        }
        else{
          $categories = $categories->whereLike($req->column,$req->search);
          }
        }
       else if($req->search && $req->search != null){
            $categories = $categories->whereLike(['name->'.app()->getLocale()],$req->search);
        }
      if($req->sort !=null && $req->sort["field"] != null && $req->sort["type"] != null){
        if($req->sort["field"] == 'name'){
          $locale = app()->getLocale();
          $attribute = $req->sort['field'].'->'."'$.$locale'";
          $categories = $categories->OrderBy(DB::raw("lower($attribute)"),$req->sort["type"]);
        }
        else{
          $categories = $categories->OrderBy($req->sort["field"],$req->sort["type"]);
        }
      }
      else
      {
        $categories = $categories->OrderBy('id','desc');
      }
      if($export != null){ // for export do not paginate
        $categories = $categories->get();
        return $categories;
      }
      $totalCategories = $categories->count();
      $categories = $categories->paginate($req->perPage);
      $categories = CategoriesResource::collection($categories)->response()->getData(true);
      return $categories;
    }
    $categories = CategoriesResource::collection(Category::withAll()->orderBy('id','desc')->paginate(10))->response()->getData(true);
    return $categories;
  }

  /********* FETCH ALL Categories ***********/
    public function index()
    {
        $arrayName = array('categories' => $this->getter());
        return response($arrayName);
    }
      /********* Export PDF , CSV And Excel  **********/
    public function export(Request $request)
    {
        $categories = $this->getter($request,"export");
        if ($request->export == 'pdf') {
            $allSettings = Setting::where('name', 'web_logo_image_id')->first();
            $logo = Media::find((int)$allSettings->value);
            $new_logo = str_replace("/api/", "", $logo->original_media_path);
            $data['general'] = [
                'currentDate' => date("Y-m-d"),
                'fileName' => "Category",
                'reportName' => "Category",
                'logo' => $new_logo,
            ];
            $data['tableHeaders'] = ["Sr#", "Name", "Slug", "Parent Category","Status"];
            $data['tableData'] = [];
            foreach ($categories as $key => $category) {
                if ($category->is_active == 1) {
                    $is_active = "Active";
                } else {
                    $is_active = "Inactive";
                }
                if(!$category->parent_id){
                    $parent_category = '';
                }else{
                    $parent_category = $category->parent->name;
                }
                $result = [++$key, $category->name, $category->slug, $parent_category,$is_active];
                $data['tableData'][] = $result;
            }
            $pdf = PDF::loadView('pdf.pages', $data);
            return $pdf->setPaper('A4', 'potrait')->download('Category.pdf');
        }
        $filename = "categories.".$request->export;
        return Excel::download(new CategoriesExport($categories), $filename);
    }

  /********* FILTER Categories FOR Search ***********/
   public function filter(Request $request){
       return response()->json(["state" => "success", "message" => trans('messages.response.categories.filter_success'),"categories" => $this->getter($request)] );
   }

    /********* ADD NEW Category ***********/
    public function store(CreateRequest $request)
    {
      // Generating Slug
      $default_language = defaultLanguage();
      $name = $request->name;
      foreach ($name as $key => $value) {
        if($key == $default_language->code){
          $_slug = $value;
        }
      }
      $slug = Str::slug($_slug);
      $request->merge(["slug"=> $slug]);
      // Generating Slug
      $category = Category::create($request->all());
      return response(["message" => trans('messages.response.categories.create_success')]);
    }

    /********* View RECORD TO EDIT Or Display ***********/
    public function show($category)
    {
        $category = Category::withAll()->find($category);
        return new CategoriesResource($category);
    }

    /********* UPDATE Category ***********/
    public function update(CreateRequest $request, Category $category)
    {
      if($request->parent_id == $category->id){
        return response()->json(["state" => "fail" , "message" => trans('messages.response.categories.can_not_make_parent')] , 500);
      }
      else{
        $default_language = defaultLanguage();
        $name = $request->name;
        foreach ($name as $key => $value) {
          if($key == $default_language->code){
            $_slug = $value;
          }
        }
        $slug = Str::slug($_slug);
        $request->merge(["slug"=> $slug]);
        // Generating Slug
        $category->update($request->all());
          return response(["message" => trans('messages.response.categories.update_success')]);
      }
      // Generating Slug


    }

    /********* UPDATE Category Status***********/
    public function updateStatus(Request $request,Category $category){
        $category->update([
          'is_active' => $category->is_active == 1 ? 0:1
        ]);
        return response()->json(["state" => "success", "message" =>  trans('messages.response.categories.update_status_success'),"categories" => $this->getter($request)] );
    }


    /********* DELETE LANGUAGE ***********/
    public function destroy(Request $request,Category $category)
    {
          $category->delete();
          return response()->json(["state" => "success", "message" => trans('messages.response.categories.delete_success'),"categories" => $this->getter($request)] );
    }
}
