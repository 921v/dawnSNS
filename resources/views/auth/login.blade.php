@extends('layouts.logout')

@section('content')
<div id = 'login'>
{!! Form::open() !!}

<h2>DAWNSNSへようこそ</h2>

<div class=”form-group”>
{{ Form::label('MailAdress') }}
{{ Form::text('mail',null,['class' => 'input']) }}
</div>

<div class=”form-group”>
{{ Form::label('password') }}
{{ Form::password('password',['class' => 'input']) }}
</div>

{{ Form::submit('LOGIN',['class' => 'login-btn']) }}

<p><a href="/register">新規ユーザーの方はこちら</a></p>

{!! Form::close() !!}
</div>

@endsection
