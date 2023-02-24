@extends('layouts.login')

@section('content')
<div class='other-profile-top'>
  <div id="profile-icon">
    <img src="{{ asset('images/'. $users -> images) }}" alt="ユーザーアイコン" class="other user-icon">
  </div>

  <div class="other-profile">
    <p class='other-profile-text left-name'>Name</p>
    <p class='right-name'>{{$users->username}}</p>
  </div>

  <div class="other-profile">
    <p class='other-profile-text left-bio'>Bio</p>
    <p class='right-bio'>{{$users->bio}}</p>
  </div>

  <div class="other-btn-area">
    @if($users->id != $auths->id)
    @if($isfollowing->contains('follow',$users->id))
    <!-- 解除ボタン -->
    {!! Form::open(['url' => '/unfollow', 'method' => 'post', 'class' => 'search-unfollow']) !!}
      <button type="submit" class="un follow-btn" value="{{ $users -> id}}" name="unfollow">フォローをはずす</button>
    {!! Form::close() !!}
    <!-- フォローボタン -->
    @else
    {!! Form::open(['url' => '/follow', 'method' => 'post', 'class' => 'search-follow']) !!}
      <button type="submit" class="follow-btn" value="{{ $users -> id}}" name="follow">フォローする</button>
    {!! Form::close() !!}
    @endif
    @endif
  </div>
</div>

<div class="timeline">
  @foreach ($timeLines as $timeLine)
  <div class="user-post">
    <div class="post-info">
      <a href="/profile/{{ $timeLine -> id}}">
        <img class="user-post-icon other-icon" src="{{ asset('images/'. $users -> images) }}" alt="ユーザーアイコン">
      </a>
      <p class="post-username">{{ $timeLine -> username}}</p>
      <p class="post-time">{{ $timeLine -> created_at }}</p>
    </div>
    <p class="post-text">{{ $timeLine -> posts }}</p>
  </div>
  @endforeach
</div>

@endsection
