@extends('layouts.login')

@section('content')
<div class='other_profile_top'>
  <div id="profile-icon">
    <img src="{{ asset('/storage/images/'.$user->images) }}" alt="ユーザーアイコン" class="user-icon">
  </div>

  <div class="other_profile">
    <ul>
      <li class='profile-text'>Name</li>
      <li>{{$user->username}}</li>
    </ul>
  </div>

  <div class="other_profile">
    <ul>
      <li class='profile-text'>Bio</li>
      <li>{{$user->bio}}</li>
    </ul>
  </div>
 </div>

  @if($followings->contains('follow',$user->id))
  <form action="/unfollow" method="post">
    @csrf
    <input type="hidden" value="{{ $user->id }}" name="unfollow">
    <input type="submit" value="フォローをはずす" class="unf_btn">
  </form>
  @else
  <form action="/follow" method="post">
    @csrf
    <input type="hidden" value="{{ $user->id }}" name="follow">
    <input type="submit" value="フォローする" class="f_btn">
  </form>
  @endif
</div>

@foreach($timeLines as $timeLine)
<div class="timeline">
  <img src="{{ asset('/storage/images/'.$post->images) }}" alt="ユーザーアイコン" class="user-icon">
  <p class="post-username">{{ $timeLine -> user -> username}}</p>
  <p class="post-time">{{ $timeLine -> created_at }}</p>
  <p class="post-text">{{ $timeLine -> posts }}</p>
</div>
@endforeach
@endsection
