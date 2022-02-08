<?php

namespace App\Http\Controllers;

use App\Events\ChatMessageEvent;
use App\Models\ChatMessage;
use App\Services\ChatMessageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis as LRedis;

class ChatMessageController extends Controller
{
    public function __construct()
    {
        $this->chatMessage = new ChatMessage;
        $this->chatMessageService = new ChatMessageService;
        $this->redis = LRedis::connection();
    }

    public function sendMessage(Request $request){
        $request->validate([
            'receiver_id'=>'required',
            'message'=>'required'
        ]);
        try {
            $redis = $this->redis;
            $response=$this->chatMessageService->createChatMessage($request->all(),$request->user());
            if (isset($response['status']) && $response['status']=='fail') {
                return response()->json([
                    'status'=>'fail',
                    'status_code'=>200,
                    'message'=>$response['result']
                ]);
            }
//            broadcast(new ChatMessageEvent($request->user()->id,$request->receiver_id,$response['result']));
            $redis->publish('message',$response['result']);
            return response()->json([
               'status'=>'success',
               'status_code'=>200,
               'data'=>$response['result']
            ]);
        }catch (\Exception $exception){
            return response()->json([
                'status'=>'fail',
                'status_code'=>$exception->getCode(),
                'message'=>$exception->getMessage()
            ]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchMessages(Request $request){
        $request->validate([
            'receiver_id'=>'required'
        ]);
        try {
            $response = $this->chatMessageService->getMessages($request->user(),$request->all());
            return response()->json([
                'status'=>'success',
                'status_code'=>200,
                'data'=>['messages'=>$response['result'],'total'=>$response['total']]
            ]);
        }catch (\Exception $exception){
            return response()->json([
                'status'=>'fail',
                'status_code'=>$exception->getCode(),
                'message'=>$exception->getMessage()
            ]);
        }
    }
}
