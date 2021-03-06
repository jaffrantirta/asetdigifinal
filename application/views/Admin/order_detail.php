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

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Date</b> <a class="float-right"><?php echo $order->date ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Requested By</b> <a href="<?php echo base_url('admin/members?action=detail&id='.$order->requested_by) ?>" class="float-right"><?php echo $order->user_register ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Amount</b> <a class="float-right"><?php echo $order->amount  ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Total Payment</b> <a class="float-right"><?php echo $order->total_payment  ?> <?php echo $order->currency  ?></a>
                  </li>
                </ul>
                <?php
                if(!$order->is_open){
                    if(!$order->is_pending){
                        if(!$order->is_finish){
                            if(!$order->is_reject){
                                echo '<strong style="color: red"><b>Status Unknown</b></strong>';
                            }else{
                                echo '<strong style="color: red"><b>Status REJECTED</b></strong>';
                            }
                        }else{
                            echo '<strong style="color: green"><b>Status FINISH</b></strong>';
                        }
                    }else{
                        $act = "'pending'";
                        $act1 = "'reject'";
                        echo '<strong style="color: yellow"><b>Status PENDING</b></strong>';
                        echo '<button onclick="update_status_order_pin('.$act.')" class="btn btn-warning btn-block"><b>Update Status to Finish</b></button>';
                        echo '<button onclick="update_status_order_pin('.$act1.')" class="btn btn-danger btn-block"><b>Reject</b></button>';
                    }
                }else{
                    $act = "'open'";
                    $act1 = "'reject'";
                    echo '<strong style="color: blue"><b>Status OPEN</b></strong>';
                    echo '<button onclick="update_status_order_pin('.$act.')" class="btn btn-warning btn-block"><b>Update Status</b></button>';
                    echo '<button onclick="update_status_order_pin('.$act1.')" class="btn btn-danger btn-block"><b>Reject</b></button>';
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
                  <li class="nav-item"><a class="nav-link active" href="#pin" data-toggle="tab">PIN Register</a></li>
                  <li class="nav-item"><a class="nav-link" href="#receipt" data-toggle="tab">Receipt of Payment</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  
                  <div class="active tab-pane" id="pin">
                      <div class="form-group row">
                    <?php if($pin['status']){ ?>
                    <?php $i = 0; ?>
                    <?php foreach($pin['data'] as $data){ ?>

                        <label for="inputName" class="col-sm-2 col-form-label" style="color: red;">PIN <?php echo $i + 1 ?></label>
                        <div class="col-sm-10">
                          <strong><?php echo $data->pin ?></strong>
                          <?php if($data->is_active){$status='ACTIVE';}else{$status='NOT ACTIVE';} ?>
                          <p>Status : <?php echo $status ?></p>
                        </div>

                    <?php $i++; 
                        } ?>
                    <?php }else{ ?>
                        <button onclick="generate_pin()" class="col-12 btn btn-danger">Generate PIN</button>
                    <?php } ?>

                      </div>
                  </div>

                  <div class="tab-pane" id="receipt">
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
  <script src="<?php echo base_url() ?>assets/build/js/admin/GeneratePIN.js"></script>
  <script>
      $(document).ready(function(){
        $("#but_upload").click(function(){

            var fd = new FormData();
            var files = $('#file')[0].files;
            
            // Check file selected or not
            if(files.length > 0 ){
            fd.append('file',files[0]);
                console.log(document.getElementById('base_url').innerHTML + 'api/upload_receipt/PR');
            $.ajax({
                url: document.getElementById('base_url').innerHTML + 'api/upload_receipt/PR',
                type: 'post',
                data: fd,
                contentType: false,
                processData: true,
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