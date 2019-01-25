<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>UD. ARTIKA</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <link rel="stylesheet" href="{{ asset('iconfonts/mdi/font/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/horizontal-layout/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/horizontal-layout/css/vendor.bundle.addons.css') }}">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('css/vertical-layout-light/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" />

</head>
  <body class="sidebar-dark">
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
          <div class="row w-100">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left p-5">
                <div class="brand-logo">
                  <img src="{{ asset('logo.svg') }}" alt="logo">
                </div>
              @yield('content')
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="{{ asset('js/script/vendor.bundle.base.js') }}"></script>
  <script src="{{ asset('js/script/vendor.vendor.bundle.addons.js') }}"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="{{ asset('js/script/off-canvas.js') }}"></script>
  <script src="{{ asset('js/script/hoverable-collapse.js') }}"></script>
  <script src="{{ asset('js/script/template.js') }}"></script>
  <script src="{{ asset('js/script/settings.js') }}"></script>
  <script src="{{ asset('js/script/todolist.js') }}"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="{{ asset('js/script/dashboard.js') }}"></script>
  <!-- End custom js for this page-->
</body>
</html>
