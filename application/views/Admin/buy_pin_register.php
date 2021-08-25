  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Buy PIN Register</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="container">
    <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">PIN Register</h3>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label>Amount PIN Register</label><br>
                  <small id="msg_title" hidden style="color: red">amount can't empty or 0</small>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-newspaper"></i></span>
                    </div>
                    <input autocomplete="off" oninput="count()" id="amount" type="number" class="form-control" placeholder="enter amount PIN ..">
                  </div>
                </div>

                <div class="form-group">
                  <label>Price</label><br>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-newspaper"></i></span>
                    </div>
                    <input disabled id="price" type="number" class="form-control" value="<?php echo $price ?>">
                    <div class="input-group-append" data-target="#reservationdatetime" data-toggle="datetimepicker">
                        <div class="input-group-text"><?php echo $currency ?></div>
                        <input type="hidden" id="currency" value="<?php echo $currency ?>">
                    </div>
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
                        <div class="input-group-text"><?php echo $currency ?></div>
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
                  <button class="col-12 col-md-6 btn btn-primary"onclick="create_order()">Submit</button>
                </div>
              </div>
            </div>
          </div>

          <script src="<?php echo base_url() ?>assets/build/js/customer/BuyPinRegister.js"></script>
  
                      
    