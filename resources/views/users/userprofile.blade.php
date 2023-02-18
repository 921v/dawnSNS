@extends('layouts.login')

@section('content')
<div class='other_profile_top'>
  <div id="profile-icon">
    <img src="{{ asset('images/'. $users -> images) }}" alt="ユーザーアイコン" class="user-icon">
  </div>

  <div class="other_profile">
    <p class='profile-text'>Name</p>
    <p>{{$users->username}}</p>
  </div>

  <div class="other_profile">
    <p class='profile-text'>Bio</p>
    <p>{{$users->bio}}</p>
  </div>
 </div>

</div>

@foreach($timeLines as $timeLine)
<div class="timeline">
  <img src="{{ asset('images/'. $users -> images) }}" alt="ユーザーアイコン" class="user-icon">
  <p class="post-username">{{ $timeLine -> user -> username}}</p>
  <p class="post-time">{{ $timeLine -> created_at }}</p>
  <p class="post-text">{{ $timeLine -> posts }}</p>
</div>
@endforeach

@endsection
