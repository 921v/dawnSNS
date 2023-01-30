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
    public function index(User $user, Follow $follow, Post $post){
        $user = auth()->user();

        $follow_ids = $follow->followingIds($user->id);
        $following_ids = $follow_ids->pluck('follower')->toArray();

        $timelines = $post->getTimelines($user->id, $following_ids);

        $follow_count = $follow->getFollowCount($user->id);
        $follower_count = $follow->getFollowerCount($user->id);


        return view('posts.index', [
            'user'      => $user,
            'timelines' => $timelines,
            'follow_count'   => $follow_count,
            'follower_count' => $follower_count,
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
}
