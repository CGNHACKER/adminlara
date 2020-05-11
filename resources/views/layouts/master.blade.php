
<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>ระบบการลา (Leave Control System)</title>

  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="/css/app.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper" id="app">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" @keyup="searchit" v-model="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" @click="searchit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
    <div align="center">
      <span class="brand-text font-weight-light">Human Management</span>
      </div>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{'./img/profile/'.auth()->user()->photo}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
          <a href="#" class="d-block"><b>{{ Auth::user()->position }}</b></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <router-link to="/dashboard" class="nav-link">
            <i class="fas fa-tachometer-alt"></i> 
              <p>
                แดชบอร์ด
              </p>
            </router-link>
          </li>
          
          <li class="nav-item">
            <router-link to="/members" class="nav-link">
            <i class="fas fa-user-friends"></i> 
              <p>
                สมาชิก
              </p>
            </router-link>
          </li>

          <li class="nav-item">
            <router-link to="/leave" class="nav-link">
            <i class="fas fa-user"></i>
              <p>
                จัดการการลา
              </p>
            </router-link>
          </li>

          <li class="nav-item">
            <router-link to="/leaveconfig" class="nav-link">
            <i class="fas fa-user"></i>
              <p>
                ตั้งค่าการลา
              </p>
            </router-link>
          </li>

          <li class="nav-item">
            <router-link to="/department" class="nav-link">
            <i class="fas fa-user"></i>
              <p>
                จัดการแผนก
              </p>
            </router-link>
          </li>

          <li class="nav-item">
            <router-link to="/holidayconfig" class="nav-link">
            <i class="fas fa-user"></i>
              <p>
                จัดการวันหยุด
              </p>
            </router-link>
          </li>

          <li class="nav-item">
            <router-link to="/roles" class="nav-link">
            <i class="fas fa-user"></i>
              <p>
                จัดการสิทธิ์
              </p>
            </router-link>
          </li>
          
          <li class="nav-item">
            <router-link to="/profile" class="nav-link">
            <i class="fas fa-user"></i>
              <p>
                จัดการโปรไฟล์
              </p>
            </router-link>
          </li>

          @can('isAdmin')
          <!-- <li class="nav-item">
            <router-link to="/developer" class="nav-link">
            <i class="fas fa-cog"></i>
              <p>
                Developer
              </p>
            </router-link>
          </li> -->
          @endcan
          <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                <i class="fas fa-power-off"></i>
                <p>
                  {{ __('ออกจากระบบ') }}
                </p>

            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
          </li>
               <!-- <li class="nav-item has-treeview">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Starter Pages
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Active Page</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Inactive Page</p>
                </a>
              </li>
            </ul>
          </li> -->
          <!-- <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Simple Link
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li> -->
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Starter Page</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Starter Page</li>
            </ol>
          </div>
        </div>
      </div>
    </div> -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <router-view></router-view>
        <vue-progress-bar></vue-progress-bar>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

@auth
  <script>
    window.user = @json(auth()->user())
  </script>
@endauth

<script src="/js/app.js"></script>


</body>
</html>
