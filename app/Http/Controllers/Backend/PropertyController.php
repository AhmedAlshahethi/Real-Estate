<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\MultiImage;
use App\Models\Facility;
use App\Models\Amenities;
use App\Models\PropertyType;
use App\Models\State;
use App\Models\User;
use Carbon\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class PropertyController extends Controller
{
    public function AllProperty(){

        $property = Property::latest()->with('type')->get();
        return view('backend.property.all_property',compact('property'));

    } // End Method 



    public function AddProperty(){

        $propertytype = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();
        $activeAgent = User::where('status','active')->where('role','agent')->latest()->get();
        $state = State::latest()->get();
        return view('backend.property.add_property',compact('propertytype','amenities','activeAgent','state'));

    }// End Method 

    public function StoreProperty(Request $request){

        $manager = new ImageManager(new Driver());
        $image = $request->file('property_thambnail');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        $manager->read($image)->resize(370,250)->save(base_path('public/upload/property/thambnail/'.$name_gen));
        $save_url = 'upload/property/thambnail/'.$name_gen;
        

        $amen = $request->amenities_id;
        $amenties = implode(",",$amen);
        // dd($amenties);

        $pcode = IdGenerator::generate(['table' => 'properties','field' => 'property_code','length' => 5, 'prefix' => 'PC' ]);;

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
            'agent_id' => $request->agent_id,
            'status' => 1,
            'property_thambnail' => $save_url,
            'created_at' => Carbon::now(),

        ]);// End Method 

        //Multiple Image upload 

        $mult_images = $request->file('multi_img');

        foreach ($mult_images as $img) {
            $make_name = hexdec(uniqid()).'.'. $img->getClientOriginalExtension();
            $manager->read($img)->resize(770,520)->save(base_path('public/upload/property/multi-image/'.$make_name));
            $uploadPath = 'upload/property/multi-image/'.$make_name;

            MultiImage::insert([
                'property_id' => $property_id,
                'photo_name' => $uploadPath,
                'created_at' => Carbon::now(),
            ]);

        }// End Foreach
        
        //End Multiple Image upload 

        $facilities = Count($request->facility_name);
        if ($facilities != Null){
            for($i=0; $i< $facilities; $i++){
                $fcount = new Facility();
                $fcount->property_id = $property_id;
                $fcount->facility_name = $request->facility_name[$i];
                $fcount->distance = $request->distance[$i];
                $fcount->save();
             }     
        }

        $notification = array(
            'message' => 'Property created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.property')->with($notification);

    } // End Method 

    public function EditProperty($id){
        $property = Property::findOrFail($id);

        $amenities_id = $property->amenities_id;
        $amenities_type = explode(',', $amenities_id);

        $propertytype = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();
        $activeAgent = User::where('status','active')->where('role','agent')->latest()->get();
        $multiImage = MultiImage::where('property_id', $id)->get();
        $facilites = Facility::where('property_id', $id)->get();
        $state = State::latest()->get();

        return view('backend.property.edit_property',compact('property','propertytype','amenities',
        'activeAgent','amenities_type', 'multiImage', 'facilites','state'));

    } // End Method 

    public function UpdateProperty(Request $request){
        $property_id = $request->id;

        $amen = $request->amenities_id;
        $amenties = implode(",",$amen);
        
        Property::findOrFail($property_id)->update([
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
            'agent_id' => $request->agent_id,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Property updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.property')->with($notification);
    } // End Method


    public function UpdatePropertyThambnail(Request $request){
        $property_id = $request->id;
        $old_img = $request->old_img;

        $manager = new ImageManager(new Driver());
        $image = $request->file('property_thambnail');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        $manager->read($image)->resize(370,250)->save(base_path('public/upload/property/thambnail/'.$name_gen));
        $save_url = 'upload/property/thambnail/'.$name_gen;

        if (file_exists($old_img)){
            unlink($old_img);
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

    public function UpdatePropertyMultiimage(Request $request){
        $imgs = $request->multi_img;
        
        foreach ($imgs as $id => $img) {
            $imgDel = MultiImage::findOrFail($id);
            unlink($imgDel->photo_name);

            $manager = new ImageManager(new Driver());
            $make_name = hexdec(uniqid()).'.'. $img->getClientOriginalExtension();
            $manager->read($img)->resize(770,520)->save(base_path('public/upload/property/multi-image/'.$make_name));
            $uploadPath = 'upload/property/multi-image/'.$make_name;

            MultiImage::where('id', $id)->update([
                'photo_name' => $uploadPath,
                'updated_at' => Carbon::now(),
            ]);

        } // End Foreach

        $notification = array(
            'message' => 'Property Multi Image updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // End Method

    public function DeletePropertyMultiimage($id){
        $oldImg = MultiImage::findOrFail($id);
        unlink($oldImg->photo_name);

        MultiImage::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Property Multi Image deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // End Method

    public function StoreNewMultiimage(Request $request){
        $multiImgId = $request->multiImgId;
        $newImg = $request->file('multi_img');
        $manager = new ImageManager(new Driver());
        $make_name = hexdec(uniqid()).'.'.$newImg->getClientOriginalExtension();
        $manager->read($newImg)->resize(770,520)->save(base_path('public/upload/property/multi-image/'. $make_name));
        $uploadPath = 'upload/property/multi-image/'. $make_name;

        MultiImage::insert([
            'property_id' => $multiImgId,
            'photo_name' => $uploadPath,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Property Multi Image Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // End Method

    public function UpdatePropertyFacility(Request $request){
        $pid = $request->id;

        if ($request->facility_name == null) {
            return redirect()->back();
        }else{

            Facility::where('property_id',$pid)->delete();

            $facilities = Count($request->facility_name);
            if ($facilities != Null){
            for($i=0; $i< $facilities; $i++){
                $fcount = new Facility();
                $fcount->property_id = $pid;
                $fcount->facility_name = $request->facility_name[$i];
                $fcount->distance = $request->distance[$i];
                $fcount->save();
             } // End for   
        } 
      } // End if

      $notification = array(
        'message' => 'Property facility updated Successfully',
        'alert-type' => 'success'
      );

      return redirect()->back()->with($notification);

    } // End Method

    public function DeleteProperty($id){
        $property = Property::findOrFail($id);
        unlink($property->property_thambnail);

        $property::findOrFail($id)->delete();

        $image = MultiImage::where('property_id',$id)->get();

        foreach ($image as $img) {
            unlink($img->photo_name);
            MultiImage::where('property_id',$id)->delete();
        }

        Facility::where('property_id',$id)->delete();

        $notification = array(
            'message' => 'Property deleted Successfully',
            'alert-type' => 'success'
          );
    
          return redirect()->back()->with($notification);

        
    } // End Method

    public function DetailsProperty($id){
        $property = Property::findOrFail($id);

        $amenities_id = $property->amenities_id;
        $amenities_type = explode(',', $amenities_id);

        $propertytype = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();
        $activeAgent = User::where('status','active')->where('role','agent')->latest()->get();
        $multiImage = MultiImage::where('property_id', $id)->get();
        $facilites = Facility::where('property_id', $id)->get();

        return view('backend.property.details_property',compact('property','propertytype','amenities',
        'activeAgent','amenities_type', 'multiImage', 'facilites'));

    } // End Method 

    public function InactiveProperty(Request $request){
        $pid = $request->id;
        Property::findOrFail($pid)->update([
            'status' => 0,
        ]);

        $notification = array(
            'message' => 'Property InActive Successfully',
            'alert-type' => 'success'
          );
    
          return redirect()->route('all.property')->with($notification);

    } // End Method 

    public function ActiveProperty(Request $request){
        $pid = $request->id;
        Property::findOrFail($pid)->update([
            'status' => 1,
        ]);

        $notification = array(
            'message' => 'Property Active Successfully',
            'alert-type' => 'success'
          );
    
          return redirect()->route('all.property')->with($notification);
          
    } // End Method 





} 