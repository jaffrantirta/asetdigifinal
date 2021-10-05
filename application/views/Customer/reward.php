<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Reward</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
  <p hidden id='link'>datatable/get_reward</p>
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Reward</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Reward List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <table id="table" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Reward</th>
                      <th>Left (Diamond)</th>
                      <th>Right (diamond)</th>
                      <th>Achievement</th>
                      <th>Reward bonuses</th>
                      <th>Take Reward</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.card-body -->
  </div>
  <script src="<?php echo base_url() ?>assets/build/js/customer/Jquery3Offline.js"></script>
    <script>
      $(document).ready(function() {
        var link = document.getElementById('base_url').innerHTML + document.getElementById('link').innerHTML;
        console.log(link);
        table = $('#table').DataTable({
          "responsive": true,
          "processing": true,
          "serverSide": true,
          "ajax": link,
          "bSort": true,
          "bPaginate": true,
          "iDisplayLength": 10,
          "order": [
            [1, "desc"]
          ],
          "language": {
            "searchPlaceholder": "Search...",
            "search": ""
          },
          "fnInitComplete": function(oSettings, json) {
            $('#table_filter :input').addClass('form-control').css({
              'width': '10em'
            });
          }
        });
        table.column(5).visible(false);
      });
    </script>