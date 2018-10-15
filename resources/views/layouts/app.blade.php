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

    {{--<link rel="shortcut icon" href="{{ assert('favicon.png') }}"/>--}}
</head>

<body>
<div id="app">
    <div class="container-scroller">
        {{-- partial:../../partials/_navbar.html --}}
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper">
                <a class="navbar-brand brand-logo" href="{{ url('/') }}">
                    <img src="{{ asset('img/logo.svg') }}" alt="logo">
                </a>
                <a class="navbar-brand brand-logo-mini" href="{{ url('/') }}">
                    <img src="{{ asset('img/logo_mini.svg') }}" alt="logo">
                </a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center">
                <button class="navbar-toggler navbar-toggler d-none d-lg-block align-self-center mr-2" type="button" data-toggle="minimize">
                    <span class="icon-list icons"></span>
                </button>
                <p class="page-name d-none d-lg-block">Hi, {{ Auth::user()->name }}</p>
                <ul class="navbar-nav ml-lg-auto">
                    <li class="nav-item">
                        <form class="mt-2 mt-md-0 d-none d-lg-block search-input">
                            <div class="input-group">
                                <span class="input-group-addon d-flex align-items-center"><i class="icon-magnifier icons"></i></span>
                                <input type="text" class="form-control" placeholder="{{ __('Search') }}...">
                            </div>
                        </form>
                    </li>
                    <li class="nav-item d-none d-sm-block profile-img">
                        {{--<a class="nav-link" id="userDropdown" href="#" data-toggle="dropdown" aria-expanded="false">--}}
                        <div class="circle" id="userDropdown" data-toggle="dropdown" aria-expanded="false">
                            <span class="initials">{{ acronym(Auth::user()->name) }}</span>
                        </div>
                        {{--</a>--}}
                        <div class="dropdown-menu navbar-dropdown preview-list user-drop-down dropdownAnimation" aria-labelledby="userDropdown">
                            <a class="dropdown-item preview-item" href="#">
                                <div class="preview-item-content">
                                    <p class="preview-subject font-weight-medium">{{ __('Profile') }}</p>
                                </div>
                            </a>
                            <a class="dropdown-item preview-item">
                                <div class="preview-item-content" href="{{ route('logout') }}"
                                     onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <p class="preview-subject font-weight-medium">{{ __('Sign out') }}</p>
                                </div>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </a>
                        </div>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center ml-auto" type="button" data-toggle="offcanvas">
                    <span class="icon-menu icons"></span>
                </button>
            </div>
        </nav>
        {{-- partial --}}
        <div class="container-fluid page-body-wrapper">
            <div class="row row-offcanvas row-offcanvas-right">
                {{-- partial:../../partials/_sidebar.html --}}
                <nav class="sidebar sidebar-offcanvas" id="sidebar">
                    <ul class="nav">
                        <li class="nav-item nav-category">
                            <span class="nav-link">ADMINISTRATION</span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#page-users" aria-expanded="false" aria-controls="page-users">
                                <span class="menu-title">Users</span>
                                <i class="icon-user menu-icon"></i>
                            </a>
                            <div class="collapse" id="page-users">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"><a class="nav-link" href="#"># Manage</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#"># Reports</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </nav>
                {{-- partial --}}
                <div class="content-wrapper">
                    @yield('content')
                </div>
                {{-- content-wrapper ends --}}
                {{-- partial:../../partials/_footer.html --}}
                <footer class="footer">
                    <div class="container-fluid clearfix">
                        <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright &copy; {{ date('Y') }} <a
                                    href="http://www.bmatovu.com/" target="_blank">bmatovu</a>. All rights reserved.</span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i
                                    class="mdi mdi-heart text-danger"></i></span>
                    </div>
                </footer>
                {{-- partial --}}
            </div>
            {{-- row-offcanvas ends --}}
        </div>
        {{-- page-body-wrapper ends --}}
    </div>
</div>
{{-- container-scroller --}}

{{-- Scripts --}}
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