<?php

namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\ContentPage;
use App\Http\Requests\CMS\ContentPages\CreateRequest;
use App\Http\Resources\CMS\ContentPagesResource;
use Excel;
use Str;
use App\Exports\CMS\ContentPagesExport;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Setting;

class ContentPagesController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
      $this->middleware('auth:api');
      $this->middleware('permission:content_pages.index,guard:api');
      $this->middleware('permission:content_pages.create,guard:api',['only' => ['store']]);
      $this->middleware('permission:content_pages.update,guard:api',['only' => ['update']]);
      $this->middleware('permission:content_pages.delete,guard:api',['only' => ['destroy']]);
      $this->middleware('permission:content_pages.update|content_pages.is_active,guard:api',['only' => ['updateStatus']]);
  }

  /********* Getter For Pagination, Searching And Sorting  ***********/
  public function getter($req = null,$export = null)
  {
    if($req != null){
      $content_pages = ContentPage::withAll();
      if($req->column && $req->column != null && $req->search && $req->search != null){
        if($req->column == 'name'){
          $content_pages = $content_pages->whereLike($req->column.'->'.app()->getLocale(),$req->search);
        }
        else{
          $content_pages = $content_pages->whereLike($req->column,$req->search);
          }
        }
       else if($req->search && $req->search != null){
            $content_pages = $content_pages->whereLike(['name->'.app()->getLocale()],$req->search);
        }
      if($req->sort !=null && $req->sort["field"] != null && $req->sort["type"] != null){
        $content_pages = $content_pages->OrderBy($req->sort["field"],$req->sort["type"]);
      }
      else
      {
        $content_pages = $content_pages->OrderBy('id','desc');
      }
      if($export != null){ // for export do not paginate
        $content_pages = $content_pages->get();
        return $content_pages;
      }
      $totalContentPages = $content_pages->count();
      $content_pages = $content_pages->paginate($req->perPage);
      $content_pages = ContentPagesResource::collection($content_pages)->response()->getData(true);
      return $content_pages;
    }
    $content_pages = ContentPagesResource::collection(ContentPage::withAll()->orderBy('id','desc')->paginate(10))->response()->getData(true);
    return $content_pages;
  }

  /********* FETCH ALL ContentPages ***********/
    public function index()
    {
        $arrayName = array('content_pages' => $this->getter());
        return response($arrayName);
    }
      /********* Export PDF , CSV And Excel  **********/
    public function export(Request $request)
    {
        $content_pages = $this->getter($request,"export");
        if ($request->export == 'pdf') {
            $allSettings = Setting::where('name', 'web_logo_image_id')->first();
            $logo = Media::find((int)$allSettings->value);
            $new_logo = str_replace("/api/", "", $logo->original_media_path);
            $data['general'] = [
                'currentDate' => date("Y-m-d"),
                'fileName' => "Content Pages",
                'reportName' => "Content Pages",
                'logo' => $new_logo,
            ];
            $data['tableHeaders'] = ["Sr#", "Name", "Description", "Slug",  "Status"];
            $data['tableData'] = [];
            foreach ($content_pages as $key => $content_page) {
                if ($content_page->is_active == 1) {
                    $is_active = "Active";
                } else {
                    $is_active = "Inactive";
                }

                $result = [++$key, $content_page->name, strip_tags($content_page->description),$content_page->slug,$is_active];
                $data['tableData'][] = $result;
            }
            $pdf = PDF::loadView('pdf.pages', $data);
            return $pdf->setPaper('A4', 'potrait')->download('content_pages.pdf');
        }
        $filename = "content_pages.".$request->export;
        return Excel::download(new ContentPagesExport($content_pages), $filename);
    }

  /********* FILTER ContentPages FOR Search ***********/
   public function filter(Request $request){
       return response()->json(["state" => "success", "message" => trans('messages.response.content_pages.filter_success'),"content_pages" => $this->getter($request)] );
   }

    /********* ADD NEW ContentPage ***********/
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
      $content_page = ContentPage::create($data);
      return response(["message" => trans('messages.response.content_pages.create_success')]);
    }

    /********* View RECORD TO EDIT Or Display ***********/
    public function show($content_page)
    {
        $content_page = ContentPage::withAll()->find($content_page);
        return new ContentPagesResource($content_page);
    }

    /********* UPDATE ContentPage ***********/
    public function update(CreateRequest $request, ContentPage $content_page)
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
      $content_page->update($data);
        return response(["message" => trans('messages.response.content_pages.update_success')]);

    }

    /********* UPDATE Manufacturer Status***********/
    public function updateStatus(Request $request,ContentPage $content_page){
        $content_page->update([
          'is_active' => $content_page->is_active == 1 ? 0:1
        ]);
        return response()->json(["state" => "success", "message" => trans('messages.response.content_pages.update_status_success'),"content_pages" => $this->getter($request)] );
    }

    /********* DELETE LANGUAGE ***********/
    public function destroy(Request $request,ContentPage $content_page)
    {
          $content_page->delete();
          return response()->json(["state" => "success", "message" => trans('messages.response.content_pages.delete_success'),"content_pages" => $this->getter($request)] );
    }
}
