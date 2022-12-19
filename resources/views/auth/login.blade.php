@extends('layouts.logout')

@section('content')

{!! Form::open() !!}

<p>DAWNSNSへようこそ</p>

<div class=”form-group”>
{{ Form::label('MailAdress') }}
{{ Form::text('mail',null,['class' => 'input']) }}
</div>

<div class=”form-group”>
{{ Form::label('password') }}
{{ Form::password('password',['class' => 'input']) }}
</div>

{{ Form::submit('LOGIN') }}

<p><a href="/register">新規ユーザーの方はこちら</a></p>

{!! Form::close() !!}

@endsection
