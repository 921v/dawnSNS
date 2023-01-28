<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use \Auth;

class User extends Authenticatable
{
    use Notifiable;

    public function followsCount()
    {
        $id = Auth::id();
        $follow_count = Follow::where('follow', $id)->count();
        return $follow_count;
    }

    public function followersCount()
    {
        $id = Auth::id();
        $follower_count = Follow::where('follower', $id)->count();
        return $follower_count;
    }

    public function post()
    {
        return $this->hasOne(Post::class, 'user_id', 'id');
    }

    // フォローする
    public function follow(Int $user_id)
    {
        return $this->follows()->attach($user_id);
    }

    // フォロー解除する
    public function unfollow(Int $user_id)
    {
        return $this->follows()->detach($user_id);
    }

    // followsテーブルへの登録と削除
    public function follows()
    {
        return $this->belongsToMany(Follow::class, 'follows', 'follow', 'follower');
    }

    // followsテーブルへの登録と削除
    public function followers()
    {
        return $this->belongsToMany(Follow::class, 'follows', 'follower', 'follow');
    }

    // フォローしているか
    public function isFollowing(Int $user_id)
    {
        return (boolean) Follow::where('follower',$user_id)->where('follow',$user_id)->first(['id']);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'mail', 'password', 'nothashpassword', 'bio', 'images',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $remember_token = false;

    protected $hidden = [
        'password', 'remember_token',
    ];
}
