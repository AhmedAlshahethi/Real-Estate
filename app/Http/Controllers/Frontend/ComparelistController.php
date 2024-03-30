<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Comparelist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComparelistController extends Controller
{
    public function AddToComparelist(Request $request,$property_id){
        if (Auth::check()) {

            $exists = Comparelist::where('user_id',Auth::id())->where('property_id',$property_id)->first();

            if (!$exists) {

                Comparelist::insert([
                    'user_id'=>Auth::id(),
                    'property_id' => $property_id,
                    'created_at' => Carbon::now(),
                ]);

                return response()->json(['success' => 'Added on Your Comparelist Successfullly']);

            } else {

                return response()->json(['error' => 'This property has Already in Your Comparelist']);
            }
            
        } else {

            return response()->json(['error' => 'You have to login Your Account first']);
        }
        
    } //End Method 

    public function UserComparelist(){

        return view('Frontend.dashboard.comparelist');
    } 

    public function GetComparelistProperty(){

        $comparelist = Comparelist::with('property')->where('user_id',Auth::id())->latest()->get();

        return response()->json($comparelist);
    }

    public function ComparelistRemove($id){
        Comparelist::where('user_id',Auth::id())->where('id',$id)->delete();
        return response()->json(['success' => 'Successfully Property Remove']);
    }
}
