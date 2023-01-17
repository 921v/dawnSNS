@extends('layouts.login')

@section('content')
<!-- 4.1 投稿フォームの設置 -->
<div class="container">
  <div class="form-group">
    <form method="POST" action="{{ route('top.store') }}">
      {{ csrf_field() }}

      <div class="form-group-image">
        <img src="images/dawn.png" class="form-icon" alt="ユーザーアイコン">
      </div>
      <div class="form-group-text">
        <textarea class="form-control" name="posts" style="border:none;" required rows="4" placeholder="何をつぶやこうか...?"></textarea>
      </div>
      <div class="form-send-icon">
        <button type="submit"><img src="images/post.png" alt="投稿"></button>
      </div>
    </form>
</div>


  <!-- 4.2.1 ユーザーのつぶやきを表示 -->
  @foreach ($timelines as $timeline)
  <div class="posts-top">
    <div class="timelines">
      <div class="user-post">
        <div class="post-image">
          <img  src="images/dawn.png" class="form-icon" alt="ユーザーアイコン">
        </div>
        <div class="post-content">
          <p class="post-username">{{ $timeline->user->username }}</p>
          <p class="post-time">{{ $timeline->created_at }}</p>
          <p class="post-text">{{ $timeline->posts }}</p>
    <!-- 4.2.2 ログインユーザーのボタン表示 -->
            @if ($post->id === Auth::user()->id)
            <div class="post-button">
              <div class="edit">
                <button type="button" class="modal-open edit-btn" data-toggle="modal" data-target="#editModal" data-id="{{ $timeline->id }}" data-posts="{{ $timeline->posts }}"><img src="storage/edit.png" alt="編集"></button>
              </div>
              <div class="delete">
                <a class="delete-btn" href="/post/{{ $timeline->id }}/delete" onclick="return confirm('このつぶやきを削除します。よろしいですか？')"><img src="storage/trash_h.png" alt="削除"></a>
              </div>
            </div>
            @endif
        </div>
      </div>
  </div>
</div>
  @endforeach
@endsection
