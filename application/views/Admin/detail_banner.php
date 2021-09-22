<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Detail Banner</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
              <div class="text-center">
                    <?php
                        if (file_exists(base_url('assets/img-banner/'.$banner[0]->picture))) {
                            $thumb = base_url('upload/no_image/no_image.png');
                        }else{
                            $thumb = base_url('assets/img-banner/'.$banner[0]->picture);
                        }
                    ?>
                  <img class="img-fluid"
                       src="<?php echo $thumb ?>"
                       alt="User profile picture">
                </div>
                

                <!-- <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                    <b>Update</b> <a class="float-right"><?php //echo $banner->picture ?></a>
                    <input Type="file" id="usdt_wallet" class="float-right" value="<?php //echo $member->usdt_wallet ?>">
                  </li>
                </ul> -->
               
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