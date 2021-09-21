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
                <h3 class="card-title">Vidio</h3>
              </div>
              <div class="card-body">
               
                <div class="form-group">
                  <label>vidio tutorial</label><br>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-newspaper"></i></span>
                    </div>
                    <input id="link1" type="text" placeholder="link youtube"  class="form-control" >
                  </div>
                </div>
                <div class="form-group">
                  <button class="col-12 col-md-4 btn btn-danger"onclick="request()">Submit</button>
                </div>
               
              </div>
            </div>
          </div>
          <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
      function request() {
          var id = document.getElementById('id').innerHTML;
          var base_url = document.getElementById('base_url').innerHTML;
          var link1 = document.getElementById('link1').value;

          $.ajax({
              url: base_url + "api/update_video_tutorial",
              type: "post",
              data: {
                  'id': id,
                  'link1': link1,
              },
              success: function(result) {
                  $('.loader').attr('hidden', true);
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