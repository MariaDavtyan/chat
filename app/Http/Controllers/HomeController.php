<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class HomeController extends Controller
{
    public function WelcomePage()
    {
        $chat_names = $this->GetChats();
        $base_url = URL::to('/');
        return view('welcome')->with(['chats' => $chat_names, 'base_url' => $base_url]);
    }
    private function GetChats()
    {
        if(!Auth::user())
        {
            $chat_list = Chat::where('access','allusers')->get();
        }
        else
        {
            $chat_list = Chat::whereIn('access',['allusers','loggedinusers'])->get();
            $chat_protected_admin = Chat::where(['access' => 'privatechat', 'user_id' => Auth::id()])->get();
            if(!empty($chat_protected_admin))
            {
                $chat_list = $chat_list->merge($chat_protected_admin);
            }
        }

        return $chat_list;
    }
}
