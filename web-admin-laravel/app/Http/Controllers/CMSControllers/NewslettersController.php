<?php

namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\Newsletter;
use App\Http\Requests\CMS\Newsletters\CreateRequest;
use App\Http\Requests\CMS\Newsletters\UpdateRequest;
use App\Http\Resources\CMS\NewslettersResource;
use Excel;
use App\Exports\CMS\NewsletterExport;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Setting;
use PDF;
class NewslettersController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
      $this->middleware('auth:api');
      $this->middleware('permission:newsletters.index,guard:api');
      $this->middleware('permission:newsletters.create,guard:api',['only' => ['store']]);
      $this->middleware('permission:newsletters.update,guard:api',['only' => ['update']]);
      $this->middleware('permission:newsletters.delete,guard:api',['only' => ['destroy']]);
      $this->middleware('permission:newsletters.update|newsletters.is_active,guard:api',['only' => ['updateStatus']]);
  }

  /********* Getter For Pagination, Searching And Sorting  ***********/
  public function getter($req = null,$export = null)
  {
    if($req != null){
      $newsletters = new Newsletter;
      if($req->column && $req->column != null && $req->search && $req->search != null){
        if($req->column == 'name'){
          $newsletters = $newsletters->whereLike($req->column.'->'.app()->getLocale(),$req->search);
        }
        else{
          $newsletters = $newsletters->whereLike($req->column,$req->search);
          }
        }
       else if($req->search && $req->search != null){
            $newsletters = $newsletters->whereLike(['name->'.app()->getLocale()],$req->search);
        }
      if($req->sort !=null && $req->sort["field"] != null && $req->sort["type"] != null){
        $newsletters = $newsletters->OrderBy($req->sort["field"],$req->sort["type"]);
      }
      else
      {
        $newsletters = $newsletters->OrderBy('id','desc');

      }
      if($export != null){ // for export do not paginate
        $newsletters = $newsletters->get();
        return $newsletters;
      }
      $totalNewsletters = $newsletters->count();
      $newsletters = $newsletters->paginate($req->perPage);
      $newsletters = NewslettersResource::collection($newsletters)->response()->getData(true);
      return $newsletters;
    }
    $newsletters = NewslettersResource::collection(Newsletter::orderBy('id','desc')->paginate(10))->response()->getData(true);
    return $newsletters;
  }

  /********* FETCH ALL Newsletters ***********/
    public function index()
    {
        $arrayName = array('newsletters' => $this->getter());
        return response($arrayName);
    }
      /********* Export PDF , CSV And Excel  **********/
    public function export(Request $request)
    {

        $newsletters = $this->getter($request,"export");
        if ($request->export == 'pdf') {
            $allSettings = Setting::where('name', 'web_logo_image_id')->first();
            $logo = Media::find((int)$allSettings->value);
            $new_logo = str_replace("/api/", "", $logo->original_media_path);
            $data['general'] = [
                'currentDate' => date("Y-m-d"),
                'fileName' => "Newsletter",
                'reportName' => "Newsletter",
                'logo' => $new_logo,
            ];
            $data['tableHeaders'] = ["Sr#", "Email", "Status"];
            $data['tableData'] = [];
            foreach ($newsletters as $key => $newsletter) {
                if ($newsletter->is_active == 1) {
                    $is_active = "Active";
                } else {
                    $is_active = "Inactive";
                }

                $result = [++$key, $newsletter->email,$is_active];
                $data['tableData'][] = $result;
            }
            $pdf = PDF::loadView('pdf.pages', $data);
            return $pdf->setPaper('A4', 'potrait')->download('newsletter.pdf');
        }
        $filename = "newsletters.".$request->export;
        return Excel::download(new NewsletterExport($newsletters), $filename);
    }

  /********* FILTER Newsletters FOR Search ***********/
   public function filter(Request $request){
       return response()->json(["state" => "success", "message" =>trans('messages.response.newsletter.filter_success'),"newsletters" => $this->getter($request)] );
   }

    /********* ADD NEW Newsletter ***********/
    public function store(CreateRequest $request)
    {
      if($request->is_verified){
        Newsletter::where('is_verified',1)->update([
          'is_verified' => 0
        ]);
      }
      $newsletter = Newsletter::create($request->all());
      return response(["message" => trans('messages.response.newsletter.create_success')]);
    }

    /********* View RECORD TO EDIT Or Display ***********/
    public function show(Newsletter $newsletter)
    {
        return new NewslettersResource($newsletter);
    }

    /********* UPDATE Newsletter ***********/
    public function update(UpdateRequest $request, Newsletter $newsletter)
    {

      if($request->is_verified && !$newsletter->is_verified){
        Newsletter::where('is_verified',1)->update([
          'is_verified' => 0
        ]);
        $newsletter->update($request->all());
        return response(["message" => trans('messages.response.newsletter.update_success')]);
      }
      else if($newsletter->is_verified && !$request->is_verified){
        return response(["state" => "fail","message" => trans('messages.response.newsletter.one_must_default')]);
      }
      else{
        $newsletter->update($request->all());
        return response(["message" => trans('messages.response.newsletter.update_success')]);
      }
    }

    /********* UPDATE Newsletter Status***********/
    public function updateStatus(Request $request,Newsletter $newsletter){
      if($newsletter->is_verified){
        return response()->json(["state" => "fail","message" => trans('messages.response.newsletter.cannot_disable_default')]);
      }
      else{
        $newsletter->update([
          'is_active' => $newsletter->is_active == 1 ? 0:1
        ]);
        return response()->json(["state" => "success", "message" => trans('messages.response.newsletter.update_default_status_success'),"newsletters" => $this->getter($request)] );
      }
    }
    /********* UPDATE default Newsletter Status***********/

    public function updateDefault(Request $request,Newsletter $newsletter){
      if($newsletter->is_verified){
        return response()->json(["state" => "fail","message" => trans('messages.response.newsletter.one_must_default')]);
      }
      else{
        Newsletter::where('is_verified',1)->update([
          'is_verified' => 0
        ]);
        $newsletter->update([
          'is_verified' => 1,
          'is_active' => 1
        ]);
        return response()->json(["state" => "success", "message" =>  trans('messages.response.newsletter.update_default_status_success'),"newsletters" => $this->getter($request)] );
      }
    }


    /********* DELETE LANGUAGE ***********/
    public function destroy(Request $request,Newsletter $newsletter)
    {
      if($newsletter->is_verified){
        return response()->json(["state" => "fail","message" => trans('messages.response.newsletter.cannot_delete_default')]);
      }else{
        $newsletter->delete();
        return response()->json(["state" => "success", "message" => trans('messages.response.newsletter.delete_success'),"newsletters" => $this->getter($request)] );
      }
    }
}
