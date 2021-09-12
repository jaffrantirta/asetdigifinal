  <!-- Content Wrapper. Contains page content -->
                    <?php
                      foreach($lisensies as $data){?>
                        <p hidden id="lisensi_<?php echo $data->id ?>"><?php echo $data->price ?></p>
                      <?php 
                      } ?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Buy LISENSI</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="container">
    <div class="card card-warning">
      <div class="card-header">
        <h3 class="card-title">How to buy ?</h3>
      </div>
      <div class="card-body">
        <p><?php echo $how_to_buy ?></p>
      </div>
    </div>
    <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">LISENSI</h3>
              </div>
              <div class="card-body">


                <div class="form-group">
                  <label>Lisensi</label><br>
                  <div class="input-group">
                    <select onchange="count()" required name="lisensi" id="lisensi" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;">
                    <option value="not_select_yet">- choose Lisensi -</option>
                    <?php
                      foreach($lisensies as $data){?>
                        <option value="<?php echo $data->id ?>"><?php echo $data->name ?> - <?php echo $data->price ?> <?php echo $lisensi_currency ?></option>
                      <?php 
                      } ?>
                  </select>
                  </div>
                </div>

                <div class="form-group">
                  <label>Total payment</label><br>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-newspaper"></i></span>
                    </div>
                    <input disabled id="total_payment" type="text" class="form-control">
                    <div class="input-group-append" data-target="#reservationdatetime" data-toggle="datetimepicker">
                        <div class="input-group-text"><?php echo $lisensi_currency ?></div>
                        <input type="hidden" id="currency" value="<?php echo $lisensi_currency ?>">
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label>Secure PIN</label><br>
                  <small id="msg_title" hidden style="color: red">PIN is wrong</small>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-newspaper"></i></span>
                    </div>
                    <input id="secure_pin" type="password" class="form-control" placeholder="enter your secure PIN ..">
                  </div>
                </div>

                <div class="form-group">
                  <label>Upload Receipt of Payment</label><br>
                    <div class="m-1 input-group">
                      <div class="custom-file">
                        <input type="file" id="file" class="custom-file-input">
                        <label id="file_name_view" class="custom-file-label" for="exampleInputFile">Choose file receipt</label>
                      </div>
                    </div>
                </div>

                <div class="form-group">
                  <button class="col-12 col-md-6 btn btn-primary"onclick="create_order()">Submit</button>
                </div>
              </div>
            </div>
          </div>

          <script src="<?php echo base_url() ?>assets/build/js/customer/BuyLisensi.js"></script>
  
                      
    