<?php

namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\ContactForm;
use App\Http\Requests\CMS\ContactForms\CreateRequest;
use App\Http\Resources\CMS\ContactFormsResource;
use Excel;
use Str;
use App\Exports\CMS\ContactFormsExport;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Setting;
use PDF;
class ContactFormsController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
      $this->middleware('auth:api');
      $this->middleware('permission:contact_forms.index,guard:api');
      $this->middleware('permission:contact_forms.create,guard:api',['only' => ['store']]);
      $this->middleware('permission:contact_forms.update,guard:api',['only' => ['update']]);
      $this->middleware('permission:contact_forms.delete,guard:api',['only' => ['destroy']]);
      $this->middleware('permission:contact_forms.update|contact_forms.is_active,guard:api',['only' => ['updateStatus']]);
  }

  /********* Getter For Pagination, Searching And Sorting  ***********/
  public function getter($req = null,$export = null)
  {
    if($req != null){
      $contact_forms = new ContactForm;
      if($req->column && $req->column != null && $req->search && $req->search != null){
        if($req->column == 'name'){
          $contact_forms = $contact_forms->whereLike($req->column.'->'.app()->getLocale(),$req->search);
        }
        else{
          $contact_forms = $contact_forms->whereLike($req->column,$req->search);
          }
        }
       else if($req->search && $req->search != null){
            $contact_forms = $contact_forms->whereLike(['name->'.app()->getLocale()],$req->search);
        }
      if($req->sort !=null && $req->sort["field"] != null && $req->sort["type"] != null){
        $contact_forms = $contact_forms->OrderBy($req->sort["field"],$req->sort["type"]);
      }
      else
      {
        $contact_forms = $contact_forms->OrderBy('id','desc');
      }
      if($export != null){ // for export do not paginate
        $contact_forms = $contact_forms->get();
        return $contact_forms;
      }
      $totalContactForms = $contact_forms->count();
      $contact_forms = $contact_forms->paginate($req->perPage);
      $contact_forms = ContactFormsResource::collection($contact_forms)->response()->getData(true);
      return $contact_forms;
    }
    $contact_forms = ContactFormsResource::collection(ContactForm::orderBy('id','desc')->paginate(10))->response()->getData(true);
    return $contact_forms;
  }

  /********* FETCH ALL ContactForms ***********/
    public function index()
    {
        $arrayName = array('contact_forms' => $this->getter());
        return response($arrayName);
    }
      /********* Export PDF , CSV And Excel  **********/
    public function export(Request $request)
    {
        $contact_forms = $this->getter($request,"export");
        if ($request->export == 'pdf') {
            $allSettings = Setting::where('name', 'web_logo_image_id')->first();
            $logo = Media::find((int)$allSettings->value);
            $new_logo = str_replace("/api/", "", $logo->original_media_path);
            $data['general'] = [
                'currentDate' => date("Y-m-d"),
                'fileName' => "Contact Form",
                'reportName' => "Contact Form",
                'logo' => $new_logo,
            ];
            $data['tableHeaders'] = ["Sr#", "Name", "Email", "Subject", "Message", "Status"];
            $data['tableData'] = [];
            foreach ($contact_forms as $key => $contact_form) {
                if ($contact_form->is_active == 1) {
                    $is_active = "Active";
                } else {
                    $is_active = "Inactive";
                }

                $result = [++$key, $contact_form->name, $contact_form->email,$contact_form->subject , $contact_form->message ,$is_active];
                $data['tableData'][] = $result;
            }
            $pdf = PDF::loadView('pdf.pages', $data);
            return $pdf->setPaper('A4', 'potrait')->download('contact_form.pdf');
        }
        $filename = "contact_forms.".$request->export;
        return Excel::download(new ContactFormsExport($contact_forms), $filename);
    }

  /********* FILTER ContactForms FOR Search ***********/
   public function filter(Request $request){
       return response()->json(["state" => "success", "message" => trans('messages.response.contact_forms.filter_success'),"contact_forms" => $this->getter($request)] );
   }

    /********* ADD NEW ContactForm ***********/
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
      $contact_form = ContactForm::create($data);
      return response(["message" => trans('messages.response.contact_forms.create_success')]);
    }

    /********* View RECORD TO EDIT Or Display ***********/
    public function show($contact_form)
    {
        $contact_form = ContactForm::find($contact_form);
        return new ContactFormsResource($contact_form);
    }

    /********* UPDATE ContactForm ***********/
    public function update(CreateRequest $request, ContactForm $contact_form)
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
      $contact_form->update($data);
        return response(["message" => trans('messages.response.contact_forms.update_success')]);

    }

    /********* UPDATE Manufacturer Status***********/
    public function updateStatus(Request $request,ContactForm $contact_form){
        $contact_form->update([
          'is_active' => $contact_form->is_active == 1 ? 0:1
        ]);
        return response()->json(["state" => "success", "message" => trans('messages.response.contact_forms.update_status_success'),"contact_forms" => $this->getter($request)] );
    }

    /********* DELETE LANGUAGE ***********/
    public function destroy(Request $request,ContactForm $contact_form)
    {
          $contact_form->delete();
          return response()->json(["state" => "success", "message" => trans('messages.response.contact_forms.delete_success'),"contact_forms" => $this->getter($request)] );
    }
}
