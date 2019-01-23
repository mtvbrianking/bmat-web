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
        <button class="navbar-toggler navbar-toggler d-none d-lg-block align-self-center mr-2" type="button"
                data-toggle="minimize">
            <span class="icon-list icons"></span>
        </button>
        <p class="page-name d-none d-lg-block">Hi, {{ Auth::user()->name }}</p>
        <ul class="navbar-nav ml-lg-auto">
            <li class="nav-item">
                <form class="mt-2 mt-md-0 d-none d-lg-block search-input">
                    <div class="input-group">
                        <span class="input-group-addon d-flex align-items-center"><i
                                class="icon-magnifier icons"></i></span>
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
                <div class="dropdown-menu navbar-dropdown preview-list user-drop-down dropdownAnimation"
                     aria-labelledby="userDropdown">
                    <a class="dropdown-item preview-item" href="{{ route('users.profile', Auth::user()->id) }}">
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
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center ml-auto" type="button"
                data-toggle="offcanvas">
            <span class="icon-menu icons"></span>
        </button>
    </div>
</nav>
