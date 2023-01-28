@extends('layouts.login')

@section('content')
<!--  フォロー中ユーザーのリスト -->
<div class="follow-list">
  <p>Follow list</p>
  <div class="follow-images">
  @foreach ($follow_id_lists as $follow_id_list)
      <a href="/profile/{{ $follow_id_list -> id}}">
        <img src="images/{{ $follow_id_list -> images}}" class="user-icon" alt="フォローリストアイコン">
      </a>
  @endforeach
  </div>
</div>

<!--  フォロー中ユーザーのタイムライン -->
<div id="followTimeLines">
  @foreach ($timeLines as $timeLine)
  <div id="followListPost" class="user-post">
    <a href="/profile/{{ $timeLine -> user -> id}}">
      <img src="images/{{ $timeLine -> user -> images}}" class="user-icon" alt="フォローユーザーアイコン">
    </a>
    <p class="post-username">{{ $timeLine -> user -> username}}</p>
    <p class="post-time">{{ $timeLine -> created_at }}</p>
    <p class="post-text">{{ $timeLine -> posts }}</p>
  </div>
  @endforeach
</div>

@endsection
