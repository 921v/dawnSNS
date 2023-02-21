@extends('layouts.login')

@section('content')
<!--  フォロー中ユーザーのリスト -->
<div class="follow-list">
  <p>Follow list</p>
  <div class="follow-images">
  @foreach ($icons as $icon)
      <a href="/profile/{{ $icon -> id}}">
        <img src="images/{{ $icon -> images}}" class="user-icon" alt="フォローリストアイコン">
      </a>
  @endforeach
  </div>
</div>

<!--  フォロー中ユーザーのタイムライン -->
<div id="timeline">
  @foreach ($timeLines as $timeLine)
  <div class="user-post">
    <div class="post-info">
      <a href="/profile/{{ $icon -> id}}">
        <img class="user-post-icon" src="images/{{ $timeLine -> images}}" alt="ユーザーアイコン">
      </a>
      <p class="post-username">{{ $timeLine -> username}}</p>
      <p class="post-time">{{ $timeLine -> created_at }}</p>
    </div>
    <p class="post-text">{{ $timeLine -> posts }}</p>
  </div>
  @endforeach
</div>

@endsection
