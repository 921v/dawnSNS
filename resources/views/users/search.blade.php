@extends('layouts.login')

@section('content')
<!--  ユーザ名検索  -->
<div class="search-form">
  {!! Form::open(['url' => '/search', 'method' => 'post', 'class' => 'search-form-open']) !!}
  {!! Form::textarea('searchWord', null, ['placeholder' => 'ユーザー名', 'class'=>'search-form-area', 'rows'=>'1' ]) !!}
    <button type="submit" class="search-btn"><img class="search-btn-image" src="images/post.png" alt="検索"></button>
  {!! Form::close() !!}
  @if(isset($searchWord))
    <p class="search-word">検索ワード：{{ $searchWord }}</p>
  @endif
</div>

<!-- 検索結果一覧を表示 -->
<div class="search-result">
  @foreach($users as $user)
    <div class="search-user">
      <a href="/profile/{{ $user -> id}}">
        <img src="images/{{ $user -> images}}" class="user-icon" alt="ユーザーアイコン" >
      </a>
      <p class="search-username">{{ $user -> username}}</p>
    </div>

    <!-- フォロー/解除ボタン -->
    <div class="btn-area">
      @if($user->id != $auths->id)
      @if($isfollowing->contains('follow',$user->id))
      <!-- 解除ボタン -->
      {!! Form::open(['url' => '/unfollow', 'method' => 'post', 'class' => 'search-unfollow']) !!}
        <button type="submit" class="un follow-btn" value="{{ $user -> id}}" name="unfollow">フォローをはずす</button>
      {!! Form::close() !!}
      <!-- フォローボタン -->
      @else
      {!! Form::open(['url' => '/follow', 'method' => 'post', 'class' => 'search-follow']) !!}
        <button type="submit" class="follow-btn" value="{{ $user -> id}}" name="follow">フォローする</button>
      {!! Form::close() !!}
      @endif
      @endif
    </div>
  @endforeach
</div>
@endsection
