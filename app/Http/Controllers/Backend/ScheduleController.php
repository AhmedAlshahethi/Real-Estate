<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Mail\ScheduleMail;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ScheduleController extends Controller
{
    public function StoreSchedule(Request $request){

        if (Auth::check()) {
            Schedule::insert([
                'user_id' => Auth::user()->id,
                'property_id' => $request->property_id,
                'agent_id' => $request->agent_id,
                'tour_date' => $request->tour_date,
                'tour_time' => $request->tour_time,
                'message' => $request->message,
                'created_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'The Request has been sent Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->back()->with($notification);

        } else {

            $notification = array(
                'message' => 'Please Login Your account first',
                'alert-type' => 'error'
            );
    
            return redirect()->back()->with($notification);
            
        }
    }

    public function AgentScheduleRequest(){
        $id = Auth::user()->id;
        $usermsg = Schedule::where('agent_id', $id)->get();

        return view('agent.schedule.all_schedules',compact('usermsg'));
    }

    public function AgentScheduleDetails($id){

        $schedule = Schedule::find($id);

        return view('agent.schedule.schedule_details',compact('schedule'));
    }

    public function AgentScheduleConfirm(Request $request){
        $id = $request->id;

        Schedule::findOrFail($id)->update([
            'status' => '1',
            'updated_at' => Carbon::now(),
        ]);

        //Send Mail

        $sendmail = Schedule::findorFail($id);

        $data =[
            'tour_date' => $sendmail->tour_date,
            'tour_time' => $sendmail->tour_time,
        ];

        Mail::to($request->email)->send(new ScheduleMail($data));

        //End send Mail

        $notification = array(
            'message' => 'You have confirmed the request Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('agent.schedule.request')->with($notification);
    }


    public function UserScheduleRequest(){
        $id = Auth::user()->id;
        $userrequest = Schedule::where('user_id', $id)->get();

        return view('Frontend.schedule.schedule_requests',compact('userrequest'));
    }
}
