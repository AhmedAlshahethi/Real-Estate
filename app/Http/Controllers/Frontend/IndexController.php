<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\Facility;
use App\Models\MultiImage;
use App\Models\Property;
use App\Models\PropertyMessage;
use App\Models\PropertyType;
use App\Models\State;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function PropertyDetails($id,$slug){

        $property = Property::findOrFail($id);

        $ame = $property->amenities_id;
        $ameneties = explode(",",$ame);

        $facilities = Facility::where("property_id",$id)->get();

        $multiImage = MultiImage::where('property_id',$id)->get();


        $type_id = $property->ptype_id;
        $relatedProperty = Property::where('ptype_id',$type_id)->where('id','!=', $id)->orderBy('id','DESC')->limit(3)->get();

        return view('frontend.property.property_details',compact('property','multiImage','ameneties','facilities','relatedProperty'));
    }

    public function PropertyMessage(Request $request){

        if (Auth::check()) {
            PropertyMessage::insert([
                'user_id' => Auth::user()->id,
                'agent_id' => $request->agent_id,
                'property_id' => $request->property_id,
                'msg_name' => $request->msg_name,
                'msg_email' => $request->msg_email,
                'msg_phone' => $request->msg_phone,
                'message' => $request->message,
                'created_at' => Carbon::now(),
            ]);
    
            $notification = array(
                'message' => 'Message Sent Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->back()->with($notification); 

        } else {
            $notification = array(
                'message' => 'Please Login Your Account First',
                'alert-type' => 'error'
            );
    
            return redirect()->back()->with($notification); 
        }
        
        
    }

    public function AgentDetails($id){

        $agent = User::findOrFail($id);

        $property = Property::where('agent_id',$id)->get();

        $featured = Property::where('featured','1')->limit(3)->get();

        $rentproperty = Property::where('status','1')->where('property_status','rent')->get();

        $buyproperty = Property::where('status','1')->where('property_status','buy')->get();

        return view('Frontend.agent.agent_details',compact('agent','property','featured','rentproperty','buyproperty'));
    }

    public function AgentMessage(Request $request){
        if (Auth::check()) {
            PropertyMessage::insert([
                'user_id' => Auth::user()->id,
                'agent_id' => $request->agent_id,
                'msg_name' => $request->msg_name,
                'msg_email' => $request->msg_email,
                'msg_phone' => $request->msg_phone,
                'message' => $request->message,
                'created_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Message Sent Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->back()->with($notification); 
            
        } else {

            $notification = array(
                'message' => 'Please Login Your Account First',
                'alert-type' => 'error'
            );
    
            return redirect()->back()->with($notification); 
        }
    }

    public function RentProperty(){
        $property = Property::where('status','1')->where('property_status','rent')->paginate(3);
        return view('Frontend.property.rent_property',compact('property'));
    }

    public function BuyProperty(){
        $property = Property::where('status','1')->where('property_status','buy')->get();

        return view('Frontend.property.buy_property',compact('property'));
    }

    public function PropertyType($id){

        $property = Property::where('ptype_id',$id)->where('status','1')->get();

        $ptype = PropertyType::where('id',$id)->first();

        return view('Frontend.property.property_type',compact('property','ptype'));
    }

    public function StateDetails($id){
        $property = Property::where('status','1')->where('state',$id)->get();
        $state = State::where('id',$id)->first();

        return view('Frontend.property.state_property',compact('property','state'));
    }

    public function BuyPropertySearch(Request $request){
        $request->validate(['search' => 'required']);
        $search = $request->search;
        $state = $request->state;
        $type = $request->ptype_id;

        $property = Property::where('property_status','buy')->where('property_name','like','%'.$search.'%')
        ->with('type','pstate')->whereHas('type',function($q) use ($type){
            $q->where('type_name','like','%'.$type.'%');
        })->whereHas('pstate',function($q) use ($state){
            $q->where('state_name','like','%'.$state.'%');
        })->get();

        return view('Frontend.property.property_search',compact('property'));
        
    }

    public function RentPropertySearch(Request $request){
        $request->validate(['search' => 'required']);
        $search = $request->search;
        $state = $request->state;
        $type = $request->ptype_id;

        $property = Property::where('property_status','rent')->where('property_name','like','%'.$search.'%')
        ->with('type','pstate')->whereHas('type',function($q) use ($type){
            $q->where('type_name','like','%'.$type.'%');
        })->whereHas('pstate',function($q) use ($state){
            $q->where('state_name','like','%'.$state.'%');
        })->get();

        return view('Frontend.property.property_search',compact('property'));
        
    }

    public function AllPropertySearch(Request $request){

        $property_status = $request->property_status;
        $state = $request->state;
        $type = $request->ptype_id;
        $bedrooms = $request->bedrooms;
        $bathrooms = $request->bathrooms;

        $property = Property::where('property_status', $property_status)->where('status', '1')
        ->where('bedrooms', $bedrooms)->where('bathrooms', $bathrooms)
        ->with('type','pstate')->whereHas('type',function($q) use ($type){
            $q->where('type_name','like','%'.$type.'%');
        })->whereHas('pstate',function($q) use ($state){
            $q->where('state_name','like','%'.$state.'%');
        })->get();

        return view('Frontend.property.property_search',compact('property'));
        
    }

    public function BlogDetails($post_slug){
        $posts = BlogPost::where('post_slug',$post_slug)->first();

        $blogCategory = BlogCategory::latest()->get();

        $tag = $posts->post_tags;
        $tags = explode(',',$tag);

        $recent_posts = BlogPost::latest()->get();

        return view('Frontend.blog.blog_details',compact('posts','blogCategory','tags','recent_posts'));
    }

    public function BlogCategoryList($id){
        $blog = BlogPost::where('blogcat_id',$id)->get();
        $category = BlogCategory::where('id',$id)->first();
        $recent_posts = BlogPost::latest()->get();
        $blogCategory = BlogCategory::latest()->get();


        return view('Frontend.blog.blog_cat_list',compact('blog','category','recent_posts','blogCategory'));
    }

    public function BlogList(){
        $blog = BlogPost::get();
        $recent_posts = BlogPost::latest()->get();
        $blogCategory = BlogCategory::latest()->get();

        return view('Frontend.blog.blog_list',compact('blog','recent_posts','blogCategory'));
    }
}
