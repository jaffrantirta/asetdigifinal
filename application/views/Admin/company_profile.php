<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Company Profile</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                    <?php
                        if (file_exists(base_url('upload/company/'.$logo))) {
                            $thumb = base_url('upload/no_image/no_image.png');
                        }else{
                            $thumb = base_url('upload/company/'.$logo);
                        }
                    ?>
                  <img class="profile-user-img img-fluid img-circle"
                       src="<?php echo $thumb ?>"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><?php echo $sistem_name ?></h3>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Phone</b> <a class="float-right"><?php echo $phone_number ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Email</b> <a class="float-right"><?php echo $email  ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Address</b> <a class="float-right"><?php echo $address ?></a>
                  </li>
                </ul>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Edit Profile</a></li>
                  <li class="nav-item"><a class="nav-link" href="#change_photo" data-toggle="tab">Change Logo</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  

                  <div class="tab-pane" id="settings">
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Company Name</label>
                        <div class="col-sm-10">
                          <input type="hidden" name="id" value="<?php echo $logo ?>">
                          <input type="text" name="name" class="form-control" id="sistem_name" value="<?php echo $sistem_name ?>" placeholder="Masukan nama company ...">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                          <input type="email" name="email" class="form-control" id="email" value="<?php echo $email ?>" placeholder="Masukan email ...">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Phone</label>
                        <div class="col-sm-10">
                          <input type="number" name="phone" class="form-control" id="phone_number" value="<?php echo $phone_number ?>" placeholder="Masukan no. telepon ...">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputExperience" class="col-sm-2 col-form-label">Address</label>
                        <div class="col-sm-10">
                          <input type="text" name="transport_number" class="form-control" id="address" value="<?php echo $address ?>" placeholder="Masukan no. kendaraan ...">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button onclick="update_profile_company()" class="btn btn-danger">Save Changes</button>
                        </div>
                      </div>
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="change_photo">
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Choose Logo</label>
                        <div class="col-sm-10">
                          <input type="hidden" name="id" value="<?php echo $logo ?>">
                          <input type="hidden" name="old_photo" value="<?php echo $logo ?>">
                          <input Required type="file" id="file">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button onclick="change_logo()" class="btn btn-danger">Change Logo</button>
                        </div>
                      </div>
                  </div>


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