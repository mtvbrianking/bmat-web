<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="B'Smart Technology (U) Ltd" name="author" />
    <meta content="Regional Electronic Cargo Tracking System" name="description" />

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="{{ asset('plugins/css/perfect-scrollbar.css') }}">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
</head>

<body>
<div id="app">
    <div class="container-scroller">

        @include('layouts.partials.nav')

        <div class="container-fluid page-body-wrapper">
            <div class="row row-offcanvas row-offcanvas-right">

                @include('layouts.partials.sidebar')

                <div class="content-wrapper">
                    @yield('content')
                </div>

                @include('layouts.partials.footer')

            </div>

        </div>

    </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>

<script src="{{ asset('plugins/js/perfect-scrollbar.min.js') }}"></script>

<script src="{{ asset('js/off-canvas.js') }}"></script>
<script src="{{ asset('js/hoverable-collapse.js') }}"></script>
<script src="{{ asset('js/misc.js') }}"></script>
<script type="text/javascript">
    window.$.ajaxSetup({
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
</body>

</html>
