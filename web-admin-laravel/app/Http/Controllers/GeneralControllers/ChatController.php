<?php

namespace App\Http\Controllers\GeneralControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\General\FetchMessageRequest;
use App\Http\Requests\General\MessageRequest;
use App\Http\Resources\General\MessageResource;
use App\Models\CMSModels\Message;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;
use App\Http\Requests\General\FetchVendorMessageRequest;
use App\Models\CMSModels\Rider;
use App\Models\Rider as ModelsRider;

class ChatController extends Controller
{
    public $guard;
    public function __construct()
    {
        if (auth('customer-api')->check() && auth('customer-api')->user()->tokenCan('customer')) {
            $this->middleware('auth:customer-api');
            $this->guard = 'customer';
        } elseif (auth('rider-api')->check() && auth('rider-api')->user()->tokenCan('rider')) {
            $this->middleware('auth:rider-api');
            $this->guard = 'rider';
        } elseif (auth('vendor-api')->check() && auth('vendor-api')->user()->tokenCan('vendor')) {
            $this->middleware('auth:vendor-api');
            $this->guard = 'vendor';
        } else {
            $this->middleware('auth:admin-api');
            $this->guard = 'admin';
        }
    }

    public function StoreMessage(MessageRequest $request)
    {

        $user = Auth::user();
        $data = $request->only('message','sender_id','receiver_id','user_type','order_number');
        $message = Message::create($data);
        broadcast(new MessageSent($message));
        $message = new MessageResource($message);
        $response = generateResponse($message,true,'store message successfully',[],'object');
        return response()->json($response, 200);
    }

    public function FetchMessage(FetchMessageRequest $request)
    {
        $user = Auth::user();

        // $data = Message::where('sender_id',$request->sender_id)->where('receiver_id',$request->receiver_id)->where('user_type',$request->user_type)->orderBy('id','desc')->with($request->user_type)->get();
        $data = Message::where(function($q) use ($request) {

            $q->orWhere('sender_id',$request->sender_id);
            $q->orWhere('receiver_id',$request->sender_id);

    })->where(function($q) use ($request){

        $q->orWhere('sender_id',$request->receiver_id);
        $q->orWhere('receiver_id',$request->receiver_id);

    })->where('order_number',$request->order_number)->with($request->user_type)->get();
        if($data)
        {
           $data = MessageResource::collection($data);
           $response = generateResponse($data,true,'fetch message successfully',[],'object');
           return response($response);
        }
    }

    public function FetchVendorMessage(FetchVendorMessageRequest $request)
    {
        $rider = ModelsRider::where('id',$request->rider_id)->first();
        $data = Message::with('vendor')->where('receiver_id',$rider->vendor_id)->where('sender_id',$rider->id)->orderBy('id','desc')->get()->unique('order_number');
        if($data)
        {
           $data = MessageResource::collection($data);
           $response = generateResponse($data,true,'fetch message successfully',[],'object');
           return response($response);
        }
    }
}
