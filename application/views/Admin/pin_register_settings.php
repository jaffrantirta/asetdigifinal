  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">PIN Register Settings</h1>
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
                <h3 class="card-title">PIN Register Settings</h3>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label>Price</label><br>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-newspaper"></i></span>
                    </div>
                    <input autocomplete="off" id="price" type="number" class="form-control" placeholder="enter price .." value="<?php echo $price ?>">
                  </div>
                </div>

                <div class="form-group">
                  <label>Currency</label><br>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-newspaper"></i></span>
                    </div>
                    <input autocomplete="off" id="currency" type="text" class="form-control" placeholder="enter currency .." value="<?php echo $currency ?>">
                  </div>
                </div>

                <div class="form-group">
                  <button class="col-12 col-md-4 btn btn-primary"onclick="update_pin_register_settings()">Submit</button>
                </div>
              </div>
            </div>
          </div>
  
                      
    