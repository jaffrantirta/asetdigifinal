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
  <p hidden id='link'>datatable/get_pairing/<?php echo $session['data']->id ?></p>
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Reward</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive">
      <div class="container">
        <div class="row">
          <div class="col-12">
             
              <a class="btn btn-sm mb-3 btn-warning text-light" href="<?php echo base_url('admin/add_reward') ?>">Add Reward</a>
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