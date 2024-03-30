<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wishlist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function AddToWishlist(Request $request,$property_id){
        if (Auth::check()) {

            $exists = Wishlist::where('user_id',Auth::id())->where('property_id',$property_id)->first();

            if (!$exists) {

                Wishlist::insert([
                    'user_id'=>Auth::id(),
                    'property_id' => $property_id,
                    'created_at' => Carbon::now(),
                ]);

                return response()->json(['success' => 'Added on Your Wishlist Successfullly']);

            } else {

                return response()->json(['error' => 'This property has Already in Your Wishlist']);
            }
            
        } else {

            return response()->json(['error' => 'You have to login Your Account first']);
        }
        
    } //End Method 

    public function UserWishlist(){
        $id = Auth::user()->id;
        $user_data = User::find($id);

        return view('Frontend.dashboard.wishlist.wishlist',compact('user_data'));
    } 


    public function GetWishlistProperty(){

        $wishlist = Wishlist::with('property')->where('user_id',Auth::id())->latest()->get();

        $wishQty = wishlist::count();

        return response()->json(['wishlist' => $wishlist, 'wishQty' => $wishQty]);
    }

    public function WishlistRemove($id){
        Wishlist::where('user_id',Auth::id())->where('id',$id)->delete();
        return response()->json(['success' => 'Successfully Property Remove']);
    }
}
