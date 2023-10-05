<?php

namespace App\Http\Controllers\CMSControllers;
use App\Http\Controllers\Controller;
use App\Models\CMSModels\Inventory;
use App\Models\CMSModels\Product;
use App\Http\Requests\CMS\Inventories\CreateRequest;
use Intervention\Image\ImageManagerStatic as Image;
use FFMpeg;
use Artisan;
use Illuminate\Support\Facades\App;

class InventoriesController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {
      $this->middleware('auth:api');
      $this->middleware('permission:inventories.index,guard:api');
      $this->middleware('permission:inventories.update,guard:api',['only' => ['updateGeneralProductInventories']]);
      $this->middleware('permission:inventories.update,guard:api',['only' => ['updateProductInventories']]);
  }

    /********* ADD OR UPDATE Inventory ***********/
    public function store(CreateRequest $request)
    {
      if($request->product_type == 1 || $request->product_type == 3 || $request->product_type == 4)
      {
        //simple
        return $this->updateProductInventoriesSimple($request);
      }
      else if($request->product_type == 2)
      {
        //Variable
        return $this->updateProductInventoriesVariable($request);
      }
    }
    /********* Update Genreral ProductInventories ***********/
    public function updateProductInventoriesSimple($request)
    {
      $product_inventory = Inventory::create($request->all());
        return response()->json(['message' =>  trans('messages.response.inventory.update_success')], 200);
    }

    public function updateProductInventoriesVariable($request)
    {

      return response()->json(['message' =>  trans('messages.response.inventory.update_success')], 200);
    }

}
