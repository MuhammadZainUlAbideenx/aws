<?php

namespace App\Http\Controllers\SellerControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CMS\Payouts\CreateRequest;
use App\Http\Resources\CMS\OrdersResource;
use App\Http\Resources\CMS\PayoutRequestsResource;
use App\Models\CMSModels\PayoutRequest;
use App\Models\CMSModels\Wallet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SellerPayoutRequestController extends Controller
{
    public $guard;
    /********* Initialize Permission based Middlewares  ***********/
    public function __construct()
    {
        $this->middleware('auth:vendor-api');
    }

    public function createPayoutRequest(CreateRequest $request)
    {
        $data = $request->all();
        $wallet = Wallet::where('user_type', 'vendor')->where('reference_table_id', $request->vendor_id)->first();
        if ($wallet) {
            if ($request->amount <= $wallet->balance) {
                $data['status'] = 1;
                $data['rider_id'] = null;
                $created = PayoutRequest::create($data);
                if ($created) {
                    $response = generateResponse($created, True, 'Payout Request has been created Successfully', [], 'object');
                    return response($response);
                }
            } else {
                $response = generateResponse($wallet, false, 'Insufficient Ballance', [], 'object');
                return response($response);
            }
        }
    }
}
