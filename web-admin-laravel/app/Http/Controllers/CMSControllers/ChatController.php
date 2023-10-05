<?php

namespace App\Http\Controllers\CMSControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\General\MessageRequest;
use App\Http\Resources\General\MessageResource;
use App\Models\CMSModels\Message;
use App\Events\MessageSent;
use App\Models\Rider as Rider;

class ChatController extends Controller
{
    public $guard;
    public function __construct()
    {
      $this->middleware('auth:api');
    //   $this->middleware('permission:live_chat.index,guard:api');
    //   $this->middleware('permission:live_chat.create,guard:api',['only' => ['store']]);
    //   $this->middleware('permission:live_chat.update,guard:api',['only' => ['update']]);
    //   $this->middleware('permission:live_chat.delete,guard:api',['only' => ['destroy']]);
    //   $this->middleware('permission:live_chat.update|live_chat.is_active,guard:api',['only' => ['updateStatus']]);
    }

    public function StoreMessage(MessageRequest $request)
    {

        $data = $request->only('message', 'sender_id', 'receiver_id', 'user_type', 'order_number');
        $message = Message::create($data);
        broadcast(new MessageSent($message));
        $message = new MessageResource($message);
        $response = generateResponse($message, true,trans('messages.response.chat.create_success'), [], 'object');
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
            $response = generateResponse($data, true, trans('messages.response.chat.fetch_message'), [], 'object');
            return response($response);
        }
    }
    public function getRiderMessages()
    {
        $rider_ids = Rider::where('vendor_id', auth()->user()->id)->pluck('id')->toArray();
        $riderMessages = Message::with('rider')->where('user_type', 'rider')->whereIn('sender_id', $rider_ids)->orderBy('id', 'DESC')->get()->unique('order_number');
        $data = MessageResource::collection($riderMessages);
        $response = generateResponse($data, true, trans('messages.response.chat.fetch_message'), [], 'object');
        return response($response);
    }
}
