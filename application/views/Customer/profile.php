  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
          <div class="container-fluid">
              <div class="row mb-2">
                  <div class="col-sm-6">
                      <h1 class="m-0">profile</h1>
                  </div><!-- /.col -->
                  <div class="col-sm-6">
                  </div><!-- /.col -->
              </div><!-- /.row -->
          </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->
      <section class="content">
          <div class="container-fluid">
              <div class="row">
                  <div class="col-md-3">

                      <!-- Profile Image -->
                      <div class="card card-primary card-outline">
                          <div class="card-body box-profile">
                              <div class="text-center">
                                  <img class="profile-user-img img-fluid img-circle" src="">
                              </div>

                              <h3 class="profile-username text-center"></h3>
                              <p class="text-muted text-center"><?php echo $session['data']->username; ?> | <?php echo $session['data']->email; ?></p>


                          </div>
                          <!-- /.card-body -->
                      </div>
                      <!-- /.card -->

                  </div>
                  <!-- /.col -->
                  <div class="col-md-9">
                      <div class="card">
                          <div class="card-header p-2">
                              <ul class="nav nav-pills">
                                  <li class="nav-item mr-1"><a class="nav-link profil active" href="#profile" data-toggle="tab">Profil</a></li>
                                  <li class="nav-item ml-1"><a class="nav-link logout btn btn-danger btn-sm text-white font-weight-bold" href="<?php echo site_url('auth/logout'); ?>">Log Out</a></li>
                              </ul>
                          </div><!-- /.card-header -->
                          <div class="card-body">
                              <div class="tab-content">
                                  <div class="active tab-pane" id="profile">
                                      <?php echo form_open_multipart('profile/update '); ?>
                                      <input type="hidden" class="form-control" id="inputName" name="id" value="<?php echo $users->id; ?>" required>
                                      <div class="form-group row">
                                          <label for="inputName" class="col-sm-2 col-form-label">Nama:</label>
                                          <div class="col-sm-10">
                                              <input type="text" class="form-control" id="inputName" name="name" value="<?php echo set_value('name', $users->name); ?>" required>
                                          </div>
                                          <?php echo form_error('name', '<div class="text-danger font-weight-bold">', '</div>'); ?>
                                      </div>
                                      <div class="form-group row">
                                          <label for="inputUserName" class="col-sm-2 col-form-label">Username:</label>
                                          <div class="col-sm-10">
                                              <input type="text" class="form-control" disabled id="inputUserName" name="username" value="<?php echo set_value('username', $users->username); ?>" required>
                                          </div>
                                          <?php echo form_error('username', '<div class="text-danger font-weight-bold">', '</div>'); ?>
                                      </div>
                                      <div class="form-group row">
                                          <label for="inputEmail" class="col-sm-2 col-form-label">Email:</label>
                                          <div class="col-sm-10">
                                              <input type="email" class="form-control" id="inputEmail" name="email" value="<?php echo set_value('email', $users->email); ?>" required>
                                          </div>
                                          <?php echo form_error('email', '<div class="text-danger font-weight-bold">', '</div>'); ?>
                                      </div>
                                      <div class="form-group row">
                                          <label for="inputEmail" class="col-sm-2 col-form-label">USDT Wallet</label>
                                          <div class="col-sm-10">
                                              <input type="text" class="form-control" id="inputEmail" name="usdt_wallet" value="<?php echo set_value('usdt_wallet', $users->usdt_wallet); ?>" required>
                                          </div>
                                          
                                      </div>
                                      
                                      <div class="form-group row">
                                          <label for="inputPassword" class="col-sm-2 col-form-label">Password:</label>
                                          <div class="col-sm-10">
                                              <input type="password" disabled class="form-control" id="inputPassword" name="password" placeholder="(!!!Under Development!!!) Masukkan password baru untuk mengganti. Kosongkan jika tidak ingin mengganti">
                                          </div>
                                          <?php echo form_error('password', '<div class="text-danger font-weight-bold">', '</div>'); ?>
                                      </div>
                                      <div class="form-group row">
                                          <label for="inputPassword" class="col-sm-2 col-form-label">Secure pin:</label>
                                          <div class="col-sm-10">
                                              <input type="password" disabled class="form-control" id="inputPassword" name="secure_pin" placeholder="(!!!Under Development!!!)Masukkan pin baru untuk mengganti. Kosongkan jika tidak ingin mengganti">
                                          </div>
                                          <?php echo form_error('password', '<div class="text-danger font-weight-bold">', '</div>'); ?>
                                      </div>


                                      <div class="form-group row">
                                          <label for="inputFoto" class="col-sm-2 col-form-label">Foto profil:</label>
                                          <div class="col-sm-10">
                                              <input type="file" class="form-control" id="inputFoto" name="file"> <p class="text-danger">Under Development</p>
                                          </div>
                                          <?php echo form_error('name', '<div class="text-danger font-weight-bold">', '</div>'); ?>
                                      </div>
                                      <div class="form-group row">
                                          <div class="offset-sm-2 col-sm-10">
                                              <button type="submit" class="btn btn-danger">update</button>
                                          </div>
                                      </div>
                                      <?php echo form_close(); ?>
                                  </div>

                                  <!-- /.tab-pane -->
                              </div>
                              <!-- /.tab-content -->
                          </div><!-- /.card-body -->
                      </div>
                      <!-- /.nav-tabs-custom -->
                  </div>
                  <!-- /.col -->
              </div>
              <!-- /.row -->
          </div><!-- /.container-fluid -->
      </section>

  </div>