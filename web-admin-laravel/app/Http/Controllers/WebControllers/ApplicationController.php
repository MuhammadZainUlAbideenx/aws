<?php

namespace App\Http\Controllers\WebControllers;
use App\Http\Controllers\Controller;
use App\Models\CMSModels\ApplicationSliderImage;
use App\Http\Resources\Web\ApplicationSliderImagesResource;
use App\Models\CMSModels\ApplicationBanner;
use App\Http\Resources\Web\ApplicationBannersResource;
use App\Models\CMSModels\ApplicationParallaxBanner;
use App\Http\Resources\Web\ApplicationParallaxBannersResource;
use App\Models\CMSModels\ContentApplicationPage;
use App\Http\Resources\Web\ContentApplicationPagesResource;
use App\Http\Controllers\WebControllers\ApiNewsesController;
use App\Http\Controllers\WebControllers\ApiReviewsController;
class ApplicationController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
  public function __construct()
  {

  }
  public function allGenericData(){
    $slider_images = ApplicationSliderImage::whereDate('expiry_date','>=',now())->where('is_active',1)->get();
    $slider_images = ApplicationSliderImagesResource::collection($slider_images);

    $static_banners = ApplicationBanner::whereDate('expiry_date','>=',now())->where('is_active',1)->limit(2)->get();
    $static_banners = ApplicationBannersResource::collection($static_banners);

    $parallax_banners = ApplicationParallaxBanner::whereDate('expiry_date','>=',now())->where('is_active',1)->get();
    $parallax_banners = ApplicationParallaxBannersResource::collection($parallax_banners);

    $posts = ApiNewsesController::allFeaturedPosts();
    $reviews = ApiReviewsController::allReviews();

    $arr = ['slider_images' => $slider_images,'static_banners' => $static_banners,'parallax_banners' => $parallax_banners,
             'posts' => $posts,'reviews' => $reviews];
    $response = generateResponse($arr,true,'',[],'collection');
    return response($response);

  }
  public function applicationContentPages(){
      $content_pages = ContentApplicationPage::where('is_active',1)->get();
      $content_pages = ContentApplicationPagesResource::collection($content_pages);
      $response = generateResponse($content_pages,true,'',[],'collection');
      return response($response);


  }

}
