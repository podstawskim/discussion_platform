<?php


namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\Member;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['create', 'store', 'edit', 'update', 'destroy', 'boost']]);
    }

    public function index()
    {
        if (Auth::user()) {
            $posts = DB::table('members')
                     ->rightJoin('posts', 'posts.id','=','members.post_id')
                     ->where('isPublic', '=', TRUE)
                     ->orwhere('members.user_id', '=', Auth::user()->getAuthIdentifier())
                     ->orderBy('post_account_balance', 'desc')
                     ->get();
        } else $posts = DB::table('posts')
                        ->where('isPublic', '=', TRUE)
                        ->orderBy('post_account_balance', 'desc')
                        ->get();

        return view('posts.index')->withPosts($posts);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $post = new Post;
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $user = Auth::user();
        $this->validateArticle();
        $user->posts()->save($post);
        if (!isset($_POST['isPublic'])) {
            $post->isPublic = FALSE;
            $membersList = explode(",", preg_replace('/\s+/','',$request->input('users')));
            array_push($membersList, Auth::user()->email);
            foreach (array_unique(array_filter($membersList)) as $email) {
                if(DB::table('users')->where('email','=',$email)->exists()) {
                    $id = DB::table('users')
                        ->where('email', '=', $email)
                        ->first()->id;
                    $newMember = new Member;
                    $newMember->user_id = $id;
                    $post->members()->save($newMember);       // $newMember->post_id = $post->id;
                    $post->save();
                }
            }
        }
        return redirect()->route('posts.show', $post);
    }

    public function show(Post $post)
    {
        if ($post->isPublic) {
            return view('posts.show')->withPost($post)->with('current_user', Auth::user());
        }
        if (Auth::user() && DB::table('members')
                            ->where('post_id', '=', $post->id)
                            ->where('user_id','=',Auth::user()->getAuthIdentifier())
                            ->exists())
            return view('posts.show')->withPost($post)->with('current_user', Auth::user());
        else return redirect()->route('posts.index');
    }

    public function edit(Post $post)
    {
        return view('posts.edit')->withPost($post);
    }

    public function update(Post $post)
    {
        $post->update($this->validateArticle());
        return redirect()->route('posts.show', $post);
    }

    public function destroy(Post $post)
    {
        $post->comments()->delete();
        $post->delete();
        return redirect()->route('posts.index');
    }

    protected function validateArticle()
    {
        return request()->validate([
            'title' => 'required',
            'content' => 'required',
        ]);
    }

    public function boost(Post $post)
    {
        if (Auth::user()->id == $post->user->id) {
            return redirect()->back()->withErrors('You cannot boost your own post!');
        }
        if (Auth::user()->pocket_money - 5.0 < 0) {
            return redirect()->back()->withErrors('You do not have enough money to boost!');
        } else {
            $post->post_account_balance += 5.0;
            $post->save();
            Auth::user()->pocket_money -= 5.0;
            Auth::user()->save();
        }
        return redirect()->back();
    }
}
