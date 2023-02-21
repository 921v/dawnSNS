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
        $isfollowing = DB::table('follows')
            ->where('follower', Auth::id())
            ->get();
        $followlist = DB::table('follows')
            ->where('follower', Auth::id())
            ->count();
        $followerlist = DB::table('follows')
            ->where('follow', Auth::id())
            ->count();

        return view('users.userProfile', ['timeLines' => $timeLines, 'auths' => $auths, 'followlist' => $followlist, 'followerlist' => $followerlist, 'isfollowing' => $isfollowing, 'users' => $users]);
    }

    //検索
    public function search(Request $request){
        $auths = Auth::user();
        $users = User::all();
        $query = User::query();
        $isfollowing = DB::table('follows')
        ->where('follower', Auth::id())
        ->get();
        $followlist = DB::table('follows')
        ->where('follower', Auth::id())
        ->count();
        $followerlist = DB::table('follows')
            ->where('follow', Auth::id())
            ->count();
        $searchWord = $request->input('searchWord');

        if (!empty($searchWord)) {
            $query = User::query();
            $query->where('username', 'like', '%' . $searchWord . '%');
        }

        $users = $query->get();
        return view('users.search', ['auths' => $auths, 'users' => $users, 'isfollowing' => $isfollowing, 'followlist' => $followlist, 'followerlist' => $followerlist, 'searchWord' => $searchWord]);
    }
}
