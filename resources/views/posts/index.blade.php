@extends('layouts.login')

@section('content')
<!-- 4.1 投稿フォームの設置 -->
<div class="container">
    <form class="post-form" method="POST" action="{{ route('top.store') }}">
      {{ csrf_field() }}

      <div class="form-group">
        <div class="form-group-image">
          <img src="images/dawn.png" class="form-icon" alt="ユーザーアイコン">
        </div>
        <div class="form-group-text">
          <textarea class="form-control" name="post" style="border:none" rows="4" required placeholder="何をつぶやこうか…?"></textarea>
        </div>
        <div class="form-send-icon">
          <button type="submit"><img src="images/post.png" alt="投稿"></button>
        </div>
      </div>
    </form>

<!-- 4.2.1 ユーザーのつぶやきを表示 -->
@foreach ($timelines as $timeline)
  <div class="tweets-top">
    <div class="timelines">
      <div class="user-post">
        <div class="post-image">
          <img src="images/dawn.png" class="form-icon" alt="ユーザーアイコン">
        </div>
        <div class="timelines">
          <p class="post-username">{{ $timeline->user->username }}</p>
          <p class="post-text">{{ $timeline->posts }}</p>
        </div>
        <div class="post-time">
          <p>{{ $timeline->created_at }}</p>
        </div>
      </div>

    <!-- 4.2.2 ログインユーザーのつぶやきを表示 -->
    @if ($timeline->id === Auth::user()->id)
      <div class="user-post">
        <div class="edit">
          <input type="image" src="/images/edit.png" alt="編集">
           <!-- モーダルの設定 -->
        </div>
        <div class="delete">
          <a class="btn btn-danger" href="/post/{{ $post->id }}/delete" img src="/images/trash.png" alt="削除" onclick="return confirm('削除しますか？')">削除</a>
        </div>
      </div>
    @endif
  </div>
</div>
@endforeach
@endsection
