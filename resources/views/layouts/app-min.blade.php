<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    {{-- Required meta tags --}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- plugins:css --}}
    <link rel="stylesheet" href="{{ asset('plugins/css/perfect-scrollbar.css') }}">

    {{-- Styles --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="shortcut icon" href="../../images/favicon.png"/>
</head>

<body>
<div id="app">
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper">
            @yield('content')
        </div>
        {{-- page-body-wrapper ends --}}
    </div>
    {{-- container-scroller --}}
</div>

{{-- Scripts --}}
<script src="{{ asset('js/app.js') }}"></script>

<script src="{{ asset('plugins/js/perfect-scrollbar.min.js') }}"></script>

<script src="{{ asset('js/off-canvas.js') }}"></script>
<script src="{{ asset('js/hoverable-collapse.js') }}"></script>
<script src="{{ asset('js/misc.js') }}"></script>

</body>

</html>
