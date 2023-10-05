<?php

namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\Faq;
use App\Http\Requests\CMS\Faqs\CreateRequest;
use App\Http\Resources\CMS\FaqsResource;
use Excel;
use Auth;
use App\Exports\CMS\FaqsExport;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Setting;
use PDF;

class FaqsController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
      $this->middleware('auth:api');
      $this->middleware('permission:faqs.index,guard:api');
      $this->middleware('permission:faqs.create,guard:api',['only' => ['store']]);
      $this->middleware('permission:faqs.update,guard:api',['only' => ['update']]);
      $this->middleware('permission:faqs.delete,guard:api',['only' => ['destroy']]);
      $this->middleware('permission:faqs.update|faqs.is_active,guard:api',['only' => ['updateStatus']]);
  }

  /********* Getter For Pagination, Searching And Sorting  ***********/
  public function getter($req = null,$export = null)
  {
    if($req != null){
      $faqs =  Faq::withAll();
      if($req->column && $req->column != null && $req->search && $req->search != null){
        if($req->column == 'question'){
          $faqs = $faqs->whereLike($req->column.'->'.app()->getLocale(),$req->search);
        }
        else{
          $faqs = $faqs->whereLike($req->column,$req->search);
          }
        }
       else if($req->search && $req->search != null){
            $faqs = $faqs->whereLike(['question->'.app()->getLocale()],$req->search);
        }
      if($req->sort !=null && $req->sort["field"] != null && $req->sort["type"] != null){
        $faqs = $faqs->OrderBy($req->sort["field"],$req->sort["type"]);
      }
      else
      {
        $faqs = $faqs->OrderBy('id','desc');
      }
      if($export != null){ // for export do not paginate
        $faqs = $faqs->get();
        return $faqs;
      }
      $totalFaqs = $faqs->count();
      $faqs = $faqs->paginate($req->perPage);
      $faqs = FaqsResource::collection($faqs)->response()->getData(true);
      return $faqs;
    }
    $faqs = FaqsResource::collection(Faq::WithAll()->orderBy('id','desc')->paginate(10))->response()->getData(true);
    return $faqs;
  }

  /********* FETCH ALL Faqs ***********/
    public function index()
    {
        $arrayName = array('faqs' => $this->getter());
        return response($arrayName);
    }
      /********* Export PDF , CSV And Excel  **********/
    public function export(Request $request)
    {
        $faqs = $this->getter($request,"export");
        if ($request->export == 'pdf') {
            $allSettings = Setting::where('name', 'web_logo_image_id')->first();
            $logo = Media::find((int)$allSettings->value);
            $new_logo = str_replace("/api/", "", $logo->original_media_path);
            $data['general'] = [
                'currentDate' => date("Y-m-d"),
                'fileName' => "Faqs",
                'reportName' => "Faqs",
                'logo' => $new_logo,
            ];
            $data['tableHeaders'] = ["Sr#", "Question", "Answer", "Product",  "Status"];
            $data['tableData'] = [];
            foreach ($faqs as $key => $faq) {
                if ($faq->is_active == 1) {
                    $is_active = "Active";
                } else {
                    $is_active = "Inactive";
                }

                $result = [++$key, $faq->question, $faq->answer, $faq->product ? $faq->product->name : '',$is_active];
                $data['tableData'][] = $result;
            }
            $pdf = PDF::loadView('pdf.pages', $data);
            return $pdf->setPaper('A4', 'potrait')->download('faq.pdf');
        }
        $filename = "faqs.".$request->export;
        return Excel::download(new FaqsExport($faqs), $filename);
    }

  /********* FILTER Faqs FOR Search ***********/
   public function filter(Request $request){
       return response()->json(["state" => "success", "message" =>  trans('messages.response.faqs.filter_success'),"faqs" => $this->getter($request)] );
   }

    /********* ADD NEW Faq ***********/
    public function store(CreateRequest $request)
    {
      $admin = auth()->user();
      $faq = $admin->faqs()->create($request->all());
      return response(["message" => trans('messages.response.faqs.create_success')]);
    }

    /********* View RECORD TO EDIT Or Display ***********/
    public function show($faq)
    {
        $faq = Faq::withAll()->find($faq);
        return  new FaqsResource($faq);
    }

    /********* UPDATE Faq ***********/
    public function update(CreateRequest $request, Faq $faq)
    {

      $faq->update($request->all());
        return response(["message" => trans('messages.response.faqs.update_success')]);

    }

    /********* UPDATE Faq Status***********/
    public function updateStatus(Request $request,Faq $faq){
        $faq->update([
          'is_active' => $faq->is_active == 1 ? 0:1
        ]);
        return response()->json(["state" => "success", "message" =>trans('messages.response.faqs.update_status_success'),"faqs" => $this->getter($request)] );
    }


    /********* DELETE LANGUAGE ***********/
    public function destroy(Request $request,Faq $faq)
    {

          $faq->delete();
          return response()->json(["state" => "success", "message" => trans('messages.response.faqs.delete_success'),"faqs" => $this->getter($request)] );
    }
}
