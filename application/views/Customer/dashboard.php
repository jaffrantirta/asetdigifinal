  <!-- Content Wrapper. Contains page content -->
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
    <!-- /.content-header -->

    <section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">

          <div class="col-lg-4 col-12">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $bonus_sponsor_code ?> USDT</h3>
                <p>Bonus Sponsor Code</p>
              </div>
              <div class="icon">
                <i class="fas fa-money-bill-wave"></i>
              </div>
              <?php
                $customer = base64_encode('customer');
                $hash = base64_encode($session['data']->id.'/'.$sponsor_code);
                $route = "bonus/sponsor_code/$customer?token=$hash";
                $url = base_url($route);
              ?>
              <a href="<?php echo $url ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $turnover_left_bonus ?> USDT</h3>
                <p>Bonus Left Turnover <strong style="color:red">UNDER DEVELOPMENT</strong></p>
              </div>
              <div class="icon">
                <i class="fas fa-money-bill-wave"></i>
              </div>
              <?php
                $customer = base64_encode('customer');
                $id_and_position = base64_encode($session['data']->id.'/1');
                $hash = base64_encode($id_and_position.'////LEFT');
                $route = "bonus/turnover/$customer?token=$hash";
                $url = base_url($route);
              ?>
              <a href="<?php echo $url ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $turnover_right_bonus ?> USDT</h3>
                <p>Bonus Right Turnover <strong style="color:red">UNDER DEVELOPMENT</strong></p>
              </div>
              <div class="icon">
                <i class="fas fa-money-bill-wave"></i>
              </div>
              <?php
                $customer = base64_encode('customer');
                $id_and_position = base64_encode($session['data']->id.'/2');
                $hash = base64_encode($id_and_position.'////RIGHT');
                $route = "bonus/turnover/$customer?token=$hash";
                $url = base_url($route);
              ?>
              <a href="<?php echo $url ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

        </div>

        <div class="row">
          <!-- ./col -->
          <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $turnovers_left ?> USDT</h3>
                <p>Your Left Turnover</p>
              </div>
              <div class="icon">
                <i class="fas fa-money-bill-alt"></i>
              </div>
              <!-- <a class="small-box-footer"></a><i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
          </div>

          <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $turnovers_right ?> USDT</h3>
                <p>Your Right Turnover</p>
              </div>
              <div class="icon">
                <i class="fas fa-money-bill-alt"></i>
              </div>
              <!-- <a class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
          </div>
          <!-- ./col -->
         
        </div>

        <div class="row">
          <div class="col-lg-4 col-12">
            <!-- small box -->
            <div class="small-box bg-dark">
              <div class="inner">
                <h3><?php echo $sponsor_code ?></h3>
                <p>Your Sponsor Code</p>
              </div>
              <div class="icon">
                <i class="fas fa-user"></i>
              </div>
              <!-- <a class="small-box-footer"></a><i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
          </div>
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-dark">
              <div class="inner">
                <h3><?php echo $sponsor_code_use ?></h3>
                <p>Your Sonsor Code Used</p>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
              <!-- <a class="small-box-footer"></a><i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
          </div>
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-dark">
              <div class="inner">
                <h3><?php echo $your_licence ?></h3>
                <p>Your Licence</p>
              </div>
              <div class="icon">
                <i class="fas fa-crown"></i>
              </div>
              <!-- <a class="small-box-footer"></a><i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
          </div>
        </div>

        <!-- <div class="row">

          <div class="col-md-4 card card-primary">
            <div class="card-header">
              <h3 class="card-title">Pengguna terdaftar berdasarkan pekerjaan</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <canvas id="chart_occupasion" width="100" height="100"></canvas>
            </div>
          </div>

        </div> -->


      
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
  </div>
