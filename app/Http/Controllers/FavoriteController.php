<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function postlist($id){
        
        $posts = DB::table('posts')->where('id', '$id')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $id = Auth::id();
        $profile = User::find($id);
        // 上の2行の処理はAuth::user();ですむ。
        // $profile = Auth::user();
        return view('mypage.profile', ['profile' => $profile]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function evaluationlist()
    {
        $user_id = Auth::id();
        // joinについて：Favorite::joinなので元となるテーブル（favoritesテーブル）に対してpostsテーブルとusersテーブルをjoinしている。joinと書いただけだとinner扱いになる。
        $favorites = Favorite::join('users', 'users.id', '=', 'favorites.user_id')
        ->join('posts', 'posts.id', '=', 'favorites.post_id')
        ->select('users.name', 'posts.title', 'favorites.user_id')
        ->where('favorites.user_id', $user_id)
        // ⬆️favoritesテーブルとpostsテーブルにuser_idがあるので'favorites.user_id'と書いてfavoritesテーブルのuser_idカラムで絞り込んだ。
        ->get();
        return view('mypage.evaluationlist', ['favorites' => $favorites]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        Favorite::create([
            'user_id' => Auth::id(),
            'post_id' => $request->post_id
        ]);
        return response()->json(['result' => true]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function show(Favorite $favorite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function edit(Favorite $favorite)
    {
        // $id = Auth::id();
        // $profile = users::find($id);
        $profile = Auth::user();
        return view('mypage.profileedit', ['profile' => $profile]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {
    
        Auth::user()->update([
            'name' => $request->name,
            'profile' => $request->profile
        ]);
        return redirect("/mypage/profile/");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request){
        Favorite::where('post_id', $request->post_id)->where('user_id', Auth::id())->delete();
        return response()->json(['result' => true]);
    }
}
