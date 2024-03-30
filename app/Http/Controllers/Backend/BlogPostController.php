<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;

class BlogPostController extends Controller
{
    public function AllBlogPost(){
        $posts = BlogPost::latest()->get();

        return view("Backend.post.all_post", compact("posts"));
    }

    public function AddBlogPost(){
        $blogcat = BlogCategory::latest()->get();

        return view("Backend.post.add_post", compact("blogcat"));
    }

    public function StoreBlogPost(Request $request){

        $manager = new ImageManager(new Driver());
        $file = $request->file("post_image");
        $filename = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
        $manager->read($file)->resize(370,250)->save(base_path('public/upload/posts/'.$filename));
        $save_url = 'upload/posts/'.$filename;



        BlogPost::insert([
            'blogcat_id' => $request->blogcat_id,
            'user_id' => Auth::user()->id,
            'post_title' => $request->post_title,
            'post_slug' => strtolower(str_replace(' ','-', $request->post_title)),
            'post_image' => $save_url,
            'short_descp' => $request->short_descp,
            'long_descp' => $request->long_descp,
            'post_tags' => $request->post_tags,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Post created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.blog.posts')->with($notification);

    }

    public function EditBlogPost($id){
        $blogpost = BlogPost::findOrFail($id);
        $blogcat = BlogCategory::latest()->get();

        return view ('Backend.post.edit_post', compact('blogpost','blogcat'));
    }

    public function UpdateBlogPost(Request $request){
        $blogpost_id = $request->id;
        $post = BlogPost::findOrFail($blogpost_id);
        $old_image = $post->post_image;

        if ($request->file('post_image')) {

            $manager = new ImageManager(new Driver());
            $file = $request->file("post_image");
            $filename = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
            $manager->read($file)->resize(370,250)->save(base_path('public/upload/posts/'.$filename));
            $save_url = 'upload/posts/'.$filename;

            BlogPost::findOrFail($blogpost_id)->update([

                'blogcat_id' => $request->blogcat_id,
                'user_id' => Auth::user()->id,
                'post_title' => $request->post_title,
                'post_slug' => strtolower(str_replace(' ','-', $request->post_title)),
                'post_image' => $save_url,
                'short_descp' => $request->short_descp,
                'long_descp' => $request->long_descp,
                'post_tags' => $request->post_tags,
                'updated_at' => Carbon::now(),
            ]);

            if(file_exists($old_image)){
                unlink($old_image);
            }

            $notification = array(
                'message' => 'Post updated Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->route('all.blog.posts')->with($notification);

        } else {
            
            BlogPost::findOrFail($blogpost_id)->update([

                'blogcat_id' => $request->blogcat_id,
                'user_id' => Auth::user()->id,
                'post_title' => $request->post_title,
                'post_slug' => strtolower(str_replace(' ','-', $request->post_title)),
                'short_descp' => $request->short_descp,
                'long_descp' => $request->long_descp,
                'post_tags' => $request->post_tags,
                'updated_at' => Carbon::now(),
            ]);
    
            $notification = array(
                'message' => 'Post updated without image Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->route('all.blog.posts')->with($notification);
        }
         
    }
    
    public function DeleteBlogPost($id){
        
        $blogpost = BlogPost::findOrFail($id);
        $image = $blogpost->post_image;
        unlink($image);

        BlogPost::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Post deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
