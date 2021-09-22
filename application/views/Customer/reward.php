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
            <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <img width="1140" height="300" src="<?php echo base_url('assets/img-banner/' . $banner[0]->picture) ?>" class="img-fluid d-block w-100 rounded-lg" alt="...">
                </div>
                <?php for ($i = 1; $i < count($banner); $i++) { ?>
                  <div class="carousel-item">
                    <img width="1140" height="300" src="<?php echo base_url('assets/img-banner/' . $banner[$i]->picture) ?>" class="img-fluid d-block w-100 rounded-lg" alt="...">
                  </div>
                <?php } ?>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.card-body -->
  </div>