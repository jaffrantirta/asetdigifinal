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
                                if($session['data']->profile_picture == null){
                                    $thumb = base_url('upload/no_image/no_image.png');
                                }else{
                                    if (file_exists(base_url('upload/members/'.$session['data']->profile_picture))) {
                                        $thumb = base_url('upload/no_image/no_image.png');
                                    }else{
                                        $thumb = base_url('upload/members/'.$session['data']->profile_picture);
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
                                      <div class="form-group row">
                                          <label for="inputName" class="col-sm-2 col-form-label">Old Password</label>
                                          <div class="col-sm-10">
                                              <input type="password" class="form-control" id="old_password" value="" placeholder="input your old password" required>
                                          </div>

                                      </div>
                                      <div class="form-group row">
                                          <label for="inputName" class="col-sm-2 col-form-label">Password</label>
                                          <div class="col-sm-10">
                                              <input type="password" class="form-control" id="password" value="" placeholder="input your new password" required>
                                          </div>

                                      </div>
                                      <div class="form-group row">
                                          <label for="inputUserName" class="col-sm-2 col-form-label">Password Confirm</label>
                                          <div class="col-sm-10">
                                              <input type="password" class="form-control" id="password_confirm" placeholder="input your confirm password must be same to new password" value="" required>
                                          </div>

                                      </div>


                                  </div>
                                  <div class="form-group row">
                                      <div class="offset-sm-2 col-sm-10">
                                          <button onclick="request()" type="submit" class="btn btn-danger">update</button>
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
      function request() {
          var id = document.getElementById('id').innerHTML;
          var base_url = document.getElementById('base_url').innerHTML;
          var old_password = document.getElementById('old_password').value;
          var password = document.getElementById('password').value;
          var password_confirm = document.getElementById('password_confirm').value;

          $.ajax({
              url: base_url + "api/change_password",
              type: "post",
              data: {
                  'id': id,
                  'old_password': old_password,
                  'password': password,
                  'password_confirm': password_confirm
              },
              success: function(result) {
                  $('.loader').attr('hidden', true);
                  console.log('data : ' + result);
                  var d = JSON.parse(result);
                  show_message('success', d.response.message['english'], '');
              },
              error: function(result, ajaxOptions, thrownError) {
                  $('.loader').attr('hidden', true);
                  // console.log('data : '+xhr.responseText);
                  show_message('error', 'Oops! sepertinya ada kesalahan', 'kesalahan tidak diketahui');
                  var string = JSON.stringify(result.responseText);
                  var msg = JSON.parse(result.responseText);
                  show_message('error', 'Oops! sepertinya ada kesalahan', msg.response.message['english']);
              }
          });
      }
  </script>