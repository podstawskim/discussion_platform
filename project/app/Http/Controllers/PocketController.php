<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PocketController extends Controller
{
    public function index()
    {
        $money = Auth::user()->pocket_money;
        return view('pocket.index')->withMoney($money);
    }

    public function boostPocket(Request $request)
    {
        if($request->boost>0){
        $this->validate($request, [
            'boost' => 'integer|max:1000'
        ]);
        Auth::user()->pocket_money += $request->get('boost');
        Auth::user()->save();
    }
        return redirect()->back();
    }
}
