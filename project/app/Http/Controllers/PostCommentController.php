<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostCommentController extends Controller
{
    // POST COMMENT
    public function store(Post $post, Request $request)
    {
        $validatedData = $request->validate([
            "text" => "required"
        ]);
        $comment = new Comment;
        $comment->text = $request->text;
        $comment->parent_id = null;
        $user = Auth::user();
        $comment->user_id = $user->id;
        $post->comments()->save($comment);

        // return redirect()->to(app('url')->previous() . "#comment_" . $comment->id . "_content");
        return redirect()->to('/posts/' . $post->id . "#comment_" . $comment->id);
    }

    //GET TO PUT COMMENT
    public function edit(Post $post, Comment $comment)
    {
        if (Auth::user()->id == $comment->user->id) {
            return view('posts.show')->withPost($post)->with('edited_comment_id', $comment->id)->with('current_user', Auth::user());
        } else {
            return redirect()->back();
        }
    }
    //PUT COMMENT
    public function update(Post $post, Request $request, Comment $comment)
    {
        if (Auth::user()->id == $comment->user->id) {
            $validatedData = $request->validate([
                'text' => 'required',
            ]);
            //$comment = $post->comments()->findOrFail($comment->id);
            $comment = Comment::find($comment->id);
            $comment->update($validatedData);
            return redirect()->route('posts.show', [$post, $comment]);
        } else {
            return redirect()->back();
        }
    }

    //DELETE COMMENT
    public function destroy(Post $post, Comment $comment)
    {
        //$comment = $post->comments()->findOrFail($comment->id);
        $comment = Comment::find($comment->id);
        $comment->delete();
        return redirect()->route('posts.show', $post);
    }
}
