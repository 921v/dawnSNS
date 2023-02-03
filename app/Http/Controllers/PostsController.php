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

        elseif($request->filled('trashId'))
        {
            $post_id = $request->input('trashId');

            Post::where('id',$post_id)->delete();

            return redirect('/top');
        }}

        return view('posts.index' , [ 'auths' => $auths , 'timeLines' => $timeLines]);
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
}
