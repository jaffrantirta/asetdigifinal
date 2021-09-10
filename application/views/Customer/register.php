<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $sistem_name ?> | Registrasi</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-footer-fixed text-sm login-page" background="<?php echo base_url() ?>upload/bg.jpg">
<p hidden id="base_url"><?php echo base_url() ?></p>



<div class="register-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="<?php echo base_url(); ?>" class="h1"><b>⠀ ⠀ ⠀ ⠀ ⠀ ⠀⠀ ⠀</b></a>
    </div>
    <div class="card-header text-center">
      <a href="<?php echo base_url(); ?>" class="h1"><b><?php echo $sistem_name ?></b> Registrasi</a>
    </div>
    <div class="card-body">
        <div class="input-group mb-3">
          <input required id="name" type="text" class="form-control" placeholder="Full Name">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input required id="email" type="email" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input required id="sponsor_code" type="text" class="form-control" placeholder="Sponsor Code">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input required id="pin_register" type="password" pattern="[0-9]*" inputmode="numeric" class="form-control" placeholder="PIN Register">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <input type="hidden" value="<?php echo $position ?>" id="position" name="position">
        <input type="hidden" value="<?php echo $top_id ?>" id="top_id" name="top_id">
        
        <div class="input-group mb-3">
          <input required id="username" type="text" class="form-control" placeholder="Username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        
        <div class="input-group mb-3">
          <input required id="password" type="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input required id="re_password" type="password" class="form-control" placeholder="Re-input Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input required id="secure_pin" type="password" pattern="[0-9]*" inputmode="numeric" class="form-control" placeholder="Secure PIN">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        
        <div class="input-group mb-3">
          <input required id="re_secure_pin" type="password" pattern="[0-9]*" inputmode="numeric" class="form-control" placeholder="Re - input Secure PIN">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button onclick="register_customer()" class="btn btn-primary btn-block">Register</button>
          </div>
        </div>
        <p style="margin-top: 1em" class="col-12 row">
          <a class="col-12" href="<?php echo base_url() ?>">Login</a>
        </p>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->



<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"></script>
<script src="<?php echo base_url() ?>assets/build/js/customer/SweetAlertOffline.js"></script>
<script src="<?php echo base_url() ?>assets/build/js/customer/Jquery3Offline.js" crossorigin="anonymous"></script>
<script src="<?php echo base_url() ?>assets/build/js/customer/CustomerLogin.js"></script>
<script src="<?php echo base_url() ?>assets/build/js/customer/RegisterCustomer.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url() ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url() ?>assets/dist/js/adminlte.min.js"></script>
</body>
</html>
