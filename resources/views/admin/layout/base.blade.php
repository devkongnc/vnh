<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>VietNamHouse</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic' rel='stylesheet' type='text/css'>
    <link href="{{ asset('favicon.ico') }}" rel="shortcut icon"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/vendor_admin.css') }}">
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/admin-custom.css') }}">
    @yield('styles')

</head>

<body class="hold-transition skin-blue sidebar-mini">
    @include('admin.layout.header') @yield('content') @include('admin.layout.footer')
    <script type="text/javascript" src="{{ asset('js/vendor_admin.js') }}"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.js"></script>
    <script type="text/javascript">
        current_lang_name = '{{ LaravelLocalization::getCurrentLocaleName() }}';
        current_locale = '{{ $current_locale }}';
        $('form#export').submit(function(event) {
            if (!confirm('@lang('admin.common.Are you sure?')')) return false;
        });
    </script>
    <script type="text/javascript" src="{{ asset('js/admin.js') }}"></script>
    @yield('scripts')
    @stack('scripts')
</body>

</html>
