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
    //
    public function userProfile($id){
        $auths = Auth::user();
        $user = DB::table('users')
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

        return view('users.userProfile', ['timeLines' => $timeLines, 'auths' => $auths, 'followlist' => $followlist, 'followerlist' => $followerlist, 'followings' => $followings, 'user' => $user]);
    }


    public function search(Request $request){
        $auths = Auth::user();
        $id = Auth::id();
        $user = auth()->user();

      if($request->isMethod('post')){
        if($request->filled('searchWord'))
        {
            $searchWord = $request->input('searchWord');
            $searchResults = User::where('username','LIKE',"%$searchWord%")->whereNotIn('id', [$id])->get();

            return view('users.search' , [ 'auths' => $auths , 'searchResults' => $searchResults , 'searchWord' => $searchWord]);
        }

        elseif($request->filled('follow'))
        {
            $follower = auth()->user();
            $isfollowing = $follower->isFollowing($user->id);
                if(!$isfollowing) {
                // フォローしていなければフォローする
                $follower->follow($user->id);

                return redirect('/search');
            }
        }

        elseif($request->filled('unfollow'))
        {
            $follower = auth()->user();
            $isFollowing = $follower->isFollowing($user->id);
                if ($isFollowing) {
                // フォローしていればフォローを解除する
                $follower->unfollow($user->id);

                return redirect('/search');
            }
        }
      }
        $searchResults = User::whereNotIn('id', [$id])->get();
        return view('users.search' , [ 'auths' => $auths , 'searchResults' => $searchResults]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

}
