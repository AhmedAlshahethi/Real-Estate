<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\State;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;

class StateController extends Controller
{
    public function AllState(){
        $states = State::latest()->get();

        return view("Backend.state.all_states",compact("states"));
    } 

    public function AddState(){
        return view("Backend.state.add_states");
    }

    public function StoreState(Request $request){

        $manager = new ImageManager(new Driver());
        $image = $request->file('state_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        $manager->read($image)->resize(370,275)->save(base_path('public/upload/state/'.$name_gen));
        $save_url = 'upload/state/'.$name_gen;

        State::insert([
            'state_name' => $request->state_name,
            'state_image' => $save_url,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'State created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.state')->with($notification);
    }

    public function EditState($id){
        $state = State::find($id);

        return view('Backend.state.edit_state',compact('state'));
    }

    public function UpdateState(Request $request){
        $state_id = $request->id;

        if ($request->file('state_image')) {

        $manager = new ImageManager(new Driver());
        $image = $request->file('state_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        $manager->read($image)->resize(370,275)->save(base_path('public/upload/state/'.$name_gen));
        $save_url = 'upload/state/'.$name_gen;

        State::findOrFail($state_id)->update([
            'state_name' => $request->state_name,
            'state_image' => $save_url,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'State updated with Image Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.state')->with($notification);

        } else {

            State::findOrFail($state_id)->update([
                'state_name' => $request->state_name,
                'updated_at' => Carbon::now(),
            ]);
    
            $notification = array(
                'message' => 'State updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.state')->with($notification);
        }
        
    }

    public function DeleteState($id){

        $state = State::findOrFail($id);

        unlink($state->state_image);

        State::findOrFail($id)->delete();

        $notification = array(
            'message' => 'State deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
