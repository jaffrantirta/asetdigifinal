<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $sistem_name ?> | Forgot Password</title>

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
    <p hidden id="id"><?php echo $id ?></p>
    <p hidden id="base_url"><?php echo base_url() ?></p>
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-warning">
            <div class="card-header text-center">
                <a href="<?php echo base_url() ?>" class="h1"><b><?php echo $sistem_name ?></b></a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Reset Password</p>

                <!-- <form action="../../index3.html" method="post"> -->
                <div class="input-group mb-3">
                    <input id="password" type="password" class="form-control" placeholder="enter new password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                
                <div class="input-group mb-3">
                    <input id="password_confirm" type="password" class="form-control" placeholder="re-enter new password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <button onclick="request()" class="btn btn-warning btn-block">Submit</button>
                </div>
               

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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function request() {
            var id = document.getElementById('id').innerHTML;
            var base_url = document.getElementById('base_url').innerHTML;
            var password = document.getElementById('password').value;
            var password_confirm = document.getElementById('password_confirm').value;
            
            $.ajax({
                url: base_url + "api/reset_password",
                type: "post",
                data: {
                    'id': id,
                    'password': password,
                    'password_confirm': password_confirm
                },
                success: function(result) {
                    $('.loader').attr('hidden', true);
                    console.log('data : ' + result);
                    var d = JSON.parse(result);
                    show_message('success', d.response.message['english'], '');
                },
                error: function(result, ajaxOptions, thrownError) {
                    $('.loader').attr('hidden', true);
                    // console.log('data : '+xhr.responseText);
                    show_message('error', 'Oops! sepertinya ada kesalahan', 'kesalahan tidak diketahui');
                    var string = JSON.stringify(result.responseText);
                    var msg = JSON.parse(result.responseText);
                    show_message('error', 'Oops! sepertinya ada kesalahan', msg.response.message['english']);
                }
            });
        }
    </script>
</body>

</html>