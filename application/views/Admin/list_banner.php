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
    <p hidden id='link'>datatable/get_all_members</p>
    <a href="<?php echo base_url("index.php/admin/export"); ?>" class="btn btn-success">export member</a>
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">All members registered are <?php echo $members_count ?></h3>
      </div>

      <!-- /.card-header -->
      <div class="card-body table-responsive">
        <a class="btn btn-primary" href="">add banner</a>
        <table id="table" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Name</th>
              <th>Picture</th>
              <th>Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
    </div>