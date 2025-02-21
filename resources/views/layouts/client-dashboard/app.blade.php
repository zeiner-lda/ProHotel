<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Painel do Cliente</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset("/site/css/font-awesome.css") }}" rel="stylesheet" />
  <link href="{{asset('/clientpanel/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('/clientpanel/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('/clientpanel/assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{asset('/clientpanel/assets/vendor/quill/quill.snow.css')}}" rel="stylesheet">
  <link href="{{asset('/clientpanel/assets/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
  <link href="{{asset('/clientpanel/assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
  <link href="{{asset('/clientpanel/assets/vendor/simple-datatables/style.css')}}" rel="stylesheet">
  <livewire:styles />
  <link href="{{asset('/clientpanel/assets/css/style.css')}}" rel="stylesheet">
</head>

<body>
    {{ $slot }}
    <livewire:scripts />
    <script src="{{ asset('/dashboard/assets/js/sweetalert.js') }}"></script>
    <x-livewire-alert::scripts />
    <x-client.side-bar />
    <livewire:client.top-bar-component />
    <x-client.footer />
  <!-- Vendor JS Files -->
  <script src="{{asset('/clientpanel/assets/vendor/apexcharts/apexcharts.min.js')}}"></script>
  <script src="{{asset('/clientpanel/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('/clientpanel/assets/vendor/chart.js/chart.umd.js')}}"></script>
  <script src="{{asset('/clientpanel/assets/vendor/echarts/echarts.min.js')}}"></script>
  <script src="{{asset('/clientpanel/assets/vendor/quill/quill.js')}}"></script>
  <script src="{{asset('/clientpanel/assets/vendor/simple-datatables/simple-datatables.js')}}"></script>
  <script src="{{asset('/clientpanel/assets/vendor/tinymce/tinymce.min.j')}}s"></script>
  <script src="{{asset('/clientpanel/assets/vendor/php-email-form/validate.js')}}"></script>
  <!-- Template Main JS File -->
  <script src="{{asset('/clientpanel/assets/js/main.js')}}"></script>
</body>
</html>
