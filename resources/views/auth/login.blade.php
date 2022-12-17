@extends('layouts.logout')

@section('content')

{!! Form::open() !!}

<p>DAWNSNSへようこそ</p>

{{ Form::label('MailAdress') }}
{{ Form::text('mail',null,['class' => 'input']) }}
{{ Form::label('password') }}
{{ Form::password('password',['class' => 'input']) }}

{{ Form::submit('LOGIN') }}

<p><a href="/register">新規ユーザーの方はこちら</a></p>

{!! Form::close() !!}

@endsection
