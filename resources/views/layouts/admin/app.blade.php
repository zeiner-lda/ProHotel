
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield("title")</title>
    <link href="{{ asset("/site/css/font-awesome.css") }}" rel="stylesheet" />
    <link href="{{ asset("/site/css/bootstrap-icons.css") }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/dashboard/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/dashboard/assets/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('/dashboard/assets/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('/dashboard/assets/vendors/ti-icons/css/themify-icons.css') }}">
     <link rel="stylesheet" href="{{ asset('/dashboard/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('/dashboard/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/dashboard/assets/css/style.css') }}">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <!-- Select2 Bootstrap Theme -->
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.5.2/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <livewire:styles />
    {{-- @vite(["/resoures/css/app.css" , "/resoures/js/app.js"]) --}}
  </head>
  <body>
    {{ $slot }}
    <livewire:scripts />
    <script src="{{ asset('/dashboard/assets/js/sweetalert.js') }}"></script>
    <x-livewire-alert::scripts />
    </div>
    </div>
    </div>

   <script src="{{ asset('/dashboard/assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{asset('/dashboard/assets/vendors/chart.js/chart.umd.js')}}"></script>
    <script src="{{asset('/dashboard/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('assets/js/off-canvas.js')}}"></script>
    <script src="{{asset('assets/js/misc.js')}}"></script>
    <script src="{{asset('/dashboard/assets/js/settings.js')}}"></script>
    <script src="{{asset('/dashboard/assets/js/todolist.js')}}"></script>
    <script src="{{asset('/dashboard/assets/js/jquery.cookie.js')}}"></script>
    <script src="{{asset('/dashboard/assets/js/dashboard.js')}}"></script>
    <!-- Select 2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@stack('stockroom-dashboard')
@stack("admin-hotel")
@stack("reception-room")
</body>
</html>
