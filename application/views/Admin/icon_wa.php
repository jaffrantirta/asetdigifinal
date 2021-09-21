<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Vidio Tutorial</h1>
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
                <h3 class="card-title">ICON Whatsapp</h3>
              </div>
              <div class="card-body">
               
                <div class="form-group">
                  <label>Icon Wa</label><br>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-newspaper"></i></span>
                    </div>
                    <input id="fd" type="file" placeholder=""  class="form-control" >
                  </div>
                </div>
                <div class="form-group">
                  <button class="col-12 col-md-4 btn btn-danger"onclick="upload_process()">Submit</button>
                </div>
               
              </div>
            </div>
          </div>
          
  <script>
      function upload_process() {
          var fd = new FormData();
          var files = $('#file')[0].files;
          fd.append('file', files[0]);
          $.ajax({
              url: document.getElementById('base_url').innerHTML + 'api/update_icon_wa',
              type: 'post',
              data: fd,
              contentType: false,
              processData: false,
              success: function(response) {
                  if (response != 0) {
                      show_message('success', 'Updated', '');
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