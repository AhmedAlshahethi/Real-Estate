<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Amenities;
use App\Models\Facility;
use App\Models\MultiImage;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\State;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;

class AgentPropertyController extends Controller
{
    public function AgentAllProperty(){
        $id = Auth::user()->id;
        $property = Property::where('agent_id',$id)->latest()->get();   

        return view('agent.property.all_property',compact('property'));
    } // End Method

    public function AgentAddProperty(){

        $id = Auth::user()->id;
        $property = User::where('id',$id)->first();
        $pcount = $property->credit;
       
        $propertytype = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();

        $state = State::latest()->get();

        if ($pcount == 1 || $pcount == 7) {
            return redirect()->route('buy.package');
        } else {
            return view('agent.property.add_property',compact('propertytype','amenities','state'));
        }

        

    } // End Method

    public function AgentStoreProperty(Request $request){

        $id = Auth::user()->id;
        $user_id = User::findOrFail($id);
        $credit = $user_id->credit; 

        $amenitiy = $request->amenities_id;
        $amenties = implode(',',$amenitiy);

        $pcode = IdGenerator::generate(['table' => 'properties','field' => 'property_code','length' => 5, 'prefix' => 'PC']);

        $manager = new ImageManager(new Driver());
        $file = $request->file('property_thambnail');
        $filename = hexdec(uniqid()) .'.'. $file->getClientOriginalExtension();
        $manager->read($file)->resize(370,250)->save(base_path('public/upload/property/thambnail/'.$filename));
        $save_url = 'upload/property/thambnail/'.$filename;
            
        

        $property_id = Property::insertGetId([
            'ptype_id' => $request->ptype_id,
            'amenities_id' => $amenties,
            'property_name' => $request->property_name,
            'property_slug' => strtolower(str_replace(' ','-',$request->ptype_id)),
            'property_code' => $pcode,
            'property_status' => $request->property_status,
            'lowest_price' => $request->lowest_price,
            'max_price' => $request->max_price,
            'short_descp' => $request->short_descp,
            'long_descp' => $request->long_descp,
            'bedrooms' => $request->bedrooms,
            'bathrooms' => $request->bathrooms,
            'garage' => $request->garage,
            'garage_size' => $request->garage_size,
            'property_size' => $request->property_size,
            'property_video' => $request->property_video,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->ptype_id,
            'neighborhood' => $request->neighborhood,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'featured' => $request->featured,
            'hot' => $request->hot,
            'agent_id' => Auth::user()->id,
            'status' => 1,
            'property_thambnail' => $save_url,
            'created_at' => Carbon::now(),
        ]);

        $multi_images = $request->file('multi_img');

        foreach ($multi_images as $img) {
            $filename = hexdec(uniqid()) .'.'. $img->getClientOriginalExtension();
            $manager->read($file)->resize(770,520)->save(base_path('public/upload/property/multi-image/'.$filename));
            $uploadPath = 'upload/property/multi-image/'.$filename;

            MultiImage::insert([
                'property_id' => $property_id,
                'photo_name' => $uploadPath,
                'created_at' => Carbon::now(),
            ]);
        } //End Foreach

        $facilities = count($request->facility_name);

        if ($facilities != null) {
            for ($i=0; $i < $facilities; $i++) { 
                $fcount = new Facility();
                $fcount->property_id = $property_id;
                $fcount->facility_name = $request->facility_name[$i];
                $fcount->distance = $request->distance[$i];
                $fcount->save();
            }
        } // End If

        User::where('id', $id)->update([
            'credit' => DB::raw('1 + '.$credit),
        ]);

        $notification = array(
            'message' => 'Property created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('agent.all.property')->with($notification);
        
    } // End Method

    public function AgentEditProperty($id){
        $property = Property::findOrFail($id);  
        $propertytype = PropertyType::latest()->get();

        $amenities_id = $property->amenities_id;
        $amenities_type = explode(',', $amenities_id);
        $amenities = Amenities::latest()->get();

        $multiImage = MultiImage::where('property_id', $id)->get();

        $facilites = Facility::where('property_id', $id)->get();

        $state = State::latest()->get();

        return view('agent.property.edit_property',compact('property','propertytype','amenities', 'amenities_type',
        'multiImage', 'facilites', 'state'));

    } // End Method

    public function AgentUpdateProperty(Request $request){
        $ame = $request->amenities_id;
        $amenties = implode(',', $ame);

        Property::findOrFail($request->id)->update([
            'ptype_id' => $request->ptype_id,
            'amenities_id' => $amenties,
            'property_name' => $request->property_name,
            'property_slug' => strtolower(str_replace(' ','-',$request->ptype_id)),
            'property_status' => $request->property_status,
            'lowest_price' => $request->lowest_price,
            'max_price' => $request->max_price,
            'short_descp' => $request->short_descp,
            'long_descp' => $request->long_descp,
            'bedrooms' => $request->bedrooms,
            'bathrooms' => $request->bathrooms,
            'garage' => $request->garage,
            'garage_size' => $request->garage_size,
            'property_size' => $request->property_size,
            'property_video' => $request->property_video,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->ptype_id,
            'neighborhood' => $request->neighborhood,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'featured' => $request->featured,
            'hot' => $request->hot,
            'agent_id' => Auth::user()->id,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Property updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('agent.all.property')->with($notification);

    } // End Method

    public function AgentUpdatePropertyThambnail(Request $request){

        $property_id = $request->id;
        $old_image = $request->old_img;

        $manager = new ImageManager(new Driver());
        $file = $request->file('property_thambnail');
        $filename = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
        $manager->read($file)->resize(370,250)->save(base_path('public/upload/property/thambnail/'.$filename));
        $save_url = 'upload/property/thambnail/'.$filename;
        
        if (file_exists($old_image)) {
            unlink($old_image);
        }

        Property::findOrFail($property_id)->update([
            'property_thambnail' => $save_url,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Property Image Thambnail updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
               
    } // End Method

    public function AgentUpdatePropertyMultiimage(Request $request){
        $multi_image = $request->multi_img;

        foreach ($multi_image as $id => $img) {
            $imgDel = MultiImage::findOrfail($id);
            unlink($imgDel->photo_name);
            $manager = new ImageManager(new Driver());
            $filename = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
            $manager->read($img)->resize(370,250)->save(base_path('public/upload/property/multi-image/'.$filename));
            $save_url = 'upload/property/multi-image/'.$filename;

            MultiImage::where('id', $id)->update([
                'photo_name' => $save_url,
                'updated_at' => Carbon::now(),
            ]);
        }

        $notification = array(
            'message' => 'Property Multi Image updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // End Method

    public function AgentDeletePropertyMultiimage($id){
        $old_img = MultiImage::findOrFail($id);
        unlink($old_img->photo_name);

        MultiImage::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Property Multi Image deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // End Method

    public function AgentStorePropertyMultiimage(Request $request){
        $property_id = $request->multiImgId;

        $manager = new ImageManager(new Driver());
        $file = $request->file('multi_img');
        $filename = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
        $manager->read($file)->resize(370,250)->save(base_path('public/upload/property/multi-image/'.$filename));
        $save_url = 'upload/property/multi-image/'.$filename;

        MultiImage::insert([
            'property_id' => $property_id,
            'photo_name' => $save_url,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Property Multi Image Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // End Method

    public function AgentUpdatePropertyFacility(Request $request){
        $property_id = $request->id;

        if ($request->facility_name == null) {
            return redirect()->back();
        } else {
            Facility::where('property_id',$property_id)->delete();

            $facilities = Count($request->facility_name);
            if ($facilities != null) {
                for ($i=0; $i < $facilities; $i++) { 
                    $fcount = new Facility();
                    $fcount->property_id = $property_id;
                    $fcount->facility_name = $request->facility_name[$i];
                    $fcount->distance = $request->distance[$i];
                    $fcount->updated_at = Carbon::now();
                    $fcount->save();    
            } // End For
          }
        }  // End If
        
        $notification = array(
            'message' => 'Property facility updated Successfully',
            'alert-type' => 'success'
          );
    
          return redirect()->back()->with($notification);
          
    } // End Method

    public function AgentDetailsProperty($id){

        $property = Property::findOrFail($id);

        $ame = $property->amenities_id;
        $amenities_type = explode(',', $ame);

        $amenities = Amenities::latest()->get();

        return view('agent.property.details_property',compact('property','amenities','amenities_type'));

    } // End Method

    public function AgentDeleteProperty($id){

        $property = Property::findOrFail($id);
        Property::findOrFail($id)->delete();
        unlink($property->property_thambnail);

        $images = MultiImage::where('property_id', $id)->get();

        foreach ($images as $img) {
            unlink($img->photo_name);
            MultiImage::where('property_id', $id)->delete();   
        }

        Facility::where('property_id',$id)->delete();

        $notification = array(
            'message' => 'Property deleted Successfully',
            'alert-type' => 'success'
          );
    
          return redirect()->back()->with($notification);

    } // End Method
}
