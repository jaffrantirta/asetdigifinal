  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">All Members</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <p hidden id='link'>datatable/get_all_members</p><a href="" class="btn btn-success">export member</a>
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">All members registered are <?php echo $members_count ?></h3>
      </div>

      <!-- /.card-header -->
      <div class="card-body table-responsive">
        <table id="table" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Name</th>
              <th>Register Date</th>
              <th>Sponsor Code</th>
              <th>Sponsor Code Bonus</th>
              <th>
                <p class="text-danger">Under Development</p>
              </th>
              <th>
                <p class="text-danger">Under Development</p>
              </th>
              <th>Licence</th>
              <th>id</th>
              <th>Action</th>
              <th>id</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
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
        table.column(7).visible(false);
        table.column(9).visible(false);
      });

      function deactivate(id) {
        var vID = id
        Swal.fire({
          title: 'Do you want to deactivate this member ?',
          showDenyButton: true,
          showCancelButton: true,
          showConfirmButton: false,
          denyButtonText: `Deactivate`,
        }).then((result) => {
          if (result.isDenied) {
            window.location.replace(document.getElementById('base_url').innerHTML + 'admin/delete_member/' + vID);
          }
        })
      }
    </script>
  