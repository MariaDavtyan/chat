<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupRequest;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    //Add new chat to db
    public function AddGroup(GroupRequest $request)
    {
        $filenameWithExt = $request->file('image')->getClientOriginalName();

        $filename = pathinfo($filenameWithExt,PATHINFO_FILENAME);
        $extension = $request->file('image')->getClientOriginalExtension();

        $fileNameToStore = $filename.'_'.time().'_'.$extension;

        $path = $request->file('image')->storeAs('public/group_images',$fileNameToStore);

        //send data to db
        $name = $request->input('chat_name');
        $imagename = $fileNameToStore;
        $access = $request->input('optradio');
        $access_link = null;
        if($access == "privatechat")
        {
            $access_link = str_random(10);
        }

        Chat::insert([
            'chat_name'     =>  $name,
            'image'         =>  $imagename,
            'access'        =>  $access,
            'private_chat'  =>  $access_link,
            'user_id'       =>  Auth::user()->id,
            'created_at'    =>  date('Y-m-d H:i:s'),
        ]);

        return redirect('/')->with('success','Group added successfully');
    }

    //Get private chat
    public function GetPrivateChat($url)
    {
        $private_chats = Chat::where('private_chat',$url)->get();

        if($private_chats->isEmpty())
        {
            return redirect('/');
        }

        $private_chat_id = $private_chats->pluck('id');

        $messages = Message::where('chat_id',$private_chat_id)
                            ->get();

        foreach($messages as $value)
        {
            $value['username'] = 'Guest';
            if($value->user_id != null)
            {
                $user_info = User::select('name')->where(['id' => $value->user_id])->first();
                if($user_info->name)
                {
                    $value['username'] = $user_info->name;
                }
            }
        }
        return view('privatechat')->with(['privatechat' => $messages,'chat_info' => $private_chats[0]]);
    }
}