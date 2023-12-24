<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>



    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}

    <!-- Styles -->
    <link href="{{ asset('admin-lite/fontawesome-free/css/all.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('admin-lite/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('admin-lite/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('admin-lite/plugins/jqvmap/jqvmap.min.css') }}">
    <link href="{{ asset('admin-lite/css/adminlte.min.css') }}" rel="stylesheet">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('admin-lite/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('admin-lite/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('admin-lite/plugins/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-lite/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    @laravelPWA
    @livewireStyles
    @stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    {{-- {{$slot}} --}}
    @yield('content')
    {{-- @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif --}}
    <!-- jQuery -->
  <script src="{{ asset('admin-lite/plugins/jquery/jquery.min.js') }}"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="{{ asset('admin-lite/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset('admin-lite/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('admin-lite/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
  <!-- ChartJS -->
  <script src="{{ asset('admin-lite/plugins/chart.js/Chart.min.js') }}"></script>
  <!-- Sparkline -->
  {{-- <script src="{{ asset('admin-lite/plugins/sparklines/sparkline.js') }}"></script> --}}
  <!-- JQVMap -->
  {{-- <script src="{{ asset('admin-lite/plugins/jqvmap/jquery.vmap.min.js') }}"></script> --}}
  {{-- <script src="{{ asset('admin-lite/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script> --}}
  <!-- jQuery Knob Chart -->
  {{-- <script src="{{ asset('admin-lite/plugins/jquery-knob/jquery.knob.min.js') }}"></script> --}}
  <!-- daterangepicker -->
  <script src="{{ asset('admin-lite/plugins/moment/moment.min.js') }}"></script>
  <script src="{{ asset('admin-lite/plugins/daterangepicker/daterangepicker.js') }}"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="{{ asset('admin-lite/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
  <!-- Summernote -->
  <script src="{{ asset('admin-lite/plugins/summernote/summernote-bs4.min.js') }}"></script>
  <!-- overlayScrollbars -->
  <script src="{{ asset('admin-lite/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
  <script src="{{ asset('admin-lite/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('admin-lite/js/adminlte.min.js') }}"></script>
  <script src="{{ asset('admin-lite/js/pickaday.js') }}"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  {{-- <script src="{{ asset('admin-lite/js/dashboard.js') }}"></script> --}}
  <!-- AdminLTE for demo purposes -->
  {{-- <script src="{{ asset('admin-lite/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script> --}}
  <script src="{{ asset('admin-lite/js/demo.js') }}"></script>
  @livewireScripts
  <script>
      $(document).ready(function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000
        });

        Livewire.on('plashMessage', function(data) {
            Toast.fire({
                icon: data.type,
                title: data.message
            });
        });

      });
  </script>
  @stack('scripts')
</body>
</html>
