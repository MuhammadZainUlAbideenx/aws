<?php

namespace App\Http\Controllers\CMSControllers;

use App\Exports\CMS\PayoutRequestsExport;
use App\Http\Controllers\Controller;
use App\Http\Controllers\GeneralControllers\WalletController;
use App\Http\Resources\CMS\PayoutRequestsResource;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\PayoutRequest;
use App\Models\CMSModels\Setting;
use App\Models\CMSModels\Wallet;
use Illuminate\Http\Request;
use PDF;
use Excel;

class PayoutRequestController extends Controller
{
    public $guard;
    /********* Initialize Permission based Middlewares  ***********/
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('permission:payout_requests.index,guard:api');
        $this->middleware('permission:payout_requests.create,guard:api', ['only' => ['store']]);
        $this->middleware('permission:payout_requests.update,guard:api', ['only' => ['update']]);
        $this->middleware('permission:payout_requests.delete,guard:api', ['only' => ['destroy']]);
        $this->middleware('permission:payout_requests.update|payout_requests.is_active,guard:api', ['only' => ['updateStatus']]);
    }
    /********* Getter For Pagination, Searching And Sorting  ***********/
    public function getter($req = null, $export = null)
    {

        if ($req != null) {
            $payoutRequests = PayoutRequest::with('vendor')->whereNull('rider_id');
            if ($req->column && $req->column != null && $req->search && $req->search != null) {
                if ($req->column == 'vendor_name') {
                    $payoutRequests = $payoutRequests->whereLike('vendor.name', $req->search);
                } else {
                    $payoutRequests = $payoutRequests->whereLike($req->column, $req->search);
                }
            } else if ($req->search && $req->search != null) {
                $payoutRequests = $payoutRequests->whereLike('vendor.name', $req->search);
            }
            if ($req->sort != null && $req->sort["field"] != null && $req->sort["type"] != null) {
                $payoutRequests = $payoutRequests->OrderBy($req->sort["field"], $req->sort["type"]);
            } else {
                $payoutRequests = $payoutRequests->OrderBy('id', 'desc');
            }
            if ($export != null) { // for export do not paginate
                $payoutRequests = $payoutRequests->get();
                return $payoutRequests;
            }
            $totalPayoutRequests = $payoutRequests->count();
            $payoutRequests = $payoutRequests->paginate($req->perPage);
            $payoutRequests = PayoutRequestsResource::collection($payoutRequests)->response()->getData(true);
            return $payoutRequests;
        }
        $payoutRequests = PayoutRequest::with('vendor')->whereNull('rider_id')->orderBy('id', 'desc')->paginate(10);
        $payoutRequests = PayoutRequestsResource::collection($payoutRequests)->response()->getData(true);
        return $payoutRequests;
    }
    /********* FILTER PayoutRequests FOR Search ***********/
    public function filter(Request $request)
    {
        return response()->json(["state" => "success", "message" => trans('messages.response.payoutRequest_status.filter_success'), "payoutRequests" => $this->getter($request)]);
    }

    /********* FETCH ALL Payouts ***********/
    public function index()
    {
        $arrayName = array('payoutRequests' => $this->getter());
        return response($arrayName);
    }

    /********* Export PDF , CSV And Excel  **********/
    public function export(Request $request)
    {
        $payoutRequests = $this->getter($request, "export");
        if ($request->export == 'pdf') {
            $allSettings = Setting::where('name', 'web_logo_image_id')->first();
            $logo = Media::find((int)$allSettings->value);
            $new_logo = str_replace("/api/", "", $logo->original_media_path);
            $data['general'] = [
                'currentDate' => date("Y-m-d"),
                'fileName' => "PayoutRequests",
                'reportName' => "PayoutRequests",
                'logo' => $new_logo,
            ];
            $data['tableHeaders'] = ["Sr#", "Vendor Name", "Amount", "Note", "Status", "Date"];
            $data['tableData'] = [];
            foreach ($payoutRequests as $key => $payout) {
                if ($payout->status == 1) {
                    $status = "Pending";
                } else if ($payout->status == 2) {
                    $status = "Approved";
                } else {
                    $status = "Rejected";
                }
                $result = [++$key, $payout->vendor->name, $payout->amount, $payout->note, $status, date('d-m-Y', strtotime($payout->created_at))];
                $data['tableData'][] = $result;
            }
            $pdf = PDF::loadView('pdf.pages', $data);
            return $pdf->setPaper('A4', 'potrait')->download('payoutRequests.pdf');
        }
        $filename = "payoutRequests." . $request->export;
        return Excel::download(new PayoutRequestsExport($payoutRequests), $filename);
    }

    /********* UPDATE PayoutRequests Status***********/
    public function updateStatus(Request $request, $payoutRequest_id, $status)
    {
        $payoutRequest = PayoutRequest::find($payoutRequest_id);

        $wallet = Wallet::where('user_type', 'vendor')->where('reference_table_id', $payoutRequest->vendor_id)->first();
        if ($payoutRequest->amount <= $wallet->balance) {
            $payoutRequestStatus = PayoutRequest::where('id', $payoutRequest->id)->update([
                'status' => $status,
            ]);
            $payoutRequest = PayoutRequest::find($payoutRequest_id);
            if ($payoutRequest->status == 2) {
                $wallet = new WalletController;
                $result = $wallet->SendAmountToVendor($payoutRequest->vendor_id, $payoutRequest->amount, "vendor");
            }
            return response()->json(["state" => "success", "message" => trans('messages.response.payoutRequest_status.update_status_success')]);
        } else {
            return response()->json(["state" => "fail", "message" => trans('messages.response.payoutRequest_status.insufficient_balance')]);
        }
    }
}
