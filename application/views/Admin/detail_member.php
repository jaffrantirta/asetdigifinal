
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Member Detail</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
              <div class="text-center">
                    <?php
                        if (file_exists(base_url('upload/members/'.$member->profile_picture))) {
                            $thumb = base_url('upload/no_image/no_image.png');
                        }else{
                            $thumb = base_url('upload/members/'.$member->profile_picture);
                        }
                    ?>
                  <img class="profile-user-img img-fluid img-circle"
                       src="<?php echo $thumb ?>"
                       alt="User profile picture">
                </div>
                
                <h3 class="profile-username text-center"><?php echo $member->name ?></h3>
                <p hidden id="order_id"><?php echo $member->id ?></p>

                <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                    <b>USername</b> <a class="float-right"><?php echo $member->username ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Email</b> <a class="float-right"><?php echo $member->email ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Register Date</b> <a class="float-right"><?php echo $member->register_date ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>USDT wallet</b> <input disabled id="usdt_wallet" class="float-right" value="<?php echo $member->usdt_wallet ?>">
                  </li>
                  
                </ul>
                <button onclick="copy()" class="btn btn-info btn-block"><b>Copy USDT Wallet</b></button>
              </div>
              <!-- /.card-body -->
            </div>
           
          </div>
          <!-- /.col -->
          
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <script src="<?php echo base_url() ?>assets/build/js/customer/Jquery3Offline.js"></script>
  <script src="<?php echo base_url() ?>assets/build/js/customer/SweetAlertOffline.js"></script>
  <script>
      $(document).ready(function(){
        $("#but_upload").click(function(){

            var fd = new FormData();
            var files = $('#file')[0].files;
            var order_number = document.getElementById('order_number').innerHTML;
            
            // Check file selected or not
            if(files.length > 0 ){
            fd.append('file',files[0]);
            $.ajax({
                url: document.getElementById('base_url').innerHTML + 'api/upload_receipt/' + order_number,
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    if(response != 0){
                        Swal.fire(
                            'File uploaded',
                            'Your file has been uploaded',
                            'success'
                        )
                    }else{
                        Swal.fire(
                            'File not upload',
                            'Your file failed to upload',
                            'error'
                        )
                    }
                },
            });
            }else{
                Swal.fire(
                    'Choose file before',
                    '',
                    'warning'
                )
            }
        });
        });
  </script>
  <script>
    function copy() {
        /* Get the text field */
        var copyText = document.getElementById("usdt_wallet");

        /* Select the text field */
        copyText.select();
        copyText.setSelectionRange(0, 99999); /* For mobile devices */

        /* Copy the text inside the text field */
        navigator.clipboard.writeText(copyText.value);

        /* Alert the copied text */
        Swal.fire('Copied', '', 'success')
        // alert("Copied the text: " + copyText.value);
    }
</script>