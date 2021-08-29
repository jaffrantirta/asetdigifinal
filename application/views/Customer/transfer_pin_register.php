  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Transfer PIN Register</h1>
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
                <h3 class="card-title">Transfer PIN Register</h3>
              </div>
              <div class="card-body">

                <h4>You have <b><?php echo $get_pins ?></b> active PINs</h4>

                <div class="form-group">
                  <label>Amount Transfer</label><br>
                  <small id="msg_title" hidden style="color: red">amount can't empty or 0</small>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-newspaper"></i></span>
                    </div>
                    <input autocomplete="off" id="amount_transfer" type="number" class="form-control" placeholder="enter amount transfer ..">
                  </div>
                </div>

                <div class="form-group">
                  <label>Recipient Username</label><br>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-newspaper"></i></span>
                    </div>
                    <input autocomplete="off" id="recipient_username" type="text" class="form-control" placeholder="enter recipient username ..">
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
                  <button class="col-12 col-md-6 btn btn-primary"onclick="create_transfer()">Submit</button>
                </div>
              </div>
            </div>
          </div>

          <script src="<?php echo base_url() ?>assets/build/js/customer/TransferPIN.js"></script>
  
                      
    