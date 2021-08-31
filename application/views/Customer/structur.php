  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Structur</h1>
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
                <h3 class="card-title">Structur</h3>
              </div>
              <div class="card-body">


              <div class="tree">
                <ul>
                    <li><a class='link' href='#'><br> <img style='width:50px; border-radius:40px' src='<?php echo base_url('upload/no_image/profile.gif') ?>'><br><?php if($parent_1['data']!=null){echo $parent_1['data']->name;}else{echo 'empty';} ?></a>
                        <ul>
                            <li>
                                <a class='link' href='<?php if($parent_1['left']!=null){echo base_url('customer/structur/'.$parent_1['left']->bottom);}else{echo base_url('customer/register?top='.$parent_1['data']->id.'&position=1');} ?>'><br> <img style='width:50px; border-radius:40px' src='<?php echo base_url('upload/no_image/profile.gif') ?>'><br><?php if($parent_1['left']!=null){echo $parent_1['left']->bottom_name;}else{echo 'empty';} ?></a>
                                <ul>
                                    <li>
                                        <a class='link' href="<?php if($parent_2['left']!=null){echo base_url('customer/structur/'.$parent_2['left']->bottom);}else{if($parent_2['data']==null){echo '#';}else{echo base_url('customer/register?top='.$parent_2['data']->id.'&position=1');}} ?>"><br> <img style='width:50px; border-radius:40px' src='<?php echo base_url('upload/no_image/profile.gif') ?>'><br><?php if($parent_2['left']!=null){echo $parent_2['left']->bottom_name;}else{echo 'empty';} ?></a>
                                        <ul>
                                            <li>
                                                <a class='link' href="<?php if($parent_4['left']!=null){echo base_url('customer/structur/'.$parent_4['left']->bottom);}else{if($parent_4['data']==null){echo '#';}else{echo base_url('customer/register?top='.$parent_4['data']->id.'&position=1');}} ?>"><br> <img style='width:50px; border-radius:40px' src='<?php echo base_url('upload/no_image/profile.gif') ?>'><br><?php if($parent_4['left']!=null){echo $parent_4['left']->bottom_name;}else{echo 'empty';} ?></a>
                                            </li>
                                            <li>
                                                <a class='link' href="<?php if($parent_4['right']!=null){echo base_url('customer/structur/'.$parent_4['right']->bottom);}else{if($parent_4['data']==null){echo '#';}else{echo base_url('customer/register?top='.$parent_4['data']->id.'&position=2');}} ?>"><br> <img style='width:50px; border-radius:40px' src='<?php echo base_url('upload/no_image/profile.gif') ?>'><br><?php if($parent_4['right']!=null){echo $parent_4['right']->bottom_name;}else{echo 'empty';} ?></a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a class='link' href="<?php if($parent_2['right']!=null){echo base_url('customer/structur/'.$parent_2['right']->bottom);}else{if($parent_2['data']==null){echo '#';}else{echo base_url('customer/register?top='.$parent_2['data']->id.'&position=2');}} ?>"><br> <img style='width:50px; border-radius:40px' src='<?php echo base_url('upload/no_image/profile.gif') ?>'><br><?php if($parent_2['right']!=null){echo $parent_2['right']->bottom_name;}else{echo 'empty';} ?></a>
                                        <ul>
                                            <li>
                                                <a class='link' href="<?php if($parent_5['left']!=null){echo base_url('customer/structur/'.$parent_5['left']->bottom);}else{if($parent_5['data']==null){echo '#';}else{echo base_url('customer/register?top='.$parent_5['data']->id.'&position=1');}} ?>"><br> <img style='width:50px; border-radius:40px' src='<?php echo base_url('upload/no_image/profile.gif') ?>'><br><?php if($parent_5['left']!=null){echo $parent_5['left']->bottom_name;}else{echo 'empty';} ?></a>
                                            </li>
                                            <li>
                                                <a class='link' href="<?php if($parent_5['right']!=null){echo base_url('customer/structur/'.$parent_5['right']->bottom);}else{if($parent_5['data']==null){echo '#';}else{echo base_url('customer/register?top='.$parent_5['data']->id.'&position=2');}} ?>"><br> <img style='width:50px; border-radius:40px' src='<?php echo base_url('upload/no_image/profile.gif') ?>'><br><?php if($parent_5['right']!=null){echo $parent_5['right']->bottom_name;}else{echo 'empty';} ?></a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            
                            <li>
                                <a class='link' href='<?php if($parent_1['right']!=null){echo base_url('customer/structur/'.$parent_1['right']->bottom);}else{echo base_url('customer/register?top='.$parent_1['data']->id.'&position=2');} ?>'><br> <img style='width:50px; border-radius:40px' src='<?php echo base_url('upload/no_image/profile.gif') ?>'><br><?php if($parent_1['right']!=null){echo $parent_1['right']->bottom_name;}else{echo 'empty';} ?></a>
                                <ul>
                                    <li>
                                        <a class='link' href="<?php if($parent_3['left']!=null){echo base_url('customer/structur/'.$parent_3['left']->bottom);}else{if($parent_3['data']==null){echo '#';}else{echo base_url('customer/register?top='.$parent_3['data']->id.'&position=1');}} ?>"><br> <img style='width:50px; border-radius:40px' src='<?php echo base_url('upload/no_image/profile.gif') ?>'><br><?php if($parent_3['left']!=null){echo $parent_3['left']->bottom_name;}else{echo 'empty';} ?></a>
                                        <ul>
                                            <li>
                                                <a class='link' href="<?php if($parent_6['left']!=null){echo base_url('customer/structur/'.$parent_6['left']->bottom);}else{if($parent_6['data']==null){echo '#';}else{echo base_url('customer/register?top='.$parent_6['data']->id.'&position=1');}} ?>"><br> <img style='width:50px; border-radius:40px' src='<?php echo base_url('upload/no_image/profile.gif') ?>'><br><?php if($parent_6['left']!=null){echo $parent_6['left']->bottom_name;}else{echo 'empty';} ?></a>
                                            </li>
                                            <li>
                                                <a class='link' href="<?php if($parent_6['right']!=null){echo base_url('customer/structur/'.$parent_6['right']->bottom);}else{if($parent_6['data']==null){echo '#';}else{echo base_url('customer/register?top='.$parent_6['data']->id.'&position=2');}} ?>"><br> <img style='width:50px; border-radius:40px' src='<?php echo base_url('upload/no_image/profile.gif') ?>'><br><?php if($parent_6['right']!=null){echo $parent_6['right']->bottom_name;}else{echo 'empty';} ?></a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a class='link' href="<?php if($parent_3['right']!=null){echo base_url('customer/structur/'.$parent_3['right']->bottom);}else{if($parent_3['data']==null){echo '#';}else{echo base_url('customer/register?top='.$parent_3['data']->id.'&position=2');}} ?>"><br> <img style='width:50px; border-radius:40px' src='<?php echo base_url('upload/no_image/profile.gif') ?>'><br><?php if($parent_3['right']!=null){echo $parent_3['right']->bottom_name;}else{echo 'empty';} ?></a>
                                        <ul>
                                            <li>
                                                <a class='link' href="<?php if($parent_7['left']!=null){echo base_url('customer/structur/'.$parent_7['left']->bottom);}else{if($parent_7['data']==null){echo '#';}else{echo base_url('customer/register?top='.$parent_7['data']->id.'&position=1');}} ?>"><br> <img style='width:50px; border-radius:40px' src='<?php echo base_url('upload/no_image/profile.gif') ?>'><br><?php if($parent_7['left']!=null){echo $parent_7['left']->bottom_name;}else{echo 'empty';} ?></a>
                                            </li>
                                            <li>
                                                <a class='link' href="<?php if($parent_7['right']!=null){echo base_url('customer/structur/'.$parent_7['right']->bottom);}else{if($parent_7['data']==null){echo '#';}else{echo base_url('customer/register?top='.$parent_7['data']->id.'&position=2');}} ?>"><br> <img style='width:50px; border-radius:40px' src='<?php echo base_url('upload/no_image/profile.gif') ?>'><br><?php if($parent_7['right']!=null){echo $parent_7['right']->bottom_name;}else{echo 'empty';} ?></a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>  


              </div>
            </div>
          </div>

          <script src="<?php echo base_url() ?>assets/build/js/customer/BuyLisensi.js"></script>
  
                      
    