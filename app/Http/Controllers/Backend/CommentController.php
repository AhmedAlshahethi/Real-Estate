<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function StoreComment(Request $request){
        $post_id = $request->post_id;
        Comment::insert([
            'user_id' => Auth::user()->id,
            'post_id' => $post_id,
            'parent_id' => null,
            'subject' => $request->subject,
            'message' => $request->message,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Comment Created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function AllBlogComment(){
        $comments = Comment::where('parent_id',null)->get();

        return view('Backend.comment.all_comments', compact('comments'));
    }

    public function AdminCommentReply($id){
        $comment = Comment::where('id',$id)->first();

        return view('Backend.comment.reply_comment', compact('comment'));

    }

    public function AdminMessageReply(Request $request){
        $id = $request->id;
        $user_id = $request->user_id;
        $post_id = $request->post_id;

        Comment::insert([
            'user_id' => $user_id,
            'post_id' => $post_id,
            'parent_id' => $id,
            'subject' => $request->subject,
            'message' => $request->message,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Comment Reply Created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.blog.comment')->with($notification);
    }
}
