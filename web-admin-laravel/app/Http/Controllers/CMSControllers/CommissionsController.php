<?php

namespace App\Http\Controllers\CMSControllers;

use App\Http\Controllers\Controller;
use App\Models\CMSModels\CommissionCategory;
use App\Models\CMSModels\CommissionSale;
use Illuminate\Http\Request;
use App\Http\Requests\CMS\Commissions\CreateRequest;
use App\Http\Resources\CMS\CommissionCategoriesResource;
use App\Http\Resources\CMS\CommissionSalesResource;

class CommissionsController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('permission:commissions.index,guard:api');
        $this->middleware('permission:commissions.update,guard:api', ['only' => ['store']]);
    }

    /********* ADD NEW Commission ***********/
    public function store(CreateRequest $request)
    {
        // dd($request->all());
        $allSettings = allSettings();
        if ($allSettings['is_multi_vendor'] == 1) {
            if ($allSettings['vendor_commission_type'] == 0) {
                foreach ($request->commission_by_category as $value) {

                    if(isset($value['commission_min_amount_fixed'])){
                        $commission_min_amount_fixed =   $value['commission_min_amount_fixed'];
                    }else{
                        $commission_min_amount_fixed =   null;
                    }
                    CommissionCategory::where('category_id', $value['category_id'])->updateOrCreate([
                        'category_id' => $value['category_id']
                    ], [
                        'category_id' => $value['category_id'],
                        'rate' => $value['rate'],
                        'rate_type' => $value['rate_type'],
                        'commission_min_amount_fixed' => $commission_min_amount_fixed,
                    ]);
                }
            } else {
                CommissionSale::truncate();
                foreach ($request->commission_by_sale as $value) {
                    CommissionSale::Create($value);
                }
            }
            return response(["message" => trans('messages.response.commissions.update_success')]);
        } else {
            return response(["state" => "fail", "message" => trans('messages.response.commissions.not_multi_vendor')]);
        }
    }

    /********* View RECORD TO EDIT Or Display ***********/
    public function show($id)
    {
        $allSettings = allSettings();
        if ($allSettings['is_multi_vendor'] == 1) {
            if ($allSettings['vendor_commission_type'] == 0) {
                //Commission By category
                $commission = CommissionCategory::get();
                return  CommissionCategoriesResource::collection($commission);
            } else if ($allSettings['vendor_commission_type'] == 1) {
                $commission =  CommissionSale::get();
                return CommissionSalesResource::collection($commission);
            } else {
                abort(404);
            }
        }
    }
    public function destroy($commissionCategory)
    {
        $delete = CommissionCategory::find($commissionCategory);
        if ($delete) {
            CommissionCategory::where('id', $commissionCategory)->delete();

            return response()->json(["state" => "success", "message" => trans('messages.response.commissions.delete_success'), "commissions" => CommissionCategory::all()]);
        } else {
            return response()->json(["state" => "error", "message" => trans('messages.response.commissions.not_found'), "commissions" => CommissionCategory::all()]);
        }
    }
}
