<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

<div class="col-12">
            <div class="card card-primary">
              <div class="card-header">
                <h4 class="card-title">Galleries</h4>
              </div>
              <div class="card-body">
                <div class="row">

                <?php foreach($banner as $X){ ?>
                  <div class="col-sm-4">
                    <a href="<?php echo base_url('assets/img-banner/'.$X->picture) ?>" data-toggle="lightbox" data-title="sample 1 - white" data-gallery="gallery">
                      <img src="<?php echo base_url('assets/img-banner/'.$X->picture) ?>" class="img-fluid mb-2" alt="white sample"/>
                    </a>
                  </div>
                <?php } ?>

                </div>
              </div>
            </div>
          </div>

</div>