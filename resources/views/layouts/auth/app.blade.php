<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title','Sistema De Gestão Hoteleiro | Login')</title>
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('/site/lib/animate/animate.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/site/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/site/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />
    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('/site/css/bootstrap.min.css') }}" rel="stylesheet" />
    <!-- Template Stylesheet -->
    <link href="{{ asset('/site/css/style.css') }}" rel="stylesheet" />
    <!-- @vite(["/resoures/css/app.css" , "/resoures/js/app.js"]) -->
</head>
<body class='bg-white'>
    {{$slot}}
<script src="{{ asset("/dashboard/assets/js/sweetalert.js") }}"></script>
<x-livewire-alert::scripts />

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('/site/lib/wow/wow.min.js') }}"></script>
 <script src="{{asset('/site/lib/easing/easing.min.js')}}"></script>
<script src="{{asset('/site/lib/waypoints/waypoints.min.js')}}"></script>
<script src="{{asset('/site/lib/counterup/counterup.min.js')}}"></script>
 <script src="{{asset('/site/lib/owlcarousel/owl.carousel.min.js')}}"></script>
<script src="{{asset('/site/lib/tempusdominus/js/moment.min.js')}}"></script>
 <script src="{{asset('/site/lib/tempusdominus/js/moment-timezone.min.js')}}"></script>
<script src="{{asset('/site/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js')}}"></script>

<script src="{{ asset('/site/js/main.js') }}"></script>
</body>
</html>
