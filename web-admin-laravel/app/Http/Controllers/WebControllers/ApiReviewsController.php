<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Reviews\CreateRequest;
use App\Models\CMSModels\Review;
use App\Http\Resources\Web\ReviewsResource;
use App\Models\CMSModels\ReviewStatus;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ApiReviewsController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
    public function __construct()
    {
        // apply middleware to custom method
        $this->middleware('auth:customer-api')->only(['addProductReview']);
    }
    // Posts
    public static function allReviews()
    {
        $reviews = Review::withAll()->where('is_active', 1)->whereHas('review_status', function ($q) {
            $q->where('status', 'published');
        })
            ->has('product')->has('customer')->take(config('constants.reviews_limit'))->get();
        $reviews = ReviewsResource::collection($reviews);
        return $reviews;
    }

    public function reviewDetail($review)
    {
        $review = Review::withAll()->where('id', $review)->where('is_active', 1)->first();
        if ($review) {
            $review = new ReviewsResource($review);
            $response = generateResponse($review, true, '', [], 'object');
            return response($response);
        } else {
            $response = generateResponse('', false, trans('messages.response.web.post_not_found'), [], 'object');
            return response($response, 404);
        }
    }

    public function addProductReview(CreateRequest $request)
    {
        $review_status = ReviewStatus::where('is_active', 1)->where('is_default', 1)->first();
        $data = $request->all();
        $review_data = Review::where('customer_id', $request->customer_id)->where('product_id', $request->product_id)->where('order_id', $request->order_id)->first();
        if ($review_data) {
            $message = trans('messages.response.review.already_exist');
            $response = generateResponse(new ReviewsResource($review_data), false, $message, [], 'object');
            return response($response);
        } else {
            if ($review_status) {
                $data['is_active'] = 1;
                $data['review_status_id'] = $review_status->id;
            } else {
                $data['is_active'] = 1;
                $data['review_status_id'] = null;
            }

            if (!file_exists(public_path('customers'))) {
                mkdir(public_path('customers'), 0755, true);
            }
            if (!file_exists(public_path('customers/reviews_images'))) {
                mkdir(public_path('customers/reviews_images'), 0755, true);
            }
            $customer = Auth::user();
            $files = $request->file('images');
            if ($files) {
                foreach ($files as $file) {
                    $filename = $customer->first_name . '_' . $file->getClientOriginalName();
                    $file_resize = Image::make($file->getRealPath());
                    $file_resize->save(public_path('customers/reviews_images/' . $filename));
                    $file_urls[] = '/api/customers/reviews_images/' . $filename;

                }

                $data['images_url'] = json_encode($file_urls);
            }

            $review = Review::create($data);
            if ($review) {
                $message = trans('messages.response.review.create_successfully');
                $response = generateResponse(new ReviewsResource($review), true, $message, [], 'object');
                return response($response);
            }
        }
    }
}
