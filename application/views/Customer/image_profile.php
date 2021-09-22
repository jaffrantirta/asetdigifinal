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
                      <div class="card card-warning card-outline">
                          <div class="card-body box-profile">
                          <div class="text-center">
                                <?php
                                if($user[0]->profile_picture == null){
                                    $thumb = base_url('upload/no_image/no_image.png');
                                }else{
                                    if (file_exists(base_url('upload/members/'.$user[0]->profile_picture))) {
                                        $thumb = base_url('upload/no_image/no_image.png');
                                    }else{
                                        $thumb = base_url('upload/members/'.$user[0]->profile_picture);
                                    }
                                }
                                ?>
                                <img class="profile-user-img img-fluid img-circle" src="<?php echo $thumb ?>"alt="User profile picture">
                            </div>

                              <h3 class="profile-username text-center"><?php echo $session['data']->name; ?></h3>
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
                              <li class="nav-item mr-1">
                              <?php $id = $session['data']->id ?>
                              <?php if ($page == 'Profile') { ?>
                                    <a href="<?php echo base_url('customer/profile/'. $id) ?>" class="nav-link active">
                                <?php } else { ?>
                                    <a href="<?php echo base_url('customer/profile/'. $id) ?>" class="nav-link">
                                <?php } ?>
                                    Profil
                                      
                                  </a>
                            </li>
                                  <li class="nav-item mr-1">
                                      <?php if ($page == 'Change Password') { ?>
                                          <a href="<?php echo base_url('customer/change_password') ?>" class="nav-link active">
                                          <?php } else { ?>
                                              <a href="<?php echo base_url('customer/change_password') ?>" class="nav-link">
                                              <?php } ?>
                                              Change Password</a>
                                  </li>
                                  <li class="nav-item mr-1"><?php if ($page == 'Change Pin') { ?>
                                          <a href="<?php echo base_url('customer/change_pin') ?>" class="nav-link active">
                                          <?php } else { ?>
                                              <a href="<?php echo base_url('customer/change_pin') ?>" class="nav-link">
                                                  <?php } ?>Change Pin</a>
                                  </li>
                                  <li class="nav-item mr-1">
                                      <?php if ($page == 'Upload Image') { ?>
                                          <a href="<?php echo base_url('customer/upload_image') ?>" class="nav-link active">
                                          <?php } else { ?>
                                              <a href="<?php echo base_url('customer/upload_image') ?>" class="nav-link">
                                                  <?php } ?>Profile Image</a>
                                  </li>
                                  </ul>
                          </div><!-- /.card-header -->
                          <div class="card-body">
                              <div class="tab-content">
                                  <div class="active tab-pane" id="profile">

                                      <input type="hidden" class="form-control" id="inputName" name="id" value="" required>

                                      <div class="form-group">
                                          <label>Upload Profile</label><br>
                                          <div class="m-1 input-group">
                                              <div class="custom-file">
                                              <input id="file" type="file" class="form-control" value="">
                                                  </div>
                                          </div>
                                      </div>

                                  </div>
                                  <div class="form-group row">
                                      <div class="offset-sm-2 col-sm-10">
                                          <button onclick="upload_process()" class="btn btn-danger">update</button>
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

  <script>
      function upload_process() {
          var fd = new FormData();
          var files = $('#file')[0].files;
          fd.append('file', files[0]);
          $.ajax({
              url: document.getElementById('base_url').innerHTML + 'api/update_profile_picture/' + <?php echo $session['data']->id ?>,
              type: 'post',
              data: fd,
              contentType: false,
              processData: false,
              success: function(response) {
                  if (response != 0) {
                      show_message('success', 'Updated', '');
                      location.reload();
                  } else {
                      Swal.fire(
                          'File failed to upload',
                          '',
                          'error'
                      )
                  }
              },
          });
      }
  </script>