@extends('layouts.login')

@section('content')
<!-- 自分のプロフィール -->
@if($auths->id ===  $user_profiles->id)
<div class="my-profile-contents">
  <img class="user-icon" src="images/dawn.png" alt="ユーザーアイコン">
  {!! Form::open(['url' => '/profile' , 'method' => 'post' ,'enctype'=>'multipart/form-data' , 'class' => 'my-profile-form']) !!}
  <div class="username">
    <p class="profile-text">UserName</p>
    {!! Form::textarea('username', $user_profile -> username, ['required','class' => 'my-profile-username']) !!}
  </div>

  <div class="mail-address">
    <p class="profile-text">MailAdress</p>
    {!! Form::textarea('mail', $user_profile -> mail, ['required','class' => 'my-profile-mail-address']) !!}
  </div>

  <div class="old-password">
    <p class="profile-text">Password</p>
    {!! Form::textarea('password','old-password', $user_profile -> nothashpassword, ['disabled','class' => 'my-profile-old-password']) !!}
  </div>

  <div class="new-password">
    <p class="profile-text">new Passwprd</p>
    {!! Form::textarea('password','new-password', null, ['null','class' => 'my-profile-new-password']) !!}
  </div>

  <div class="bio-profile">
    <p class="profile-text">Bio</p>
    {!! Form::textarea('bio', $user_profile -> bio, ['null','class' => 'my-profile-bio','size'=>50,'maxlength'=>10]) !!}
  </div>

  <div class="icon-upload">
    <p class="profile-text">Icon Image</p>
    {!! Form::file('image-file', null, ['class' => 'my-profile-images']) !!}
  </div>

  {!! Form::submit('更新',['class'=>'my-profile-button']) !!}
</div>
@else

<!-- 他ユーザーのプロフィール -->
<div class="user-profile-contents">
  <img class="user-icon" src="{{ asset('images/'. $user_profile -> images) }}" alt="ユーザーアイコン">
  <div class=user-profile-name>
    <p class=user-profile-name-text>Name</p>
    <p class="user-profile-username">{{ $user_profile -> username}}</p>
  </div>

  <div class="user-bio-profile">
    <p class="user-bio-profile-text">Bio</p>
    <p class="profile-user-bio">{{ $user_profile -> bio}}</p>
  </div>

  <!-- フォロー・解除ボタン -->
  @if($auths->isFollowing($auths->id , $user_profile->id))
    {!! Form::open(['url' => '/search', 'method' => 'get', 'class' => 'search-unfollow p-follow']) !!}
      <button type="submit" class="un follow-btn" value="{{ $user_profile -> id}}" name="unfollow">フォローをはずす</button>
    {!! Form::close() !!}
  @else
    {!! Form::open(['url' => '/search','method' => 'get', 'class' => 'search-follow p-follow']) !!}
      <button type="submit" class="follow-btn" value="{{ $user_profile -> id}}" name="follow">フォローする</button>
    {!! Form::close() !!}
  @endif
</div>

<!-- 投稿一覧 -->
<div class="user-profile-timelines">
  <div class="user-post">
    <img class="user-icon" src="{{ asset('images/'. $user_profile -> images) }}" alt="ユーザーアイコン">
    <p class="post-username">{{ $user_profile -> username}}</p>
    <p class="post-time">{{ $user_profile -> created_at }}</p>
    <p class="post-text">{{ $user_profile -> posts }}</p>
  </div>
</div>
@endif

@endsection
