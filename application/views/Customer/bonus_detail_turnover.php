  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">All Bonuses</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section>
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-4 col-4">
            <div class="small-box" style="background-color:#9c743e;">
              <div class="inner">
                <h3 class="text-light" id="amount"><?php echo count($gold) ?></h3>
                <p class="text-light">GOLD</p>
              </div>

              <!-- <a class="small-box-footer"></a><i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
          </div>
          <div class="col-lg-4 col-4">
            <div class="small-box" style="background-color:#9c743e;">
              <div class="inner">
                <h3 class="text-light" id="amount"><?php echo count($onyx) ?></h3>
                <p class="text-light">ONYK</p>
              </div>

              <!-- <a class="small-box-footer"></a><i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
          </div>
          <div class="col-lg-4 col-4">
            <div class="small-box" style="background-color:#9c743e;">
              <div class="inner">
                <h3 class="text-light" id="amount"><?php echo count($diamond) ?></h3>
                <p class="text-light">DIAMOND</p>
              </div>

              <!-- <a class="small-box-footer"></a><i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
          </div>
        </div>
      </div>
    </section>
    <p hidden id='link'>datatable/get_bonus_turnover/<?php echo $id_and_position ?></p>
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">All bonuses of <?php echo $position_turnover ?></h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body table-responsive">
        <table id="table" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Name</th>
              <th>Bonus Date</th>
              <th>Position</th>
              <th>Licence Name</th>
              <th>Licence Price (USDT)</th>
              <th>Percentage Bonus (%)</th>
              <th>Bonus (USDT)</th>
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
        table.column(6).visible(false);
        table.column(5).visible(false);
      });
    </script>