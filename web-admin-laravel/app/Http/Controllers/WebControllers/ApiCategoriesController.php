<?php

namespace App\Http\Controllers\WebControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\Category;
use App\Http\Resources\Web\CategoriesResource;
use Illuminate\Support\Facades\Validator;

class ApiCategoriesController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
    public function __construct()
    {

    }
    // Categories
    public function allCategories(){
        $categories = Category::withAll()->where('is_active',1)->where('parent_id',0)->get();
        $categories = CategoriesResource::collection($categories);
        $response = [];
        $response = generateResponse($categories,count($categories) > 0 ? true:false,'',[],'collection');
        return response($response);
    }

    public function categoryDetail($category){
        $category = Category::withAll()->where('id',$category)->where('is_active',1)->first();
        if($category){
          $category = new CategoriesResource($category);
          $response = generateResponse($category,true,'',[],'object');
          return response($response);
        }
        else{
          $response = generateResponse('',false,trans('messages.response.web.category_not_found'),[],'object');
          return response($response,404);
        }
    }

    public function searchCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            $response = generateResponse('', false, '', $validator->errors(), 'object');
            return $response;
        }
        // dd(app()->getLocale());
        // $categories = Category::withAll()->whereLike('name'.'->'.app()->getLocale(),$request->name)->get();
        $categories = Category::withAll()->where('name','LIKE', '%' . $request->name . '%')->get();
        // dd(app()->getLocale());
        $categories = CategoriesResource::collection($categories);
        $response = generateResponse($categories,true,'',[],'object');
        return response($response);
    }
}
