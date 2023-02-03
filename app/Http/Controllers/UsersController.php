<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Follow;
use App\Post;
use App\User;

class UsersController extends Controller
{
    //
    public function profile($id){
        $auths = Auth::user();
        $user_profiles = User::where('id',$id)->get();

        return view('users.profile',['auths'=>$auths , 'user_profiles'=>$user_profiles]);

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

}
