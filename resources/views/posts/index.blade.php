@extends('layouts.login')

@section('content')
<!-- 4.1 投稿フォームの設置 -->
<div class="post-area">
  <div class="form-group">
    <img src="images/dawn.png" class="form-icon" alt="ユーザーアイコン">
    {!! Form::open(['url' => '/top' ,'method' => 'post', 'class' => 'form-class']) !!}
    <div class="form-group-text">
    {!! Form::input('text', 'newPost', null, ['required','class' => 'form-control', 'placeholder' => '何をつぶやこうか…？' ] )!!}
    </div>
    <button type="submit" class="form-send-icon"><img src="images/post.png" alt="投稿"></button>
    {!! Form::close() !!}
  </div>
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
