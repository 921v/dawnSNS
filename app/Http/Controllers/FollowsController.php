<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Post;
use App\Follow;

class FollowsController extends Controller
{
    //
    public function followList(User $user, Post $post){
        $auths = Auth::user();
        $id = Auth::id();
        $follow_id = DB::table('follows')
            ->where('follower',Auth::id())
            ->pluck('follow');
        $icons = DB::table('users')
            ->whereIn('id',$follow_id)
            ->select('images','id')
            ->get();
        $followlist = DB::table('follows')
            ->where('follower',Auth::id())
            ->count();
        $followerlist = DB::table('follows')
            ->where('follow',Auth::id())
            ->count();
        $timeLines = DB::table('posts')
            ->join('users','posts.user_id','=','users.id')
            ->whereIn('user_id',$follow_id)
            ->select('users.username','posts','users.images','posts.created_at as created_at')
            ->orderBy('posts.created_at','desc')
            ->get();

        return view('follows.followList',[ 'auths' => $auths , 'icons'=>$icons, 'followlist' => $followlist , 'followerlist'=>$followerlist, 'timeLines' => $timeLines]);
    }

    public function followerList(User $user, Post $post){
        $auths = Auth::user();
        $id = Auth::id();
        $follower_id = DB::table('follows')
            ->where('follow',Auth::id())
            ->pluck('follower');
        $icons = DB::table('users')
            ->whereIn('id',$follower_id)
            ->select('images','id')
            ->get();
        $followlist = DB::table('follows')
            ->where('follower',Auth::id())
            ->count();
        $followerlist = DB::table('follows')
            ->where('follow',Auth::id())
            ->count();
        $timeLines = DB::table('posts')
            ->join('users','posts.user_id','=','users.id')
            ->whereIn('user_id',$follower_id)
            ->select('users.username','posts','users.images','posts.created_at as created_at')
            ->orderBy('posts.created_at','desc')
            ->get();

        return view('follows.followerList' , [ 'auths' => $auths , 'icons'=>$icons, 'followlist' => $followlist ,'followerlist'=>$followerlist, 'timeLines' => $timeLines]);
    }

        //フォローする
    public function follow(Request $request){
        $follow = $request->input('follow');;
        DB::table('follows')
            ->insert([
                'follow' => $follow,
                'follower' => Auth::id(),
                'created_at' => now(),
            ]);
        return back();
    }

    //フォロー解除
    public function unfollow(Request $request){
        $unfollow = $request->input('unfollow');
        DB::table('follows')
            ->where('follower' , Auth::id())
            ->where('follow' , $unfollow)
            ->delete();
        return back();
    }

    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
}
