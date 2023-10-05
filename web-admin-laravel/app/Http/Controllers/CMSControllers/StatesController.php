<?php

namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\State;
use App\Http\Requests\CMS\States\CreateRequest;
use App\Http\Resources\CMS\StatesResource;
use Excel;
use App\Exports\CMS\StatesExport;
use App\Http\Requests\CMS\States\UpdateRequest;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Setting;
use PDF;
class StatesController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
      $this->middleware('auth:api',['except' =>['activeStates'] ]);
      $this->middleware('permission:states.index,guard:api',['except' =>['activeStates'] ]);
      $this->middleware('permission:states.create,guard:api',['only' => ['store']]);
      $this->middleware('permission:states.update,guard:api',['only' => ['update']]);
      $this->middleware('permission:states.delete,guard:api',['only' => ['destroy']]);
      $this->middleware('permission:states.update|states.is_active,guard:api',['only' => ['updateStatus']]);
  }

  /********* Getter For Pagination, Searching And Sorting  ***********/
  public function getter($req = null,$export = null)
  {
    if($req != null){
      $states = State::withAll();
      if($req->column && $req->column != null && $req->search && $req->search != null){
        $states = $states->whereLike($req->column,$req->search);
        }
       else if($req->search && $req->search != null){
            $states = $states->whereLike(['name','code','countries.name','zone.name'],$req->search);
        }
      if($req->sort !=null && $req->sort["field"] != null && $req->sort["type"] != null){
        $states = $states->OrderBy($req->sort["field"],$req->sort["type"]);
      }
      else
      {
        $states = $states->OrderBy('id','desc');
      }
      if($export != null){ // for export do not paginate
        $states = $states->get();
        return $states;
      }
      $totalStates = $states->count();
      $states = $states->paginate($req->perPage);
      $states = StatesResource::collection($states)->response()->getData(true);
      return $states;
    }
    $states = State::withAll()->orderBy('id','desc')->paginate(10);
    $states = StatesResource::collection($states)->response()->getData(true);
    return $states;
  }

  /********* FETCH ALL States ***********/
    public function index()
    {
        $arrayName = array('states' => $this->getter());
        return response($arrayName);
    }
      /********* Export PDF , CSV And Excel  **********/
    public function export(Request $request)
    {

        $states = $this->getter($request,"export");
        if ($request->export == 'pdf')
        {
            $allSettings = Setting::where('name', 'web_logo_image_id')->first();
            $logo = Media::find((int)$allSettings->value);
            $new_logo = str_replace("/api/", "", $logo->original_media_path);
            $data['general'] = [
                'currentDate' => date("Y-m-d"),
                'fileName' => "States",
                'reportName' => "States",
                'logo' => $new_logo,
            ];
            $data['tableHeaders'] = ["Sr#", "Name", "Code", "Zone", "Country", "Status"];
            $data['tableData'] = [];
            foreach ($states as $key => $state) {
                if ($state->is_active == 1) {
                    $is_active = "Active";
                } else {
                    $is_active = "Inactive";
                }

                $result = [++$key, $state->name, $state->code, $state->zone ? $state->zone->name : "", $state->countries ? $state->countries->name : "" ,$is_active];
                $data['tableData'][] = $result;
            }

            $pdf = PDF::loadView('pdf.pages', $data);
            return $pdf->setPaper('A4', 'potrait')->download('states.pdf');
        }
        $filename = "states.".$request->export;
        return Excel::download(new StatesExport($states), $filename);
    }

  /********* FILTER States FOR Search ***********/
   public function filter(Request $request){
       return response()->json(["state" => "success", "message" =>trans('messages.response.states.filter_success'),"states" => $this->getter($request)] );
   }

    /********* ADD NEW State ***********/
    public function store(CreateRequest $request)
    {
      State::create($request->all());
      return response(["message" => trans('messages.response.states.create_success')]);
    }

    /********* View RECORD TO EDIT Or Display ***********/
    public function show( $state)
    {
        $state = State::withAll()->find($state);
        return new StatesResource($state);
    }

    /********* UPDATE State ***********/
    public function update(UpdateRequest $request, State $state)
    {
        $state->update($request->all());
        return response(["message" => trans('messages.response.states.update_success')]);
    }

    /********* UPDATE Manufacturer Status***********/
    public function updateStatus(Request $request,State $state){
        $state->update([
          'is_active' => $state->is_active == 1 ? 0:1
        ]);
        return response()->json(["state" => "success", "message" => trans('messages.response.states.update_status_success'),"states" => $this->getter($request)] );
    }

    /********* DELETE LANGUAGE ***********/
    public function destroy(Request $request,State $state)
    {
      if($state->city){
        $state->city()->delete();
      }
          $state->delete();
          return response()->json(["state" => "success", "message" => trans('messages.response.states.delete_success'),"states" => $this->getter($request)] );
    }
}
