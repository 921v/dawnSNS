@extends('layouts.login')

@section('content')
<!-- 4.1 投稿フォームの設置 -->
<div class="post-area">
  <div class="form-group">
    <img src="images/dawn.png" class="user-icon" alt="ユーザーアイコン">
    {!! Form::open(['url' => 'post' ,'method' => 'post', 'class' => 'form-class']) !!}
    <div class="form-group-text">
    {!! Form::textarea('newPost', null, ['required','class' => 'form-control', 'placeholder' => '何をつぶやこうか…？' ]) !!}
    </div>
    <button type="submit" class="form-send-icon"><img src="images/post.png" alt="投稿"></button>
    {!! Form::close() !!}
  </div>
</div>

<!-- 4.2 ユーザーのつぶやきを表示 -->
<div class="timeline">
  @foreach ($timelines as $timeline)
  <div class="user-post">
    @if(Auth::user()->id === $timeLine->user->id)
    <a href="/profile">
      <img class="user-icon" src="images/{{ $timeLine -> user -> images}}" alt="ユーザーアイコン">
    </a>
    @else
    <a href="/profile/{{ $timeLine -> user_id}}">
      <img class="user-icon" src="images/{{ $timeLine -> user -> images}}" alt="ユーザーアイコン">
    </a>
    @endif
      <p class="post-username">{{ $timeline->user->username }}</p>
      <p class="post-time">{{ $timeline->created_at }}</p>
      <p class="post-text">{{ $timeline->posts }}</p>

    <!-- 4.3 ログインユーザーのボタン表示 -->
    @if ($post->id === Auth::user()->id)
      {!! Form::open(['url' => '/top','method' => 'post']) !!}
      <!-- 4.3.1 削除ボタン表示 -->
        <button class="delete-btn" value="{{ $timeLine -> id }}" onclick="return confirm('このつぶやきを削除します。よろしいでしょうか？')">
          <img class="delete-icon" src="images/trash.png" alt="削除">
        </button>
      {!! Form::close()!!}
      <!-- 4.3.2 編集ボタン表示 -->
        <a class="edit-btn" href="" data-target="post-modal-{{ $timeLine -> id }}">
          <img src="images/edit.png" alt="編集">
        </a>
          <!-- 4.4 編集モーダル表示 -->
            <div class="edit-modal" id="post-modal-{{ $timeLine -> id }}">
              <div class="modal-contents">
                {!! Form::open(['url' => 'post/update','method' => 'post']) !!}
                {!! Form::hidden('id', $timeLine -> id) !!}
                {!! Form::textarea('editPost', $timeLine -> posts, ['required', 'class'=>'post-edit-contents'])!!}
                  <p class="contents-validator">編集画面が表示されると、選択された投稿内容が初期から入っているように<br>最大200文字までとする</p>
                    <button class="post-edit-btn">
                      <img src="images/edit.png" alt="編集モーダル">
                    </button>
                {!! Form::close()!!}
              </div>
            </div>
    @endif
  </div>
</div>
  @endforeach

@endsection
