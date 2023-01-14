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
          <input type="image" src="images/post.png"  alt="投稿">
        </div>
      </div>
    </form>

  <!-- 4.2 ログインユーザーのつぶやきを表示 -->
  <!-- 4.2.1 ログインユーザーのフォローのつぶやき表示を表示 -->
  @if (isset($timelines))
  @foreach ($timelines as $timeline)
  <div class="tweets-top">
    <div class="card">
      <div class="tweet-timelines">
        <div id="top-image2" class="top-image2">

          <p><img src="images/dawn.png" class="rounded-circle"></p>
        </div>
        <div class="timelines">
          <p class="tweets-top-username">{{ $timeline->user->username }}</p>
          <p class="tweets-top-text">{!! nl2br(e($timeline->posts)) !!}</p>
        </div>
        <div class="tweets-top-time">
          <p>{{ $timeline->created_at }}</p>
        </div>
      </div>


      @if ($timeline->id === Auth::user()->id)


      <div class="tweet-menu">





      </div>

      @endif

    </div>
  </div>
  @endforeach
  @endif
</div>
@endsection
