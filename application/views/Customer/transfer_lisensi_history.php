<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Transfer Lisensi History</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          
          <div class="col-md-12">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#transfered" data-toggle="tab">Transfered</a></li>
                  <li class="nav-item"><a class="nav-link" href="#received" data-toggle="tab">Received</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  
                  <!-- <div class="active tab-pane" id="transfered">
                      <div class="form-group row"> -->
                        <p hidden id='link_transfer'>datatable/get_transfer_history/<?php echo $session['data']->id ?></p>
                        <div class="card active tab-pane" id="transfered">
                            <div class="card-header">
                                <h3 class="card-title">Lisensi Transfered</h3>
                            </div>
                            <div class="card-body table-responsive">
                                <table id="table_transfer" class="table_transfer table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Transfer Number</th>
                                            <th>Transfer Date</th>
                                            <th>Receiver Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                      <!-- </div>
                  </div> -->

                  <!-- <div class="tab-pane" id="received">
                      <div class="form-group row"> -->
                        <p hidden id='link_receive'>datatable/get_receive_history/<?php echo $session['data']->id ?></p>
                        <div class="card tab-pane" id="received">
                            <div class="card-header">
                                <h3 class="card-title">Lisensi Received</h3>
                            </div>
                            <div class="card-body table-responsive">
                                <table id="table_receive" class="table_receive table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Transfer Number</th>
                                            <th>Transfer Date</th>
                                            <th>Sender Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                      <!-- </div>
                  </div> -->


                  <!-- /.tab-pane -->
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
  <script src="<?php echo base_url() ?>assets/build/js/customer/Jquery3Offline.js"></script>
  <script src="<?php echo base_url() ?>assets/build/js/customer/SweetAlertOffline.js"></script>

  <script>
    $(document).ready(function() {
        var link_transfer = document.getElementById('base_url').innerHTML + document.getElementById('link_transfer').innerHTML;
        var link_receive = document.getElementById('base_url').innerHTML + document.getElementById('link_receive').innerHTML;

        table_transfer = $('#table_transfer').DataTable({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": link_transfer,
            "bSort":true,
            "bPaginate": true,
            "iDisplayLength": 10,
            "order": [[ 1, "desc" ]],
            "language": {
                "searchPlaceholder": "Search...",
                "search":""
            },
            "fnInitComplete": function(oSettings, json) {
                $('#table_transfer_filter :input').addClass('form-control').css({'width':'10em'});
            }
        });

        table_receive = $('#table_receive').DataTable({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": link_receive,
            "bSort":true,
            "bPaginate": true,
            "iDisplayLength": 10,
            "order": [[ 1, "desc" ]],
            "language": {
                "searchPlaceholder": "Search...",
                "search":""
            },
            "fnInitComplete": function(oSettings, json) {
                $('#table_receive_filter :input').addClass('form-control').css({'width':'10em'});
            }
        });
    });
</script>