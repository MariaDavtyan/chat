<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\MessagePusherEvent;

class MessageController extends Controller
{
    public function AddMessageToDb(Request $request)
    {
        $user_ip = null;
        $user_id = null;
        if(!Auth::user())
        {
            $user_ip    = request()->ip();
            $user_name  = 'Guest';
        }
        else
        {
            $user_id    = Auth::id();
            $user_name  = Auth::user()->name;
        }

        //insert message to db
        Message::insert([
            'user_id'       => $user_id,
            'chat_id'       => $request->chat_id,
            'message'       => $request->message,
            'user_ip'       => $user_ip,
            'created_at'    =>  date('Y-m-d H:i:s'),
        ]);

        //get chat name
        $chat_name = Chat::where(['id' => $request->chat_id])
                ->select('chat_name')
                ->get();
        $group_name = null;
        $group_name = $chat_name->pluck('chat_name');

        //data sent to event
        $data = [
            'message'       => $request->message,
            'created_at'    => date('Y-m-d H:i:s'),
            'username'      => $user_name,
            'chat_name'     => $group_name,
        ];

        event(new MessagePusherEvent($data));
        return response()->json($data);
    }

    //ajax request to get chat info
    public function GetChatInfo(Request $request)
    {
        $info = Message::where(['chat_id'=>$request->chat_id])
                        ->join('chats','messages.chat_id','=','chats.id')
                        ->select('chats.chat_name','messages.*')
                        ->get();

        foreach($info as $value)
        {
            if($value->user_id != null)
            {
                $user_info = User::select('name','email')->where(['id' => $value->user_id])->first();
                $value['user'] = $user_info;
            }
        }
        return response()->json($info);
    }
}
