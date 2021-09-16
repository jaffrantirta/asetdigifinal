<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Order Detail</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-4">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                    <strong>ORDER NUMBER</strong><br>
                </div>
                
                <h3 class="profile-username text-center"><?php echo $order->order_number ?></h3>
                <p hidden id="order_id"><?php echo $order->id ?></p>
                <p hidden id="user_id"><?php echo $order->request_by ?></p>
                <p hidden id="lisensi_id"><?php echo $order->upgrade_to ?></p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Date</b> <a class="float-right"><?php echo $order->date ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Requested By</b> <a href="<?php echo base_url('admin/members?action=detail&id='.$order->request_by) ?>" class="float-right"><?php echo $order->user_name ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Diff. Amount Payment</b> <a class="float-right"><?php echo $order->diff_payment  ?></a>
                  </li>
                </ul>
                <?php
                if($order->is_finish){
                    echo '<strong style="color: green"><b>Status FINISH</b></strong>';
                }else{
                    echo '<strong style="color: #ff6600"><b>Status PENDING</b></strong>';
                    echo '<button onclick="update_status_order_upgrade(1)" class="btn btn-warning btn-block"><b>Update Status</b></button>';
                    echo '<button onclick="update_status_order_upgrade(2)" class="btn btn-danger btn-block"><b>Reject</b></button>';
                }
                ?>
              </div>
              <!-- /.card-body -->
            </div>
           
          </div>
          <!-- /.col -->
          <div class="col-md-8">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#receipt" data-toggle="tab">Receipt of Payment</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">

                  <div class="active tab-pane" id="receipt">
                      <div class="form-group row">
                    <?php if($order->receipt_of_payment != null){ ?>

                    <img src="<?php echo base_url('upload/receipt/pin/'.$order->receipt_of_payment) ?>" class="col-12">

                    <?php }else{ ?>
                        <strong>Receipt of payment not upload yet</strong>
                    <?php } ?>

                      </div>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <script src="<?php echo base_url() ?>assets/build/js/admin/Jquery3Offline.js"></script>
  <script src="<?php echo base_url() ?>assets/build/js/admin/SweetAlertOffline.js"></script>
  <script>
      function updaaate_status_order_upgrade(status) {
        var vStatus = status;
        var order_id = document.getElementById('order_id').innerHTML;
        var base_url = document.getElementById('base_url').innerHTML;
        var lisensi_id = document.getElementById('lisensi_id').innerHTML;
        var user_id = document.getElementById('user_id').innerHTML;
            console.log(base_url);
        $.ajax({  
            url: base_url + "api/upgrade_licence_update_status",
            type: "post",
            data: {'order_id': order_id,'status': vStatus,'lisensi_id': lisensi_id,'user_id': user_id},
            processData: false,
            contentType: false,
            success: function(result) {
                console.log('data : ' + result);
                var d = JSON.parse(result);
                show_message('success', d.response.message['english'], '');
            },
            error: function(result, ajaxOptions, thrownError) {
                // console.log('data : '+xhr.responseText);
                show_message('error', 'Oops! sepertinya ada kesalahan', 'kesalahan tidak diketahui');
                var string = JSON.stringify(result.responseText);
                var msg = JSON.parse(result.responseText);
                show_message('error', 'Oops! sepertinya ada kesalahan', msg.response.message['english']);
            }
        });
        }
  </script>