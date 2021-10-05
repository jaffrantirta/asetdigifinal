<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Add Reward</h1>
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
                <h3 class="card-title">Reward</h3>
            </div>
            <div class="card-body">

            <form action="<?php echo base_url('admin/add_reward_process') ?>" method="post">
            <div class="form-group">
                    <label>Reward Name</label><br>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-newspaper"></i></span>
                        </div>
                        <input name="name" type="text" placeholder="reward name" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label>Left</label><br>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-newspaper"></i></span>
                        </div>
                        <input name="left" type="text" placeholder="amount left" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label>Right</label><br>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-newspaper"></i></span>
                        </div>
                        <input name="right" type="text" placeholder="amount Right" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label>Reward Bonus</label><br>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-newspaper"></i></span>
                        </div>
                        <input name="bonus" type="text" placeholder="Reward Bonus" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <button class="col-12 col-md-4 btn btn-danger">Submit</button>
                </div>

            </form>

            </div>
        </div>
    </div>