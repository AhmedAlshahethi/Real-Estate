<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Testimonials;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;

class TestimonialController extends Controller
{
    public function AllTestimonials(){
        $testimonials = Testimonials::latest()->get();

        return view("Backend.testimonial.all_testimonials", compact("testimonials"));
    }

    public function AddTestimonial(){
        return view("Backend.testimonial.add_testimonial");
    }

    public function StoreTestimonial(Request $request){

        $manager = new ImageManager(new Driver());
        $image = $request->file('image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        $manager->read($image)->resize(100,100)->save(base_path('public/upload/testimonial/'.$name_gen));
        $save_url = 'upload/testimonial/'.$name_gen;

        Testimonials::insert([
            'name' => $request->name,
            'position' => $request->position,
            'message' => $request->message,
            'image' => $save_url,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Testimonial created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.testimonials')->with($notification);
    }

    public function EditTestimonial($id){
        $testimonial = Testimonials::find($id);

        return view("Backend.testimonial.edit_testimonial",compact("testimonial"));
    }

    public function UpdateTestimonial(Request $request){
        $testimonial_id = $request->id;

        if ($request->file('image')) {

        $manager = new ImageManager(new Driver());
        $image = $request->file('image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        $manager->read($image)->resize(100,100)->save(base_path('public/upload/testimonial/'.$name_gen));
        $save_url = 'upload/testimonial/'.$name_gen;

        Testimonials::findOrFail($testimonial_id)->update([
            'name' => $request->name,
            'position' => $request->position,
            'message' => $request->message,
            'image' => $save_url,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Testimonial updated with Image Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.testimonials')->with($notification);

        } else {

            Testimonials::findOrFail($testimonial_id)->update([
                'name' => $request->name,
                'position' => $request->position,
                'message' => $request->message,
                'updated_at' => Carbon::now(),
            ]);
    
            $notification = array(
                'message' => 'Testimonial updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.testimonials')->with($notification);
        }
        
    }

    public function DeleteTestimonial($id){
        $testimonial = Testimonials::findOrFail($id);
        unlink($testimonial->image);
        Testimonials::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Testimonial deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
