<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $sistem_name ?> Admin | <?php echo $page ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/summernote/summernote-bs4.min.css">
  <!-- loader -->
  <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/loader/loader.css') ?>" />
  <!-- swicth toggle -->
  <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/toggle.css') ?>" />
  <!-- lottie player -->
  <script src="<?php echo base_url('assets/build/js/lottie/LottiePlayer.js') ?>"></script>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-footer-fixed text-sm"></body>
<div hidden class="loader"></div>
<p hidden id="base_url"><?php echo base_url() ?></p>

<div class="wrapper">



  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <lottie-player class="animation__shake" src="https://assets9.lottiefiles.com/packages/lf20_x62chJ.json"  background="transparent"  speed="1"  style="width: 300px; height: 300px;"  loop  autoplay></lottie-player>
    <h3 class="text-center">Memuat ...</h3> 
  </div>

  

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <!-- Right navbar links -->
    <!-- <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul> -->
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <!-- <img src="<?php echo base_url() ?>assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
      <h4 class="brand-text font-weight-light"><?php echo $sistem_name ?> - Admin</h4>
    </a>

    

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo base_url() ?>assets/dist/img/user2.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $session['data']->name ?></a>
          <p id="id" hidden><?php echo $session['data']->id ?></p>
        </div>
      </div>

      

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
          <?php if($page == 'Dashboard'){ ?>
            <a href="<?php echo base_url('admin/dashboard') ?>" class="nav-link active">
          <?php }else{ ?>
            <a href="<?php echo base_url('admin/dashboard') ?>" class="nav-link">
          <?php } ?>
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>


          <!-- <li class="nav-item">
          <?php if($page == 'Pengguna'){ ?>
            <a href="<?php echo base_url('admin/users') ?>" class="nav-link active">
          <?php }else{ ?>
            <a href="<?php echo base_url('admin/users') ?>" class="nav-link">
          <?php } ?>
              <i class="nav-icon fas fa-user"></i>
              <p>
                test
              </p>
            </a>
          </li> -->


          <li class="nav-item">
        <?php if($page == 'Request PIN Register' || $page == 'Request Lisensi'){ ?>
          <li class="nav-item menu-is-opening menu-open">
        <?php }else{ ?>
          <li class="nav-item">
        <?php } ?>
            <a id="nav-daerah" href="#" class="nav-link"> 
              <i class="nav-icon fas fa-key"></i>
              <p>
                Request
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
              <?php if($page == 'Request PIN Register'){ ?>
                <a href="<?php echo base_url('admin/request?action=pin') ?>" class="nav-link active">
              <?php }else{ ?>
                <a href="<?php echo base_url('admin/request?action=pin') ?>" class="nav-link">
              <?php } ?>
                  <i class="far fa-circle nav-icon"></i>
                  <p>PIN Register</p>
                </a>
              </li>
              <li class="nav-item">
              <?php if($page == 'Request Lisensi'){ ?>
                <a href="<?php echo base_url('admin/request?action=lisensi') ?>" class="nav-link active">
              <?php }else{ ?>
                <a href="<?php echo base_url('admin/request?action=lisensi') ?>" class="nav-link">
              <?php } ?>
                  <i class="far fa-circle nav-icon"></i>
                  <p>Lisensi</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
          <?php if($page == 'Members'){ ?>
            <a href="<?php echo base_url('admin/members') ?>" class="nav-link active">
          <?php }else{ ?>
            <a href="<?php echo base_url('admin/members') ?>" class="nav-link">
          <?php } ?>
              <i class="nav-icon fas fa-users"></i>
              <p>
                Members
              </p>
            </a>
          </li>

          <li class="nav-item">
        <?php if($page == 'Company Profile' || $page == 'PIN Register Settings' || $page == 'Licences' || $page == 'Change Instraction Payment'){ ?>
          <li class="nav-item menu-is-opening menu-open">
        <?php }else{ ?>
          <li class="nav-item">
        <?php } ?>
            <a id="nav-daerah" href="#" class="nav-link"> 
              <i class="nav-icon fas fa-key"></i>
              <p>
                Settings
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
              <?php if($page == 'Company Profile'){ ?>
                <a href="<?php echo base_url('admin/settings?action=company-profile') ?>" class="nav-link active">
              <?php }else{ ?>
                <a href="<?php echo base_url('admin/settings?action=company-profile') ?>" class="nav-link">
              <?php } ?>
                  <i class="far fa-circle nav-icon"></i>
                  <p>Company Profile</p>
                </a>
              </li>
              <li class="nav-item">
              <?php if($page == 'PIN Register Settings'){ ?>
                <a href="<?php echo base_url('admin/settings?action=pin-register') ?>" class="nav-link active">
              <?php }else{ ?>
                <a href="<?php echo base_url('admin/settings?action=pin-register') ?>" class="nav-link">
              <?php } ?>
                  <i class="far fa-circle nav-icon"></i>
                  <p>PIN Register Settings</p>
                </a>
              </li>
              <li class="nav-item">
              <?php if($page == 'Licences'){ ?>
                <a href="<?php echo base_url('admin/settings?action=licences') ?>" class="nav-link active">
              <?php }else{ ?>
                <a href="<?php echo base_url('admin/settings?action=licences') ?>" class="nav-link">
              <?php } ?>
                  <i class="far fa-circle nav-icon"></i>
                  <p>Licences</p>
                </a>
              </li>
              <li class="nav-item">
              <?php if($page == 'Change Instraction Payment'){ ?>
                <a href="<?php echo base_url('admin/settings?action=instruction') ?>" class="nav-link active">
              <?php }else{ ?>
                <a href="<?php echo base_url('admin/settings?action=instruction') ?>" class="nav-link">
              <?php } ?>
                  <i class="far fa-circle nav-icon"></i>
                  <p>Change Instructions Payment</p>
                </a>
              </li>
            </ul>
          </li>

         
          <li class="nav-item">
                <a href="<?php echo base_url('admin/logout') ?>" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Logout
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  