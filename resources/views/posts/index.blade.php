@extends('layouts.login')

@section('content')
<!-- 4.1 投稿フォームの設置 -->
<div class="post-area">
  <div class="form-group">
    <img src="images/dawn.png" class="user-icon" alt="ユーザーアイコン">
    {!! Form::open(['url' => '/top' ,'method' => 'post', 'class' => 'form-class']) !!}
    <div class="form-group-text">
    {!! Form::textarea('newPost', null, ['required','class' => 'form-control', 'placeholder' => '何をつぶやこうか…？' ]) !!}
    </div>
    <button type="submit" class="form-send-icon"><img src="images/post.png" alt="投稿"></button>
    {!! Form::close() !!}
  </div>
</div>

<!-- 4.2 ユーザーのつぶやきを表示 -->
<div class="timeline">
  @if (isset($timeLines))
  @foreach ($timeLines as $timeLine)
  <div class="user-post">
    <a href="/profile/{{ $timeLine -> user_id}}">
      <img class="user-post-icon" src="images/{{ $timeLine -> user -> images}}" alt="ユーザーアイコン">
    </a>
    <p class="post-username">{{ $timeLine -> user -> username}}</p>
    <p class="post-time">{{ $timeLine -> created_at }}</p>
    <p class="post-text">{{ $timeLine -> posts }}</p>

    <!-- 4.3 ログインユーザーのボタン表示 -->
    @if ($auths->id == $timeLine->user_id)
      <!-- 4.3.1 削除ボタン表示 -->
      {!! Form::open(['url' => '/top','method' => 'post']) !!}
        <button class="delete-btn" name="deletePost" value="{{ $timeLine -> id }}" onclick="return confirm('このつぶやきを削除します。よろしいでしょうか？')">
          <img class="delete-icon" src="images/trash.png" alt="削除">
        </button>
      {!! Form::close()!!}
      <!-- 4.3.2 編集ボタン表示 -->
      <div class='modalopen' data-target="post-modal-{{ $timeLine -> id }}">
        <a class="edit-btn" href="" >
          <img src="images/edit.png" alt="編集">
        </a>
          <!-- 4.4 編集オーバーレイ表示 -->
            <div class="editmodal" id="post-modal-{{ $timeLine -> id }}">
              <div id="modal-contents">
                {!! Form::open(['url' => '/top','method' => 'post']) !!}
                {!! Form::hidden('id', $timeLine -> id) !!}
                {!! Form::textarea('editPost', $timeLine -> posts, ['required', 'class'=>'post-edit-contents'])!!}
                  <button class="post-edit-btn">
                    <img src="images/edit.png" alt="編集モーダル">
                  </button>
                {!! Form::close()!!}
              </div>
            </div>
        </div>
    @endif
  </div>
</div>
  @endforeach
  @endif

<script>
$(function () {
  $(".modalopen").each(function () {
    $(this).on('click', function () {
      var target = $(this).data('target');
      var editmodal = document.getElementById(target);
      console.log(editmodal);
      $(editmodal).fadeIn();
      return false;
    });
  });
  $(".post-edit-btn").on('click', function () {
    $('.modal-contents').fadeOut();
    return false;
  })
});
</script>

@endsection
