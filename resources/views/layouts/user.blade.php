<html>
  <head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" />
    <title>ARTIKA</title>
    <link href="{{ asset('dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('iconfonts/mdi/font/css/materialdesignicons.min.css') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  </head>
  <body>
        <nav class="navbar navbar-right navbar-expand-lg navbar-light bg-light fixed-top rounded">
          <div class="container">
            <a class="navbar-brand" href="{{ url('/home') }}"><img src="{{ asset('logo.png') }}" /></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="menu">
              <ul class="navbar-nav mr-auto tab">
                <li class="nav-item active">
                  <a class="nav-link btn-md mdi mdi-home" href="{{ url('/home') }}">  Home<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link btn-md mdi mdi-format-list-bulleted" href="index.html#">  Kategori</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link btn-md mdi mdi-cart" onclick="ListOpen()" href="#listopen">  Keranjang</a>
                </li>
              </ul>
              <form class="form-inline my-2 my-md-0">
                <input id="search" class="form-control" type="text" placeholder="cari" aria-label="Search">
              </form>

              @guest
                <div class="navbar-nav my-2"><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></div>
              @else

                <div class="navbar-nav my-2">
                  <a class="nav-link">Notifikasi</a>
                </div>

                <div class="navbar-nav my-3-lg dropdown">
                  <a class="nav-link btn-lg mdi mdi-account-circle" href="#" id="dropdown09" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                  <div class="dropdown-menu" aria-labelledby="dropdown09">
                    <a class="dropdown-item" href="#">Pengaturan</a>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                      <i class="mdi mdi-logout text-primary"></i>
                      Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                  </div>
                </div>

              @endguest

            </div>
          </div>
        </nav>
    @yield('content')
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('dist/js/bootstrap.min.js') }}"></script>
    @yield('script')
  </body>
</html>
