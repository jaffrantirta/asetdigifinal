<p hidden id="order_number"><?php echo $order->order_number ?></p>
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

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Date</b> <a class="float-right"><?php echo $order->date ?></a>
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
                                echo '<button class="btn btn-danger btn-block"><b>Status Unknown</b></button>';
                            }else{
                                echo '<button class="btn btn-danger btn-block"><b>Status REJECTED</b></button>';
                            }
                        }else{
                            echo '<button class="btn btn-success btn-block"><b>Status FINISH</b></button>';
                        }
                    }else{
                      echo '<button class="btn btn-warning btn-block"><b>Status PENDING</b></button>';
                      if($order->receipt_of_payment == null){
                        echo '<div class="m-1 input-group">
                                <div class="custom-file">
                                <input type="file" id="file" class="custom-file-input">
                                <label class="custom-file-label" for="exampleInputFile">Choose file receipt</label>
                                </div>
                            </div>
                            <button id="but_upload" class="m-1 btn btn-secondary btn-block"><b>Upload receipt of payment</b></button>';
                      } 
                    }
                }else{
                    echo '<button class="m-1 btn btn-primary btn-block"><b>Status OPEN</b></button>';
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
                  <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">PIN Register</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  
                  <div class="active tab-pane" id="settings">
                      <div class="form-group row">
                    <?php if($pin['status']){ ?>
                    <?php $i = 0; ?>
                    <?php foreach($pin['data'] as $data){ ?>

                        <label for="inputName" class="col-sm-2 col-form-label">PIN <?php echo $i + 1 ?></label>
                        <div class="col-sm-10">
                          <strong><?php echo $data->pin ?></strong>
                          <?php if($data->is_active){$status='<strong style="color:green;">ACTIVE</strong>';}else{$status='<strong style="color: red;">NOT ACTIVE</strong>';} ?>
                          <p>Status : <?php echo $status ?></p>
                        </div>

                    <?php $i++; 
                        } ?>
                    <?php }else{ ?>
                        <strong>PIN not registered by admin</strong>
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