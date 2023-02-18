<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\User;
use App\Post;
use App\Follow;

class UsersController extends Controller
{
    //他ユーザーのプロフィール
    public function userProfile($id){
        $auths = Auth::user();
        $users = DB::table('users')
            ->where('id', $id)
            ->select('username', 'bio', 'images', 'id')
            ->first();
        $timeLines = DB::table('posts')
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->where('posts.user_id', $id)
            ->select('users.username', 'posts.posts', 'users.images', 'posts.created_at', 'posts.id',)
            ->orderBy('posts.created_at', 'desc')
            ->get();
        $followings = DB::table('follows')
            ->where('follower', Auth::id())
            ->get();
        $followlist = DB::table('follows')
            ->where('follower', Auth::id())
            ->count();
        $followerlist = DB::table('follows')
            ->where('follow', Auth::id())
            ->count();

        return view('users.userProfile', ['timeLines' => $timeLines, 'auths' => $auths, 'followlist' => $followlist, 'followerlist' => $followerlist, 'followings' => $followings, 'users' => $users]);
    }

    //検索
    public function search(Request $request){
        $auths = Auth::user();
        $id = Auth::id();
        $users = DB::table('users')
        ->where('id', $id)
        ->select('username', 'bio', 'images', 'id')
        ->first();
        $isfollowing = DB::table('follows')
        ->where('follower', Auth::id())
        ->get();
        $searchWord = $request->input('searchWord');

    if($request->filled('searchWord'))
        {
            $searchResults = User::where('username','LIKE',"%$searchWord%")->whereNotIn('id', [$id])->get();
        }

        $searchResults = User::whereNotIn('id', [$id])->get();
        return view('users.search' , [ 'auths' => $auths , 'searchResults' => $searchResults , 'searchWord' => $searchWord,'users' => $users]);
    }

    //フォローする
    public function follow($id){
        $isfollowing = $follower->isfollowing($users->id);
        $followId = $request->input('follow');
        Follow::create([
            'follow' => $followId,
            'follower' => $id,
        ]);
        return back();
    }

    //フォロー解除
    public function unfollow($id){
        $isfollowing = $follower->isfollowing($users->id);
        $unfollowId = $request->input('unfollow');
        Follow::where('follow',$unfollowId)
            ->where('follower',$id)
            ->delete();
        return back();
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

}
