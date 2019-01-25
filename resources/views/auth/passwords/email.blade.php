@extends('layouts.app')

@section('content')
  @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
  @endif
  <h4>Masukkan Email Anda !</h4>
    <form class="pt-3" method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="form-group">
          <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} form-control-lg" id="email" name="email" value="{{ old('email') }}" placeholder="E-mail" required autofocus>
          @if ($errors->has('email'))
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('email') }}</strong>
              </span>
          @endif
        </div>

        <div class="form-group">
            <div class="mt-3">
                <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                    Kirim
                </button>
            </div>
        </div>
    </form>
@endsection
