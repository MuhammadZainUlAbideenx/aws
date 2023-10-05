<?php

namespace App\Http\Controllers\WebControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\News;
use App\Http\Resources\Web\NewsesResource;

class ApiNewsesController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
    public function __construct()
    {

    }
    public function getter($req = null,$export = null){
        $posts =  News::withAll()->has('user')->where('is_active',1);
        if(count($req->all()) != 0){
          $sort = json_decode($req->sort);
          if($req->column && $req->column != null && $req->search && $req->search != null){
            if($req->column == 'name'){
              $posts = $posts->whereLike($req->column.'->'.app()->getLocale(),$req->search);
            }
            else{
              $posts = $posts->whereLike($req->column,$req->search);
              }
            }
           else if($req->search && $req->search != null){

                $posts = $posts->whereLike(['name->'.app()->getLocale()],$req->search);
            }
          if($sort !=null && $sort->field != null && $sort->type != null){
            $posts = $posts->OrderBy($sort->field,$sort->type);
          }
          else
          {
            $posts = $posts->OrderBy('id','desc');
          }
          $posts = $posts->paginate($req->perPage);
          $posts = NewsesResource::collection($posts)->response()->getData(true);

          return $posts;
        }
        $posts = $posts->orderBy('id','desc')->paginate(12);
        $posts = NewsesResource::collection($posts)->response()->getData(true);
        return $posts;
      }
    // Posts
    public static function allFeaturedPosts(){
        $posts = News::withAll()->has('user')->where('is_active',1)->where('is_featured',1)->orderBy('is_featured','DESC')->take(config('constants.posts_limit'))->get();
        $posts = NewsesResource::collection($posts);
        return $posts;
    }

    public function allPostss(Request $request){
        $allposts = $this->getter($request);

        $response = generateResponse($allposts,true,'',[],'collection');
        return response($response);
    }

    public function postDetail($slug){
        $post = News::withAll()->where('slug',$slug)->where('is_active',1)->first();
        $post['latest_posts'] = News::withAll()->orderBy('id','DESC')->where('is_active',1)->get()->take(5);
        if($post){
          $post = new NewsesResource($post);
          $response = generateResponse($post,true,'',[],'object');
          return response($response);
        }
        else{
          $response = generateResponse('',false,trans('messages.response.web.post_not_found'),[],'object');
          return response($response,404);
        }
    }

    public function postDetailMobile(Request $request){
        $post = News::withAll()->where('id',$request->id)->where('is_active',1)->first();
        $post['latest_posts'] = News::withAll()->orderBy('id','DESC')->where('is_active',1)->get()->take(5);
        if($post){
          $post = new NewsesResource($post);
          $response = generateResponse($post,true,'',[],'object');
          return response($response);
        }
        else{
          $response = generateResponse('',false,trans('messages.response.web.post_not_found'),[],'object');
          return response($response,404);
        }
    }
}
