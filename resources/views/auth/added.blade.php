@extends('layouts.logout')

@section('content')

<div id="clear">
<p class ="usename">{{ $user_name }}さん、</p>
<p class ="welcome">ようこそ！DAWNSNSへ</p>
<p class ="done">ユーザー登録が完了しました。</p>
<p class ="done">さっそく、ログインをしてみましょう。</p>

<button class="added-btn" onclick="location.href='/login'">ログイン画面へ</<button>


@endsection
</div>
