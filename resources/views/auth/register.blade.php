@extends('layouts.logout')

@section('content')

{!! Form::open() !!}

<h2>新規ユーザー登録</h2>

<div class=”form-group”>
{{ Form::label('UserName') }}
{{ Form::text('username',null,['class' => 'input']) }}
</div>

<div class=”form-group”>
{{ Form::label('MailAdress') }}
{{ Form::text('mail',null,['class' => 'input']) }}
</div>

<div class=”form-group”>
{{ Form::label('Password') }}
{{ Form::text('password',null,['class' => 'input']) }}
</div>

<div class=”form-group”>
{{ Form::label('Password confirm') }}
{{ Form::text('password-confirm',null,['class' => 'input']) }}
</div>

{{ Form::submit('REGISTER') }}

@if ($errors->any())
  <div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
  </div>
@endif

<p><a href="/login">ログイン画面へ戻る</a></p>

{!! Form::close() !!}

@endsection
