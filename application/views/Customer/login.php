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
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6 col-sm-6 col-xs-6">
               <div class="card card-outline card-warning">
                   <div class="card-header text-center">
                      <h1>PT. WINDAX</h1> 
                    </div>
                        <div class="card-body">
      <p class="login-box-msg">Perusahaan bergerak di bidang Jasa Edukasi  kepada masyarakat, tentang pentingnya memiliki Asset Cryptocurrency / mata uang digital yang sudah ada di market Indodax dan Bappebti.

Perubahan dunia sangat pesat sekali dimana ada revolusi sistem keuangan yang membuat semua masyarakat dunia beralih kepada Teknologi Blockchain, untuk itu kami menciptakan trainer tentang bagaimana memiliki dan memilih Asset Cryptocurrency yang benar,  melalui Sistem Network untuk memberikan komisi-komisi dan Asset Properti untuk semua member yang sudah ikut serta memberikan Edukasi kepada masyarakat.

#salam sukses berkarya memberikan edukasi ke masyarakat 🙏</p>

      <!-- <form action="../../index3.html" method="post"> -->
    
      
     
    </div>
                 </div>
            </div>
       
<p hidden id="base_url"><?php echo base_url() ?></p>
<div class="login-box-msg">
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
          <a class="col-6 text-center" href="#">Forgot Password</a>
          <!-- <a class="col-6 text-center" href="<?php echo base_url('register') ?>">Register</a> -->
        </p>
     
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
            
        </div>
    </div>
<!---->
<!-- /.login-box -->
    <div class="m-5">
          <a class="btn btn-success p-2 rounded-circle fixed-footer" href="https://api.whatsapp.com/send?phone=628113993499&amp;text=Halo%20admin,%20Saya%20mau%20bertanya?" target="_blank">
          <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
            <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
          </svg>
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
