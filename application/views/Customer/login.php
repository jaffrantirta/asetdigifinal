<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $sistem_name ?> | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-footer-fixed text-sm login-page " background="<?php echo base_url() ?>upload/bg.jpg">

  <p hidden id="base_url"><?php echo base_url() ?></p>
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-warning">
      <div class="card-header text-center">
        <a href="<?php echo base_url() ?>" class="h1"><b><?php echo $sistem_name ?></b></a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Masuk dengan username dan password</p>

        <!-- <form action="../../index3.html" method="post"> -->
        <div class="input-group mb-3">
          <input id="username" type="text" class="form-control" placeholder="Username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input id="password" type="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <button onClick="login()" class="btn btn-warning btn-block">Log In</button>
        </div>
        <p class="col-12 row">
          <a class="col-6 text-center" href="<?php echo base_url('customer/forgot_password') ?>">Forgot Password</a>
          <!-- <a class="col-6 text-center" href="<?php echo base_url('register') ?>">Register</a> -->
        </p>

      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>

  <!---->
  <!-- /.login-box -->

  <div class="m-5 text-right">
    <a href="https://api.whatsapp.com/send?phone=628113993499&amp;text=Halo%20admin,%20Saya%20mau%20bertanya?" target="_blank">
      <img width="205px" height="80px" src="<?php echo base_url() ?>upload/wa.png">
    </a>
  </div>
  <!-- jQuery -->
  <script src="<?php echo base_url() ?>assets/build/js/customer/SweetAlertOffline.js"></script>
  <script src="<?php echo base_url() ?>assets/build/js/customer/Jquery3Offline.js" crossorigin="anonymous"></script>
  <script src="<?php echo base_url() ?>assets/build/js/customer/CustomerLogin.js"></script>
  <script src="<?php echo base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?php echo base_url() ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo base_url() ?>assets/dist/js/adminlte.min.js"></script>
</body>

</html>