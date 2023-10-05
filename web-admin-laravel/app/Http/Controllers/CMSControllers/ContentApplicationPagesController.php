<?php

namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\ContentApplicationPage;
use App\Http\Requests\CMS\ContentApplicationPages\CreateRequest;
use App\Http\Resources\CMS\ContentApplicationPagesResource;
use Excel;
use Str;
use App\Exports\CMS\ContentApplicationPagesExport;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Setting;
use PDF;
class ContentApplicationPagesController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
      $this->middleware('auth:api');
      $this->middleware('permission:content_application_pages.index,guard:api');
      $this->middleware('permission:content_application_pages.create,guard:api',['only' => ['store']]);
      $this->middleware('permission:content_application_pages.update,guard:api',['only' => ['update']]);
      $this->middleware('permission:content_application_pages.delete,guard:api',['only' => ['destroy']]);
      $this->middleware('permission:content_application_pages.update|content_application_pages.is_active,guard:api',['only' => ['updateStatus']]);
  }

  /********* Getter For Pagination, Searching And Sorting  ***********/
  public function getter($req = null,$export = null)
  {
    if($req != null){
      $content_application_pages = new ContentApplicationPage;
      if($req->column && $req->column != null && $req->search && $req->search != null){
        if($req->column == 'name'){
          $content_application_pages = $content_application_pages->whereLike($req->column.'->'.app()->getLocale(),$req->search);
        }
        else{
          $content_application_pages = $content_application_pages->whereLike($req->column,$req->search);
          }
        }
       else if($req->search && $req->search != null){
            $content_application_pages = $content_application_pages->whereLike(['name->'.app()->getLocale()],$req->search);
        }
      if($req->sort !=null && $req->sort["field"] != null && $req->sort["type"] != null){
        $content_application_pages = $content_application_pages->OrderBy($req->sort["field"],$req->sort["type"]);
      }
      else
      {
        $content_application_pages = $content_application_pages->OrderBy('id','desc');
      }
      if($export != null){ // for export do not paginate
        $content_application_pages = $content_application_pages->get();
        return $content_application_pages;
      }
      $totalContentApplicationPages = $content_application_pages->count();
      $content_application_pages = $content_application_pages->paginate($req->perPage);
      $content_application_pages = ContentApplicationPagesResource::collection($content_application_pages)->response()->getData(true);
      return $content_application_pages;
    }
    $content_application_pages = ContentApplicationPagesResource::collection(ContentApplicationPage::orderBy('id','desc')->paginate(10))->response()->getData(true);
    return $content_application_pages;
  }

  /********* FETCH ALL ContentApplicationPages ***********/
    public function index()
    {
        $arrayName = array('content_application_pages' => $this->getter());
        return response($arrayName);
    }
      /********* Export PDF , CSV And Excel  **********/
    public function export(Request $request)
    {
        $content_application_pages = $this->getter($request,"export");
        if ($request->export == 'pdf') {
            $allSettings = Setting::where('name', 'web_logo_image_id')->first();
            $logo = Media::find((int)$allSettings->value);
            $new_logo = str_replace("/api/", "", $logo->original_media_path);
            $data['general'] = [
                'currentDate' => date("Y-m-d"),
                'fileName' => "Content Application Pages",
                'reportName' => "Content Application Pages",
                'logo' => $new_logo,
            ];
            $data['tableHeaders'] = ["Sr#", "Name","Slug", "Description", "Status"];
            $data['tableData'] = [];
            foreach ($content_application_pages as $key => $content_application_page) {
                if ($content_application_page->is_active == 1) {
                    $is_active = "Active";
                } else {
                    $is_active = "Inactive";
                }

                $result = [++$key, $content_application_page->name, $content_application_page->slug, strip_tags($content_application_page->description),$is_active];
                $data['tableData'][] = $result;
            }
            $pdf = PDF::loadView('pdf.pages', $data);
            return $pdf->setPaper('A4', 'potrait')->download('content_application_pages.pdf');
        }
        $filename = "content_application_pages.".$request->export;
        return Excel::download(new ContentApplicationPagesExport($content_application_pages), $filename);
    }

  /********* FILTER ContentApplicationPages FOR Search ***********/
   public function filter(Request $request){
       return response()->json(["state" => "success", "message" => trans('messages.response.content_application_pages.filter_success'),"content_application_pages" => $this->getter($request)] );
   }

    /********* ADD NEW ContentApplicationPage ***********/
    public function store(CreateRequest $request)
    {
        $data = $request->all();
        $default_language = defaultLanguage();

        if( $data['slug'])
        {
            $data['slug'] = Str::slug($data['slug']);
        }
        else
        {
            $name = $request['name'][$default_language->code];
            $data['slug'] = Str::slug($name);
        }
      $content_application_page = ContentApplicationPage::create($data);
      return response(["message" => trans('messages.response.content_application_pages.create_success')]);
    }

    /********* View RECORD TO EDIT Or Display ***********/
    public function show(ContentApplicationPage $content_application_page)
    {
        return new ContentApplicationPagesResource($content_application_page);
    }

    /********* UPDATE ContentApplicationPage ***********/
    public function update(CreateRequest $request, ContentApplicationPage $content_application_page)
    {
        $data = $request->all();
        $default_language = defaultLanguage();

        if( $data['slug'])
        {
            $data['slug'] = Str::slug($data['slug']);
        }
        else
        {
            $name = $request['name'][$default_language->code];
            $data['slug'] = Str::slug($name);
        }
      $content_application_page->update($data);
        return response(["message" => trans('messages.response.content_application_pages.update_success')]);

    }

    /********* UPDATE Manufacturer Status***********/
    public function updateStatus(Request $request,ContentApplicationPage $content_application_page){
        $content_application_page->update([
          'is_active' => $content_application_page->is_active == 1 ? 0:1
        ]);
        return response()->json(["state" => "success", "message" => trans('messages.response.content_application_pages.update_status_success'),"content_application_pages" => $this->getter($request)] );
    }

    /********* DELETE LANGUAGE ***********/
    public function destroy(Request $request,ContentApplicationPage $content_application_page)
    {
          $content_application_page->delete();
          return response()->json(["state" => "success", "message" => trans('messages.response.content_application_pages.delete_success'),"content_application_pages" => $this->getter($request)] );
    }
}
