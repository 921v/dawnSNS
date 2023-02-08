@extends('layouts.login')

@section('content')
<!-- ログインユーザーのプロフィール表示 -->
{{ Form::open(['url' => '/profileEdit','files'=>true])}}
<div class='my-profile'>
  <div class="profile-icon">
    <img src="images/dawn.png" alt="ユーザーアイコン" class="user-icon">
  </div>

  <div class='profile-text'>
    {{ Form::label('username','Username') }}
  </div>
  <div class="profile-form">
    {{ Form::textarea('username',$auths->username,['required', 'class'=>'profile-username', 'rows'=>'1'])}}</li>
  </div>
    @if($errors->has('username'))
    <div class="error">
      <p>{{ $errors->first('username') }}</p>
    </div>
    @endif

  <div class="profile-text">
    {{ Form::label('mail','MailAdress')}}
  </div>
  <div class="profile-form">
    {{ Form::textarea('mail',$auths->mail,['required', 'class'=>'profile-mail-address', 'rows'=>'1']) }}
  </div>
    @if($errors->has('mail'))
    <div class="error">
      <p>{{ $errors->first('mail') }}</p>
    </div>
    @endif

  <div class="profile-text">
    {{ Form::label('password','Password') }}
  </div>
  <div class="profile-form">
    {{ Form::textarea('password','password',$auths->nothashpassword,['disabled', 'class' =>'profile-password', 'rows'=>'1']) }}
  </div>

  <div class="profile-text">
    {{ Form::label('newpassword','Newpassword') }}
  </div>
  <div class="profile-form">
    {{ Form::textarea('password','newpassword' ,null, ['class' => 'profile-new-password', 'rows'=>'1']) }}
  </div>
    @if($errors->has('newpassword'))
    <div class="error">
      <p>{{ $errors->first('newpassword') }}</p>
    </div>
    @endif

  <div class="profile-text">
    {{ Form::label('bio','Bio')}}
  </div>
  <div class="profile-form">
    {{ Form::textarea('bio',$auths->bio,['class'=>'bio', 'rows'=>'3']) }}
  </div>
    @if($errors->has('bio'))
    <div class="error">
      <p>{{ $errors->first('bio') }}</p>
    </div>
    @endif

  <div class="profile-text">
    {{ Form::label('images','Icon Image') }}
  </div>
  <div class="profile-form">
    {{ Form::file('images',null,['class'=>'icon']) }}
  </div>

  @if($errors->has('images'))
  <div class="error">
    <p>{{ $errors->first('images') }}</p>
  </div>
  @endif

  <div class="profile-form">
    {{ Form::submit('更新',['class'=>'up_btn']) }}
  </div>
</div>

{{ Form::close()}}
@endsection
