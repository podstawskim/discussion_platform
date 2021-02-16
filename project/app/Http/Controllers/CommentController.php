<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function replyStore(Request $request)
    {
        $request->validate([
            "text" => "required"
        ]);

        $reply = new Comment();
        $reply->text = $request->get('text');
        $reply->parent_id = $request->get('comment_id');
        $user = Auth::user();
        $reply->user_id = $user->id;
        $post = Post::find($request->get('post_id'));
        $post->comments()->save($reply);

        // return back();
        // return redirect()->to(app('url')->previous() . "#comment_" . $reply->id . "_content");
        return redirect()->to('/posts/' . $post->id . "#comment_" . $reply->id);
    }
}
