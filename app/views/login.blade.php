<!DOCTYPE html>
<html lang="ZH">
<head>
  <meta charset="utf-8">
  <title>新声-登陆</title>
  <meta name="description" content="新声-听障儿童语言训练辅助工具">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  {{ HTML::style('css/normalize.css') }}
  {{ HTML::style('css/main.css') }}
</head>

<body>
  <main>
    <div class="login-wrapper">
    <div class="intro">
    </div>
    <div class="login-panel">
      {{ Form::open(array('url' => 'login')) }}
      <!-- if there are login errors, show them here -->
      <p class="feedback-block error">
        {{ $errors->first('username') }}
        {{ $errors->first('password') }}
      </p>

      <div class="form-row">
        {{ Form::label('username', '用户名') }}
        {{ Form::text('username', Input::old('username'), array('class'=>'login-input')) }}
      </div>

      <div class="form-row">
        {{ Form::label('password', '密&nbsp;&nbsp;&nbsp;码') }}
        {{ Form::password('password', array('class'=>'login-input')) }}
      </div>

      <div class="form-row">
        {{ Form::submit('登陆', array('class'=>'login-btn')) }}
      </div>
      {{ Form::close() }}
    </div>
    </div>
  </main>
</body>
</html>
