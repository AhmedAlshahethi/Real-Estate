<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManageUsersController extends Controller
{
    public function AllAgent(){
        $allagents = User::where('role','agent')->get();

        return view('backend.agent_users.all_agents',compact('allagents'));

    } //End Method

    public function AddAgent(){
        return view('backend.agent_users.add_agent');

    } //End Method

    public function StoreAgent(Request $request){
        
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:'.User::class,
            'email' => 'required|unique:'.User::class,
            'phone' => 'required|unique:'.User::class,
            'address' => 'required',
            'password' => 'required|confirmed',
        ]);

        User::create([
            'name'=> $request->name,
            'username'=> $request->username,
            'email'=> $request->email,
            'phone'=> $request->phone,
            'address'=> $request->address,
            'password'=> Hash::make($request->password),
            'role'=> 'agent',
            'status'=> 'active',
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Agent created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.agent')->with($notification);

    } //End Method

    public function EditAgent($id){
        $agentData = User::findOrFail($id);

        return view('backend.agent_users.edit_agent',compact('agentData'));

    } //End Method

    public function UpdateAgent(Request $request){

        $id = $request->id;
        

        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:'.User::class,
            'email' => 'required|unique:'.User::class,
            'phone' => 'required|unique:'.User::class,
            'address' => 'required',
        ]);

        User::where('id',$id)->update([
            'name'=> $request->name,
            'username'=> $request->username,
            'email'=> $request->email,
            'phone'=> $request->phone,
            'address'=> $request->address,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Agent updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } //End Method

    public function DeleteAgent($id){

        User::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Agent deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.agent')->with($notification);

    } //End Method

    public function ActiveAgent(Request $request){

        User::where('id',$request->id)->update([
            'status' => 'active',
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Status Changed Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } //End Method

    public function InactiveAgent(Request $request){

        User::where('id',$request->id)->update([
            'status' => 'inactive',
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Status Changed Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } //End Method
}
