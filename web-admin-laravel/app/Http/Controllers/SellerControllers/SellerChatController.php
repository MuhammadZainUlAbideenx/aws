<?php

namespace App\Http\Controllers\SellerControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\General\FetchMessageRequest;
use App\Http\Requests\General\MessageRequest;
use App\Http\Resources\General\MessageResource;
use App\Models\CMSModels\Message;
use App\Events\MessageSent;
use App\Models\Rider as Rider;

class SellerChatController extends Controller
{
    public $guard;
    public function __construct()
    {
        $this->middleware('auth:vendor-api');
    }

    public function StoreMessage(MessageRequest $request)
    {

        $data = $request->only('message', 'sender_id', 'receiver_id', 'user_type', 'order_number');
        $message = Message::create($data);
        broadcast(new MessageSent($message));
        $message = new MessageResource($message);
        $response = generateResponse($message, true, 'store message successfully', [], 'object');
        return response()->json($response, 200);
    }

    public function FetchMessage($id)
    {
        $message = Message::where('id', $id)->first();
        $data = Message::where(function ($q) use ($message) {

            $q->orWhere('sender_id', $message->sender_id);
            $q->orWhere('receiver_id', $message->sender_id);
        })->where(function ($q) use ($message) {

            $q->orWhere('sender_id', $message->receiver_id);
            $q->orWhere('receiver_id', $message->receiver_id);
        })->where('order_number', $message->order_number)->with($message->user_type)->get();
        if ($data) {
            $data = MessageResource::collection($data);
            $response = generateResponse($data, true, 'fetch message successfully', [], 'object');
            return response($response);
        }
    }
    public function getRiderMessages()
    {
        $rider_ids = Rider::where('vendor_id', auth()->user()->id)->pluck('id')->toArray();
        $riderMessages = Message::with('rider')->where('user_type', 'rider')->whereIn('sender_id', $rider_ids)->orderBy('id', 'DESC')->get()->unique('order_number');
        $data = MessageResource::collection($riderMessages);
        $response = generateResponse($data, true, 'Fetch message successfully', [], 'object');
        return response($response);

    }
}
