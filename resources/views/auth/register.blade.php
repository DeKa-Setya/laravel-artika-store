@extends('layouts.app')

@section('content')
  <h4>Halo ! Ayo Kita Mulai</h4>
  <h6 class="font-weight-light">Daftarkan Akun Anda Untuk Melanjutkan.</h6>
  <form class="pt-3" method="POST" action="{{ route('register') }}">
      @csrf
      <div class="form-group">
          <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }} form-control-lg" name="name" value="{{ old('name') }}" placeholder="Nama" required autofocus>
              @if ($errors->has('name'))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('name') }}</strong>
                  </span>
              @endif
      </div>

      <div class="form-group">
              <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} form-control-lg" name="email" value="{{ old('email') }}" placeholder="E-mail" required>
              @if ($errors->has('email'))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('email') }}</strong>
                  </span>
              @endif
      </div>

      <div class="form-group">
        <input id="telephone" type="telephone" class="form-control{{ $errors->has('telephone') ? ' is-invalid' : '' }} form-control-lg" name="telephone" placeholder="Telepon" required>
              @if ($errors->has('telephone'))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('telephone') }}</strong>
                  </span>
              @endif
      </div>

      <div class="form-group">
        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>

              @if ($errors->has('password'))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('password') }}</strong>
                  </span>
              @endif
      </div>

      <div class="form-group">
        <input id="password-confirm" type="password" class="form-control form-control-lg" name="password_confirmation" placeholder="Konfirmasi Password" required>
      </div>

      <div class="form-group">
          <div class="mt-3">
              <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                  Register
              </button>
          </div>
      </div>
      <div class="text-center mt-4 font-weight-light">
        Sudah Daftar ? <a href="{{ route('login') }}" class="text-primary">Create</a>
      </div>
  </form>
@endsection
