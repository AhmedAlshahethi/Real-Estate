<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PropertyMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertyMessageController extends Controller
{
    public function AgentPropertyMessage(){
        $id = Auth::user()->id;
        $usermsg = PropertyMessage::where('agent_id',$id)->get();

        return view('agent.message.all_messages',compact('usermsg'));
    }

    public function AgentMessageDetails($msg_id){
        $id = Auth::user()->id;
        $usermsg = PropertyMessage::where('agent_id',$id)->get();

        $msgdetails = PropertyMessage::findOrFail($msg_id);

        return view('agent.message.message_details',compact('usermsg','msgdetails'));
    }

    public function AdminPropertyMessage(){
        $usermsg = PropertyMessage::latest()->get();

        return view('backend.message.all_messages',compact('usermsg'));
    }

    public function AdminMessageDetails($msg_id){
        

        $msgdetails = PropertyMessage::findOrFail($msg_id);

        return view('backend.message.message_details',compact('msgdetails'));
    }


    
}



