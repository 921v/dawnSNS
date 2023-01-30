@extends('layouts.login')

@section('content')
<!--  ユーザ名検索  -->
<div class="search-form">
  @if(isset($searchWord))
    <p class="search-word">{{ $searchWord }}</p>
  @endif
  {!! Form::open(['url' => '/search', 'method' => 'post', 'class' => 'search-form-open']) !!}
  {!! Form::textarea('text', null, ['required', 'placeholder' => 'ユーザー名', 'class'=>'search-form-area', 'rows'=>'1' ]) !!}
    <button type="submit" class="search-btn"><img class="search-btn-image" src="images/post.png" alt="検索"></button>
  {!! Form::close() !!}
</div>

<!-- 検索結果一覧を表示 -->
<div class="search-result">
  @foreach($searchResults as $searchResult)
    <div class="search-user">
      <a href="/profile/{{ $searchResult -> id}}">
        <img src="images/{{ $searchResult -> images}}" class="user-icon" alt="ユーザーアイコン" >
      </a>
      <p class="search-username">{{ $searchResult -> username}}</p>
    </div>

    <!-- フォロー・解除ボタン -->
    <div class="btn-area">
      @if($auths->isFollowing($auths->id, $searchResult->id))
      {!! Form::open(['url' => '/search', 'method' => 'post', 'class' => 'search-unfollow']) !!}
        <button type="submit" class="un follow-btn" value="{{ $searchResult -> id}}" name="unfollow">フォローをはずす</button>
      {!! Form::close() !!}
      @else
      {!! Form::open(['url' => '/search', 'method' => 'post', 'class' => 'search-follow']) !!}
        <button type="submit" class="follow-btn" value="{{ $searchResult -> id}}" name="follow">フォローする</button>
      {!! Form::close() !!}
      @endif
    </div>
  @endforeach
</div>
@endsection
