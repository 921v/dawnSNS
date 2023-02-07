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
        // login user情報取得
        $auths = Auth::user();

        // TimeLine
        $id = Auth::id();
        $follow_ids = Follow::where('follower',$id)->pluck('follow')->toArray();
        $follow_ids[] = $id;
        $timeLines = $post->getTimelines($follow_ids) ;

        // 投稿create
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

        elseif($request->filled('editPost'))
        {
            $post_id = $request->input('id');
            $user_editPost = $request->input('editPost');

            Post::where('id',$post_id)->update(['posts' => $user_editPost]);

            return redirect('/top');
        }

        elseif($request->filled('deletePost'))
        {
            $post_id = $request->input('deletePost');

            Post::where('id',$post_id)->delete();

            return redirect('/top');
        }
      }

        return view('posts.index' , [ 'auths' => $auths , 'timeLines' => $timeLines]);

    }

    public function edit(Request $request){
        $post_id = $request->input('id');
        $user_editPost = $request->input('editPost');
        DB::table('posts')
            ->where('id',$id)
            ->update(
                ['posts' => $user_editPost]
            );

        return redirect('/top');
    }

    public function delete($id){
        DB::table('posts')
            ->where('id',$id)
            ->delete();

        return redirect('/top');
    }


    public function profile(Request $request){
        $auths = Auth::user();
        $id = Auth::id();

        $user_profiles = User::where('id',$id)->get();

    // バリデーション内容
    $validateRules = [
        'username' => 'required|min:4|max:12',
        'mail' => 'required|min:4|max:12|unique:users,mail,'.$id.'',
        'new-password' => 'nullable|numeric|digits_between:4,12|unique:users,password',
        'bio' => 'max:200',
        'image-file' => 'image',
    ];

    $validateMessages = [
        "required" => "入力必須",
        "username.min" => "ユーザーネームは4文字以上から",
        "mail.min" => "メールアドレスは4文字以上から",
        "password.min" => "パスワードは4文字以上から",
        "username.max" => "ユーザーネームは12文字以内",
        "mail.max" => "メールアドレスは12文字以内",
        "password.max" => "パスワードは12文字以内",
        "digits_between" => "4字以上12字以内",
        "unique" => "既に存在します",
        "image" => "jpg,png,bmp,gif,svgの拡張子のみ有効です"
    ];

        // 更新処理
        if($request->filled('username'))
        {
            $auth_id = User::find($id);
            $all_form = $request->all();
            $val = Validator::make
            (
            $all_form,
            $validateRules,
            $validateMessages
            );

            // image file名を作成&保存
            $form_image = $request->file('image-file');
            if(isset($form_image))
            {
                $form_image_getName = $request->file('image-file')->getClientOriginalName();
                $request->file('image-file')->storeAs('images',$form_image_getName, 'public');
            } else {
                $form_image_getName=$auths->id.".png";
            }

            // バリデーション処理
            if($val->fails())
            {
               return back()->withErrors($val)->WithInput();
            }

            // 更新
            if(is_null($all_form['new-password']))
            {
            $auth_id
            ->fill([
                'username'=>$all_form['username'],
                'mail'=>$all_form['mail'],
                'password'=>bcrypt($all_form['new-password']),
                'bio'=>$all_form['bio'],
                'images'=>$form_image_getName,])
            ->save();
            } else
            {
            $auth_id
            ->fill([
                'username'=>$all_form['username'],
                'mail'=>$all_form['mail'],
                'password'=>bcrypt($all_form['new-password']),
                'bio'=>$all_form['bio'],
                'images'=>$form_image_getName,
                'nothashpassword'=>$all_form['new-password']])
            ->save();
            }

        return view('users.profile',['auths'=>$auths , 'user_profiles'=>$user_profiles]);
        }

        return view('users.profile',['auths'=>$auths ,'user_profiles'=>$user_profiles]);
    }


}
