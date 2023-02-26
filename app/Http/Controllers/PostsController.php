<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Collection;
use Auth;
use App\User;
use App\Post;
use App\Follow;

class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Post $post,Request $request){
        $auths = Auth::user();
        $id = Auth::id();
        $follow_ids = Follow::where('follower',$id)->pluck('follow')->toArray();
        $follow_ids[] = $id;
        $timeLines = DB::table('posts')
            ->join('users','posts.user_id','=','users.id')
            ->select('posts.id','posts.posts','posts.user_id','posts.created_at','users.username','users.images')
            ->orderBy('posts.created_at','desc')
            ->get();

      // 投稿作成
      if($request->isMethod('post')){
        if ($request->filled('newPost'))
        {
            $user_post = $request->input('newPost');
            Post::create([
                'user_id' => $id,
                'posts' => $user_post,
            ]);
        return redirect('/top');
        }

      // 投稿削除
        elseif($request->filled('deletePost'))
        {
            $post_id = $request->input('deletePost');

            Post::where('id',$post_id)->delete();

            return redirect('/top');
        }
      }
        return view('posts.index' , [ 'auths' => $auths , 'timeLines' => $timeLines]);
    }

    public function update(Request $request){
        \DB::table('posts')
            ->where('id',$request->input('id'))
            ->update([
                'posts'=>$request->input('editPost')
            ]);
        return redirect('/top');
    }

    public function profile(Request $request){
        $auths = Auth::user();
        $followlist = DB::table('follows')
            ->where('follower', Auth::id())
            ->count();
        $followerlist = DB::table('follows')
            ->where('follow', Auth::id())
            ->count();

        return view('users.profile', ['auths' => $auths, 'followlist' => $followlist, 'followerlist' => $followerlist]);
    }

    public function profileEdit(Request $request){
        $request->validate([
            'username' => ['string', 'min:4', 'max:12'],
            'mail' => ['string', 'email', 'min:4', 'max:50'],
            'bio' => ['max:200'],
            'images' => ['file', 'mimes:jpg,png,bmp,gif,svg,jpeg,PNG']
        ],
        [
            'username.min' => '４文字以上で入力してください',
            'username.max' => '１２文字以内で入力してください',
            'mail.unique' => 'このメールアドレスは既に使われています',

            'bio.max' => '200文字以内で入力してください',
            'images.mimes' => 'jpg、pnj、bmp、gif、svg、jpeg、PNGの形式のファイルのみ有効です',
        ]);

        $username = $request->input('username');
        $auths = Auth::user();
        $auths->username = $request->input('username');

        if (request('newpassword')) {
            $request->validate([
                'newpassword' => ['required', 'string', 'alpha_num', 'min:4', 'max:12', 'unique:users']
            ], [
                'newpassword.required' => 'パスワードが未入力です',
                'newpassword.alpha_num' => '英数字で入力してください',
                'newpassword.min' => '４文字以上で入力してください',
                'newpassword.max12' => '１２文字以内で入力してください',
                'newpassword.unique' => 'このパスワードは既に使われています',
            ]);
            $auths->password = bcrypt($request->input('newpassword'));

        } else {
            $password = DB::table('users')
                ->where('id', Auth::id())
                ->value('password');

            $auths->password = $password;
        }

        $auths->mail = $request->input('mail');
        $auths->bio = $request->input('bio');
        $auths->save();
        $images = $request->file('images');

        if (isset($images)) {
            $imageName = $images->getClientOriginalName();
            $images->storeAs('public/images', $imageName);
            $auths->images = $imageName;
            $auths->save();
        } else {
            $images = DB::table('users')
                ->where('id', Auth::id())
                ->value('images');
            $auths->images = $images;
            $auths->save();
        }

        return redirect('/profile')->with('password', $auths['password']);
    }

}
