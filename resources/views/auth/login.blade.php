@extends('layouts.app')

@section('content')

  <form class="pt-3" method="POST" action="{{ route('login') }}">
    {{ csrf_field() }}
    <div class="form-group">
      <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} form-control-lg" id="email" name="email" value="{{ old('email') }}" placeholder="E-mail" required autofocus>
      @if ($errors->has('email'))
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('email') }}</strong>
          </span>
      @endif
    </div>
    <div class="form-group">
      <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} form-control-lg" id="password" name="password" placeholder="Password" required>
      @if ($errors->has('password'))
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('password') }}</strong>
          </span>
      @endif
    </div>
    <div class="mt-3">
      <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SIGN IN</bottom>
    </div>
    <div class="my-2 d-flex justify-content-between align-items-center">
      <div class="form-check">
        <label class="form-check-label text-muted">
          <input type="checkbox" class="form-check-input name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}">
          Keep me signed in
        </label>
      </div>
      <a href="{{ route('password.request') }}" class="auth-link text-black">Forgot password?</a>
    </div>
    <div class="mb-2">
      <button type="button" class="btn btn-block btn-facebook auth-form-btn">
        <i class="mdi mdi-facebook mr-2"></i>Connect using facebook
      </button>
    </div>
    <div class="text-center mt-4 font-weight-light">
      Don't have an account? <a href="{{ route('register') }}" class="text-primary">Create</a>
    </div>
  </form>
@endsection
