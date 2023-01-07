<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Post;
use App\Follow;

class PostsController extends Controller
{
    //
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
}
