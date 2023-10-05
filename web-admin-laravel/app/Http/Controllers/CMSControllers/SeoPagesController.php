<?php

namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\SeoPage;
use App\Models\CMSModels\Product;
use App\Models\CMSModels\Category;
use App\Models\CMSModels\ContentPage;
use App\Http\Requests\CMS\SeoPages\CreateRequest;
use App\Http\Resources\CMS\SeoPagesResource;
use Excel;
use App\Exports\CMS\SeoPagesExport;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Setting;
use PDF;
class SeoPagesController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
      $this->middleware('auth:api');
      $this->middleware('permission:seo_pages.index,guard:api');
      $this->middleware('permission:seo_pages.create,guard:api',['only' => ['store']]);
      $this->middleware('permission:seo_pages.update,guard:api',['only' => ['update']]);
      $this->middleware('permission:seo_pages.delete,guard:api',['only' => ['destroy']]);
      $this->middleware('permission:seo_pages.update|seo_pages.is_active,guard:api',['only' => ['updateStatus']]);
  }

  /********* Getter For Pagination, Searching And Sorting  ***********/
  public function getter($req = null,$export = null)
  {
    if($req != null){
      $seo_pages = SeoPage::withAll();
      if($req->column && $req->column != null && $req->search && $req->search != null){
        $seo_pages = $seo_pages->whereLike($req->column,$req->search);
        }
       else if($req->search && $req->search != null){
            $seo_pages = $seo_pages->whereLike(['title','description','keywords'],$req->search);
        }
      if($req->sort !=null && $req->sort["field"] != null && $req->sort["type"] != null){
        $seo_pages = $seo_pages->OrderBy($req->sort["field"],$req->sort["type"]);
      }
      else
      {
        $seo_pages = $seo_pages->OrderBy('id','desc');
      }
      if($export != null){ // for export do not paginate
        $seo_pages = $seo_pages->get();
        return $seo_pages;
      }
      $totalSeoPages = $seo_pages->count();
      $seo_pages = $seo_pages->paginate($req->perPage);
      $seo_pages = SeoPagesResource::collection($seo_pages)->response()->getData(true);
      return $seo_pages;
    }
    $seo_pages = SeoPage::withAll()->orderBy('id','desc')->paginate(10);
    $seo_pages = SeoPagesResource::collection($seo_pages)->response()->getData(true);
    return $seo_pages;
  }

  /********* FETCH ALL SeoPages ***********/
    public function index()
    {
        $arrayName = array('seo_pages' => $this->getter());
        return response($arrayName);
    }
      /********* Export PDF , CSV And Excel  **********/
    public function export(Request $request)
    {
        $seo_pages = $this->getter($request,"export");
        if ($request->export == 'pdf') {
            $allSettings = Setting::where('name', 'web_logo_image_id')->first();
            $logo = Media::find((int)$allSettings->value);
            $new_logo = str_replace("/api/", "", $logo->original_media_path);
            $data['general'] = [
                'currentDate' => date("Y-m-d"),
                'fileName' => "SEO",
                'reportName' => "SEO",
                'logo' => $new_logo,
            ];
            $data['tableHeaders'] = ["Sr#", "Title", "Description", "Keywords",  "Static Page", "Product",  "Category", "Content Page", "Status"];
            $data['tableData'] = [];
            foreach ($seo_pages as $key => $seo_page) {

                if ($seo_page->is_active == 1) {
                    $is_active = "Active";
                } else {
                    $is_active = "Inactive";
                }

                $result = [++$key, $seo_page->title,$seo_page->description,$seo_page->keywords,$seo_page->static_page_id,$seo_page->product ? $seo_page->product->name : "",$seo_page->category ? $seo_page->category->name : "",$seo_page->content_page ? $seo_page->content_page->name : "",$is_active];
                $data['tableData'][] = $result;
            }
            $pdf = PDF::loadView('pdf.pages', $data);
            return $pdf->setPaper('A4', 'potrait')->download('seo.pdf');
        }
        $filename = "seo_pages.".$request->export;
        return Excel::download(new SeoPagesExport($seo_pages), $filename);
    }

  /********* FILTER SeoPages FOR Search ***********/
   public function filter(Request $request){
       return response()->json(["state" => "success", "message" =>trans('messages.response.seo_pages.filter_success'),"seo_pages" => $this->getter($request)] );
   }

   /********* ADD Or Update Seo of product, category ,content page or static page ***********/
   public function store(CreateRequest $request)
   {
     $data=$request->except(['seo_type']);
     if($request->seo_type == 'product'){
       $product = Product::where('id',$request->product_id)->first();
       if($product){
         if($product->seo){
           $product->seo()->update($data);
         }
         else{
           $product->seo()->create($data);
         }
       }
       else{
         return response(["state" => "fail","message" => 'Invalid product'],422);
       }
     }
     else if($request->seo_type == 'category'){
       $category = Category::where('id',$request->category_id)->first();
       if($category){
         if($category->seo){
           $category->seo()->update($data);
         }
         else{
           $category->seo()->create($data);
         }
       }
       else{
         return response(["state" => "fail","message" => 'Invalid category'],422);
       }
     }
     else if($request->seo_type == 'content_page'){
       $content_page = ContentPage::where('id',$request->content_page_id)->first();
       if($content_page){
         if($content_page->seo){
           $content_page->seo()->update($data);
         }
         else{
           $content_page->seo()->create($data);
         }
       }
       else{
         return response(["state" => "fail","message" => 'Invalid content page'],422);
       }
     }
     else if($request->seo_type == 'static_page'){
       $static_page = SeoPage::where('static_page_id',$request->static_page_id)->first();
       if($static_page){
         SeoPage::where('static_page_id',$request->static_page_id)->update($data);
       }
       else{
         SeoPage::create($data);
       }
     }
     return response(["message" => trans('messages.response.seo_pages.create_success')]);
   }

   /********* Get Static Page seo if exists ***********/
     public function show($seo_page)
     {
       if(is_numeric($seo_page)){
         $seo_page = SeoPage::find($seo_page);
       }
       else{
         $seo_page = SeoPage::where('static_page_id',$seo_page)->first();
       }
       if($seo_page){
         return new SeoPagesResource($seo_page);
       }
       else{
         $array = ['seo' => [
                     'title' => '',
                     'description' => '',
                     'keywords' => '',
                     'meta_tags'=> '']];
       $data = ['data' => $array];
       return response()->json($data);
       }
     }

    /********* UPDATE SeoPage ***********/
    public function update(CreateRequest $request, SeoPage $seo_page)
    {
        $seo_page->update($request->all());
        return response(["message" => trans('messages.response.seo_pages.update_success')]);
    }

    /********* UPDATE Manufacturer Status***********/
    public function updateStatus(Request $request,SeoPage $seo_page){
        $seo_page->update([
          'is_active' => $seo_page->is_active == 1 ? 0:1
        ]);
        return response()->json(["state" => "success", "message" => trans('messages.response.seo_pages.update_status_success'),"seo_pages" => $this->getter($request)] );
    }

    /********* DELETE LANGUAGE ***********/
    public function destroy(Request $request,SeoPage $seo_page)
    {
        $seo_page->delete();
          return response()->json(["state" => "success", "message" =>  trans('messages.response.seo_pages.delete_success'),"seo_pages" => $this->getter($request)] );
    }
}
