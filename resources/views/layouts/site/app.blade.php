<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="keywords" />
    <meta content="" name="description" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="{{ asset("/site/css/font-heebo.css") }}" rel="stylesheet" />
    <link href="{{ asset("/site/css/font-awesome.css") }}" rel="stylesheet" />
    <link href="{{ asset("/site/css/bootstrap-icons.css") }}" rel="stylesheet" />
    <link href="{{ asset('/site/lib/animate/animate.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/site/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/site/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/site/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/site/css/style.css') }}" rel="stylesheet" />
    <link href="{{asset('/clientpanel/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet" />
    <!-- Select2 CSS -->
     <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
     <!-- Select2 Bootstrap Theme -->
     <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.5.2/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    {{-- @vite(["/resources/css/app.css" , "/resources/js/app.js"]) --}}
    <livewire:styles />
</head>
<body class="bg-white">

{{ $slot }}
<livewire:scripts />
<script src="{{ asset("/dashboard/assets/js/sweetalert.js") }}"></script>
@livewireSweetalertScripts
{{-- <x-livewire-alert::scripts /> --}}

<!-- Back to Top -->
<a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
</div>
<script src="{{ asset('/site/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset("/site/lib/jquery/jquery.js") }}"></script>
<script src="{{ asset("/site/lib/bootstrap/bootstrap.bundle.min.js") }}"></script>
<script src="{{ asset('/site/lib/wow/wow.min.js') }}"></script>
<script src="{{asset('/site/lib/easing/easing.min.js')}}"></script>
<script src="{{asset('/site/lib/waypoints/waypoints.min.js')}}"></script>
<script src="{{asset('/site/lib/counterup/counterup.min.js')}}"></script>
<script src="{{asset('/site/lib/owlcarousel/owl.carousel.min.js')}}"></script>
<script src="{{asset('/site/lib/tempusdominus/js/moment.min.js')}}"></script>
<script src="{{asset('/site/lib/tempusdominus/js/moment-timezone.min.js')}}"></script>
<script src="{{asset('/site/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<script src="{{ asset('/site/js/main.js') }}"></script>

<!-- Select 2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@stack("login-script")
@stack("create-account-script")
</body>
</html>
