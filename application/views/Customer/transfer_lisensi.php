  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Transfer Lisensi</h1>
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
                <h3 class="card-title">Transfer Lisensi</h3>
              </div>
              <div class="card-body">

                <h4>You have <b><?php echo count($get_lisensies) ?></b> Lisensi</h4>

                <div class="form-group">
                  <label>Lisensi</label><br>
                  <div class="input-group">
                    <select required name="lisensi" id="lisensi" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;">
                    <option value="not_select_yet">- choose Lisensi -</option>
                    <?php
                      foreach($get_lisensies as $data){?>
                        <option value="<?php echo $data->id ?>"><?php echo $data->lisensi_name ?></option>
                      <?php 
                      } ?>
                  </select>
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

          <script src="<?php echo base_url() ?>assets/build/js/customer/TransferLisensi.js"></script>
  
                      
    