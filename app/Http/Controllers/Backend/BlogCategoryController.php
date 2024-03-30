<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BlogCategoryController extends Controller
{
    public function AllBlogCategory(){
        $categories = BlogCategory::latest()->get();

        return view("Backend.category.blog_category", compact("categories"));
    }

    public function StoreBlogCategory(Request $request){
        BlogCategory::insert([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ','-',$request->category_name)),
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'BlogCategory Created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.blog.Categories')->with($notification);
    }

    public function EditBlogCategory($id){

        $categories = BlogCategory::findOrFail($id);
        return response()->json($categories);

    }// End Method 

    public function UpdateBlogCategory(Request $request){
        $category_id = $request->cat_id;

        BlogCategory::findOrFail($category_id)->update([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ','-',$request->category_name)),
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'BlogCategory updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.blog.Categories')->with($notification);
    }

    public function DeleteBlogCategory($id){
        BlogCategory::findOrFail($id)->delete();

        $notification = array(
            'message' => 'BlogCategory deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
