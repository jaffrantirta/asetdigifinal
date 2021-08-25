<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sudana Bejo | Registrasi</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/dist/css/adminlte.min.css">
  <!-- lottie player -->
  <script src="<?php echo base_url('assets/build/js/lottie/LottiePlayer.js') ?>"></script>
</head>
<body class="hold-transition login-page">



<div class="register-box row">
  <?php if($status){ ?>
    <lottie-player class="col-12" src="<?php echo base_url('assets/build/js/lottie/success.json') ?>"  background="transparent"  speed="1"  style="width: 300px; height: 300px;"  loop  autoplay></lottie-player>
  <?php }else{ ?>
    <lottie-player class="col-12" src="<?php echo base_url('assets/build/js/lottie/failed.json') ?>"  background="transparent"  speed="1"  style="width: 300px; height: 300px;"  loop  autoplay></lottie-player>
  <?php } ?>
  <h3 class="text-center col-12"><?php echo $title ?></h3>
  <h5 class="text-center font-weight-bold col-12"><?php echo $message ?></h5>
  <a class="btn btn-primary col-12" href="<?php echo $link_redirect ?>"><?php echo $button_text ?></a>
  
</div>
<!-- /.register-box -->



<!-- jQuery -->
<script src="<?php echo base_url() ?>assets/build/js/admin/SweetAlertOffline.js"></script>
<script src="<?php echo base_url() ?>assets/build/js/admin/Jquery3Offline.js" crossorigin="anonymous"></script>
<script src="<?php echo base_url() ?>assets/build/js/admin/AdminLogin.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url() ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url() ?>assets/dist/js/adminlte.min.js"></script>
</body>
</html>
