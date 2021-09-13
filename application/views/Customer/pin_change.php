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
                                  <li class="nav-item mr-1"><a class="nav-link btn btn-warning profile" href="" data-toggle="tab">Profil</a></li>
                                  <li class="nav-item mr-1"><a class="nav-link btn btn-success" href="" data-toggle="tab">Change Password</a></li>
                                  <li class="nav-item mr-1"><a class="nav-link btn btn-info" href="" data-toggle="tab">Change Pin</a></li>
                                  <li class="nav-item mr-1"><a class="nav-link btn btn-primary" href="" data-toggle="tab">Profile Image</a></li>
                                  <li class="nav-item ml-1"><a class="nav-link logout btn btn-danger btn-sm text-white font-weight-bold" href="<?php echo site_url('auth/logout'); ?>">Log Out</a></li>
                              </ul>
                          </div><!-- /.card-header -->
                          <div class="card-body">
                              <div class="tab-content">
                                  <div class="active tab-pane" id="profile">

                                      <input type="hidden" class="form-control" id="inputName" name="id" value="" required>
                                      <div class="form-group row">
                                          <label for="inputName" class="col-sm-2 col-form-label">Old Pin</label>
                                          <div class="col-sm-10">
                                              <input type="text" class="form-control" id="old_pin" value="" required>
                                          </div>

                                      </div>
                                      <div class="form-group row">
                                          <label for="inputUserName" class="col-sm-2 col-form-label">New Pin</label>
                                          <div class="col-sm-10">
                                              <input type="text" class="form-control" disabled id="new_pin_confirm" value="" required>
                                          </div>

                                      </div>
                                     

                                  </div>
                                  <div class="form-group row">
                                      <div class="offset-sm-2 col-sm-10">
                                          <button type="submit" class="btn btn-danger">update</button>
                                      </div>
                                  </div>

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