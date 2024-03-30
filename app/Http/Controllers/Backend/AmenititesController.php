<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Amenities;
use Illuminate\Http\Request;

class AmenititesController extends Controller
{
    //
    public function AllAmenitie(){

        $amenities = Amenities::latest()->get();
        return view('backend.amenities.all_amenities',compact('amenities'));

    } // End Method 

    public function AddAmenitie(){
        return view('backend.amenities.add_amenities');
    }// End Method 


     public function StoreAmenitie(Request $request){ 
        Amenities::insert([ 

            'amenitis_name' => $request->amenitis_name, 
        ]);

          $notification = array(
            'message' => 'Amenities Create Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.amenitie')->with($notification);

    }// End Method 


    public function EditAmenitie($id){

        $amenities = Amenities::findOrFail($id);
        return view('backend.amenities.edit_amenities',compact('amenities'));

    }// End Method 


    public function UpdateAmenitie(Request $request){ 

        $ame_id = $request->id;

        Amenities::findOrFail($ame_id)->update([ 

            'amenitis_name' => $request->amenitis_name, 
        ]);

          $notification = array(
            'message' => 'Amenities Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.amenitie')->with($notification);

    }// End Method 


    public function DeleteAmenitie($id){

        Amenities::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Amenities Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }// End Method 
}
