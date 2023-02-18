@extends('layouts.login')

@section('content')
<!-- ログインユーザーのプロフィール表示 -->
{{ Form::open(['url' => '/profileEdit','files'=>true])}}
<div class='my-profile'>
  <div class="myprofile-icon">
    <img src="images/dawn.png" alt="ユーザーアイコン" class="my-icon">
  </div>

  <table class="profile-table">
    <tr>
      <div class='profile-text'>
        <th>{{ Form::label('username','Username') }}</th>
      </div>
      <div class="profile-form">
        <td>{{ Form::textarea('username',$auths->username,['required', 'class'=>'profile-username', 'rows'=>'1'])}}</td>
      </div>
    </tr>
    @if($errors->has('username'))
    <div class="error">
      <p>{{ $errors->first('username') }}</p>
    </div>
    @endif

  <tr>
    <div class="profile-text">
      <th>{{ Form::label('mail','MailAdress')}}</th>
    </div>
    <div class="profile-form">
      <td>{{ Form::textarea('mail',$auths->mail,['required', 'class'=>'profile-mail-address', 'rows'=>'1']) }}</td>
    </div>
  </tr>
    @if($errors->has('mail'))
    <div class="error">
      <p>{{ $errors->first('mail') }}</p>
    </div>
    @endif

  <tr>
    <div class="profile-text">
      <th>{{ Form::label('password','Password') }}</th>
    </div>
    <div class="profile-form">
      <td>{{ Form::textarea('password',$auths->password,['disabled', 'class' =>'profile-password', 'rows'=>'1', 'style' => '-webkit-text-security:disc']) }}</td>
    </div>
  </tr>

  <tr>
    <div class="profile-text">
      <th>{{ Form::label('newpassword','Newpassword') }}</th>
    </div>
    <div class="profile-form">
      <td>{{ Form::textarea('password',null, ['class' => 'profile-new-password', 'rows'=>'1', 'style' => '-webkit-text-security:disc']) }}</td>
    </div>
  </tr>
    @if($errors->has('newpassword'))
    <div class="error">
      <p>{{ $errors->first('newpassword') }}</p>
    </div>
    @endif

  <tr>
    <div class="profile-text">
      <th>{{ Form::label('bio','Bio')}}</th>
    </div>
    <div class="profile-form">
      <td>{{ Form::textarea('bio',$auths->bio,['class'=>'bio', 'rows'=>'3']) }}</td>
    </div>
  </tr>
    @if($errors->has('bio'))
    <div class="error">
      <p>{{ $errors->first('bio') }}</p>
    </div>
    @endif

  <tr>
    <div class="profile-text">
      <th>{{ Form::label('images','Icon Image') }}</th>
    </div>
    <div class="profile-form">
      <td>{{ Form::textarea('images',null,['class'=>'profile-image', 'placeholder' => 'ファイルを選択']) }}</td>
    </div>
  </tr>
    @if($errors->has('images'))
    <div class="error">
      <p>{{ $errors->first('images') }}</p>
    </div>
    @endif
  </table>
</div>

<div class="profile-form">
  {{ Form::submit('更新',['class'=>'up_btn']) }}
</div>

{{ Form::close()}}
@endsection
