<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getTimelines(Int $user_id, Array $follow_ids)
    {
        $follow_ids[] = $user_id;
        return $this->whereIn('user_id',$follow_ids)->orderBy('created_at','DESC')->paginate(50);
    }

    protected $fillable = [
        'user_id', 'posts'
    ];
}
