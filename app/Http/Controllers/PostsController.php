<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Post;
use App\Follow;

class PostsController extends Controller
{
    //デフォルト
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(User $user, Follow $follow, Post $post){
        $user = auth()->user();
        $id = Auth::id();
        $follow_count = $follow->getFollowCount($user->id);
        $follower_count = $follow->getFollowerCount($user->id);
        $follow_ids = Follow::where('follower',$id)->pluck('follow')->toArray();
        $follow_ids[] = $id;
        $timeLines = $post->getTimelines($user->id,$follow_ids) ;

        return view('posts.index', [
            'user' => $user,
            'follow_count' => $follow_count,
            'follower_count' => $follower_count,
            'timeLines' => $timeLines
        ]);
    }

    // 投稿登録
    public function store(Request $request){
        $request->validate(
            [
                'newPost' => ['required','max:150'],
            ],
            [
                'newPost.required' => '必須項目です',
                'newPost.max' => '150文字以内で入力してください',
            ]
            );

        $id = Auth::id();
        $post = $request->input('newPost');
        DB::table('posts')->insert([
            'user_id' => $id,
            'posts' => $post
        ]);

        return redirect('/top');
    }

    // 投稿の編集
    public function update(Request $request){
        $request->validate(
            [
                'editPost' => ['required','max:200'],
            ]
            );

        $id = $request->input('id');
        $edit_post = $request->input('editPost');
        DB::table('posts')
            ->where('id',$id)
            ->update(
                ['posts' => $edit_post]
            );

        return redirect('/top');
    }

    // 投稿の削除
    public function delete($id){
        DB::table('posts')
            ->where('id',$id)
            ->delete();

        return redirect('/top');
    }

    // 自分のプロフィール編集
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
