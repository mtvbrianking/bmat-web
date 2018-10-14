<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <title>{{ config('app.name', 'Laravel') }}</title>
  
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{ asset('plugins/css/perfect-scrollbar.css') }}">
  
  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  
  <link rel="shortcut icon" href="../../images/favicon.png" />
</head>

<body>
  <div id="app">
    <div class="container-scroller">
      <!-- partial:../../partials/_navbar.html -->
      <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper">
          <a class="navbar-brand brand-logo" href="../../index.html">
            <img src="../../images/logo.svg" alt="logo">
          </a>
          <a class="navbar-brand brand-logo-mini" href="../../index.html">
            <img src="../../images/logo_mini.svg" alt="logo">
          </a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center">
          <button class="navbar-toggler navbar-toggler d-none d-lg-block align-self-center mr-2" type="button" data-toggle="minimize">
          <span class="icon-list icons"></span>
        </button>
          <p class="page-name d-none d-lg-block">Hi, John Doe</p>
          <ul class="navbar-nav ml-lg-auto">
            <li class="nav-item">
              <form class="mt-2 mt-md-0 d-none d-lg-block search-input">
                <div class="input-group">
                  <span class="input-group-addon d-flex align-items-center"><i class="icon-magnifier icons"></i></span>
                  <input type="text" class="form-control" placeholder="Search...">
                </div>
              </form>
            </li>
            <li class="nav-item d-none d-sm-block profile-img">
              <a class="nav-link profile-image" href="#">
                <img src="../../images/faces/face4.jpg" alt="profile-img">
                {{-- <span class="online-status online bg-success"></span> --}}
              </a>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center ml-auto" type="button" data-toggle="offcanvas">
            <span class="icon-menu icons"></span>
          </button>
        </div>
      </nav>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <div class="row row-offcanvas row-offcanvas-right">
          <!-- partial:../../partials/_sidebar.html -->
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
                    <li class="nav-item"> <a class="nav-link" href="#"># Manage</a></li>
                    <li class="nav-item"> <a class="nav-link" href="#"># Reports</a></li>
                  </ul>
                </div>
              </li>
          </nav>
          <!-- partial -->
          <div class="content-wrapper">
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:../../partials/_footer.html -->
          <footer class="footer">
            <div class="container-fluid clearfix">
              <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2018 <a href="http://www.bootstrapdash.com/" target="_blank">Bootstrapdash</a>. All rights reserved.</span>
              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="mdi mdi-heart text-danger"></i></span>
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- row-offcanvas ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
  </div>
  <!-- container-scroller -->

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}"></script>

  <!--<script src="../../node_modules/jquery/dist/jquery.min.js"></script>-->
  <!--<script src="../../node_modules/popper.js/dist/umd/popper.min.js"></script>-->
  <!--<script src="../../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>-->
  <script src="{{ asset('plugins/js/perfect-scrollbar.min.js') }}"></script>

  <script src="{{ asset('js/off-canvas.js') }}"></script>
  <script src="{{ asset('js/hoverable-collapse.js') }}"></script>
  <script src="{{ asset('js/misc.js') }}"></script>

</body>

</html>