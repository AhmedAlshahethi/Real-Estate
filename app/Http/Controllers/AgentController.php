<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AgentController extends Controller
{
    public function AgentDashboard(){

        return view('agent.index');

    } // End Method 

    public function AgentLogin(){
        return view('agent.agent_login');
    }

    public function AgentRegister(Request $request){

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'agent',
            'status' => 'inactive',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::AGENT);

    } // End Method 


    public function AgentLogout(Request $request){
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

         $notification = array(
            'message' => 'Agent Logout Successfully',
            'alert-type' => 'success'
        ); 

        return redirect('/agent/login')->with($notification);

    } // End Method

    public function AgentProfile(){

        $id =Auth::user()->id;
        $profileData = User::find($id);

        return view('agent.agent_profile',compact('profileData'));
        
    } // End Method

    public function AgentProfileStore(Request $request){
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->username = $request->username;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('upload/agent_images/'.$data->photo));
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/agent_images'),$filename);
            $data['photo'] = $filename;
        }

        $data->save();

        $notification = array(
            'message' => 'Agent Profile Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // End Method

    public function AgentChangePassword(){
        $id = Auth::user()->id;
        $profileData = User::find($id);

        return view('agent.agent_change_password',compact('profileData'));

    } // End Method

    public function AgentUpdatePassword(Request $request){
        $id = Auth::user()->id;

        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        if (!Hash::check($request->old_password, Auth::user()->password)) {
            $notification = array(
                'message' => ' Old Password Did not match!',
                'alert-type' => 'error'
            );
    
            return redirect()->back()->with($notification);
        }

        User::findOrFail($id)->update([
            'password'=> Hash::make($request->new_password),
        ]);

        $notification = array(
            'message' => 'Password Changed Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
 