<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $sistem_name ?> | <?php echo $page ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/summernote/summernote-bs4.min.css">
  <!-- loader -->
  <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/loader/loader.css') ?>" />
  <!-- swicth toggle -->
  <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/toggle.css') ?>" />
  <!-- lottie player -->
  <script src="<?php echo base_url('assets/build/js/lottie/LottiePlayer.js') ?>"></script>

  <style type="text/css">
    /*Now the CSS*/
    * {
      margin: 0;
      padding: 0;
    }

    .tree ul {
      padding-top: 20px;
      position: relative;

      transition: all 0.5s;
      -webkit-transition: all 0.5s;
      -moz-transition: all 0.5s;
    }

    .tree li {
      float: left;
      text-align: center;
      list-style-type: none;
      position: relative;
      padding: 20px 5px 0 5px;

      transition: all 0.5s;
      -webkit-transition: all 0.5s;
      -moz-transition: all 0.5s;
    }

    /*We will use ::before and ::after to draw the connectors*/
    .tree li::before,
    .tree li::after {
      content: '';
      position: absolute;
      top: 0;
      right: 50%;
      border-top: 1px solid #ccc;
      width: 50%;
      height: 20px;
    }

    .tree li::after {
      right: auto;
      left: 50%;
      border-left: 1px solid #ccc;
    }

    /*We need to remove left-right connectors from elements without 
    any siblings*/
    .tree li:only-child::after,
    .tree li:only-child::before {
      display: none;
    }

    /*Remove space from the top of single children*/
    .tree li:only-child {
      padding-top: 0;
    }

    /*Remove left connector from first child and 
    right connector from last child*/
    .tree li:first-child::before,
    .tree li:last-child::after {
      border: 0 none;
    }

    /*Adding back the vertical connector to the last nodes*/
    .tree li:last-child::before {
      border-right: 1px solid #ccc;
      border-radius: 0 5px 0 0;
      -webkit-border-radius: 0 5px 0 0;
      -moz-border-radius: 0 5px 0 0;
    }

    .tree li:first-child::after {
      border-radius: 5px 0 0 0;
      -webkit-border-radius: 5px 0 0 0;
      -moz-border-radius: 5px 0 0 0;
    }

    /*Time to add downward connectors from parents*/
    .tree ul ul::before {
      content: '';
      position: absolute;
      top: 0;
      left: 50%;
      border-left: 1px solid #ccc;
      width: 0;
      height: 20px;
    }

    .tree li a {
      border: 1px solid #ccc;
      padding: 5px 10px;
      text-decoration: none;
      color: #666;
      font-family: arial, verdana, tahoma;
      font-size: 11px;
      display: inline-block;

      border-radius: 5px;
      -webkit-border-radius: 5px;
      -moz-border-radius: 5px;

      transition: all 0.5s;
      -webkit-transition: all 0.5s;
      -moz-transition: all 0.5s;
    }

    /*Time for some hover effects*/
    /*We will apply the hover effect the the lineage of the element also*/
    .tree li a:hover,
    .tree li a:hover+ul li a {
      background: #c8e4f8;
      color: #000;
      border: 1px solid #94a0b4;
    }

    /*Connector styles on hover*/
    .tree li a:hover+ul li::after,
    .tree li a:hover+ul li::before,
    .tree li a:hover+ul::before,
    .tree li a:hover+ul ul::before {
      border-color: #94a0b4;
    }

    #container { display:block; }
    @media only screen and (orientation:portrait){
    #container {
    height: 100vw;
    -webkit-transform: rotate(90deg);
    -moz-transform: rotate(90deg);
    -o-transform: rotate(90deg);
    -ms-transform: rotate(90deg);
    transform: rotate(90deg);
    }
    }
    @media only screen and (orientation:landscape){
    #container {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    transform: rotate(0deg);
    }
    }
  </style>
</head>

<body>
    <strong style="color: red">IF YOU USE PHONE, PLEASE ROTATE YOUR PHONE 90° TO DISPLAY THE FULL NETWORK STRUCTURE</strong>


    <div class="tree">
                <ul>
                    <li><a class='link' href='#'><br> <img class="img-fluid" style='width:50px; border-radius:40px' src='<?php echo base_url('upload/no_image/profile.gif') ?>'><br><?php if($parent_1['data']!=null){echo $parent_1['data']->username.' - '.$parent_1['data']->lisensi_name;}else{echo 'ADD';} ?></a>
                        <ul>
                            <li>
                                <a class='link' href='<?php if($parent_1['left']!=null){echo base_url('customer/structure/'.$parent_1['left']->bottom);}else{echo base_url('customer/register?top='.$parent_1['data']->id.'&position=1');} ?>'><br> <img class="img-fluid" style='width:50px; border-radius:40px' src='<?php echo base_url('upload/no_image/profile.gif') ?>'><br><?php if($parent_1['left']!=null){echo $parent_1['left']->bottom_name.' - '.$parent_1['left']->lisensi_name;}else{echo 'ADD';} ?></a>
                                <ul>
                                    <li>
                                        <a class='link' href="<?php if($parent_2['left']!=null){echo base_url('customer/structure/'.$parent_2['left']->bottom);}else{if($parent_2['data']==null){echo '#';}else{echo base_url('customer/register?top='.$parent_2['data']->id.'&position=1');}} ?>"><br> <img class="img-fluid" style='width:50px; border-radius:40px' src='<?php echo base_url('upload/no_image/profile.gif') ?>'><br><?php if($parent_2['left']!=null){echo $parent_2['left']->bottom_name.' - '.$parent_2['left']->lisensi_name;}else{echo 'ADD';} ?></a>
                                        <ul>
                                            <li>
                                                <a class='link' href="<?php if($parent_4['left']!=null){echo base_url('customer/structure/'.$parent_4['left']->bottom);}else{if($parent_4['data']==null){echo '#';}else{echo base_url('customer/register?top='.$parent_4['data']->id.'&position=1');}} ?>"><br> <img class="img-fluid" style='width:50px; border-radius:40px' src='<?php echo base_url('upload/no_image/profile.gif') ?>'><br><?php if($parent_4['left']!=null){echo $parent_4['left']->bottom_name.' - '.$parent_4['left']->lisensi_name;}else{echo 'ADD';} ?></a>
                                            </li>
                                            <li>
                                                <a class='link' href="<?php if($parent_4['right']!=null){echo base_url('customer/structure/'.$parent_4['right']->bottom);}else{if($parent_4['data']==null){echo '#';}else{echo base_url('customer/register?top='.$parent_4['data']->id.'&position=2');}} ?>"><br> <img class="img-fluid" style='width:50px; border-radius:40px' src='<?php echo base_url('upload/no_image/profile.gif') ?>'><br><?php if($parent_4['right']!=null){echo $parent_4['right']->bottom_name.' - '.$parent_4['right']->lisensi_name;}else{echo 'ADD';} ?></a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a class='link' href="<?php if($parent_2['right']!=null){echo base_url('customer/structure/'.$parent_2['right']->bottom);}else{if($parent_2['data']==null){echo '#';}else{echo base_url('customer/register?top='.$parent_2['data']->id.'&position=2');}} ?>"><br> <img class="img-fluid" style='width:50px; border-radius:40px' src='<?php echo base_url('upload/no_image/profile.gif') ?>'><br><?php if($parent_2['right']!=null){echo $parent_2['right']->bottom_name.' - '.$parent_2['right']->lisensi_name;}else{echo 'ADD';} ?></a>
                                        <ul>
                                            <li>
                                                <a class='link' href="<?php if($parent_5['left']!=null){echo base_url('customer/structure/'.$parent_5['left']->bottom);}else{if($parent_5['data']==null){echo '#';}else{echo base_url('customer/register?top='.$parent_5['data']->id.'&position=1');}} ?>"><br> <img class="img-fluid" style='width:50px; border-radius:40px' src='<?php echo base_url('upload/no_image/profile.gif') ?>'><br><?php if($parent_5['left']!=null){echo $parent_5['left']->bottom_name.' - '.$parent_5['left']->lisensi_name;}else{echo 'ADD';} ?></a>
                                            </li>
                                            <li>
                                                <a class='link' href="<?php if($parent_5['right']!=null){echo base_url('customer/structure/'.$parent_5['right']->bottom);}else{if($parent_5['data']==null){echo '#';}else{echo base_url('customer/register?top='.$parent_5['data']->id.'&position=2');}} ?>"><br> <img class="img-fluid" style='width:50px; border-radius:40px' src='<?php echo base_url('upload/no_image/profile.gif') ?>'><br><?php if($parent_5['right']!=null){echo $parent_5['right']->bottom_name.' - '.$parent_5['right']->lisensi_name;}else{echo 'ADD';} ?></a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            
                            <li>
                                <a class='link' href='<?php if($parent_1['right']!=null){echo base_url('customer/structure/'.$parent_1['right']->bottom);}else{echo base_url('customer/register?top='.$parent_1['data']->id.'&position=2');} ?>'><br> <img class="img-fluid" style='width:50px; border-radius:40px' src='<?php echo base_url('upload/no_image/profile.gif') ?>'><br><?php if($parent_1['right']!=null){echo $parent_1['right']->bottom_name.' - '.$parent_1['right']->lisensi_name;}else{echo 'ADD';} ?></a>
                                <ul>
                                    <li>
                                        <a class='link' href="<?php if($parent_3['left']!=null){echo base_url('customer/structure/'.$parent_3['left']->bottom);}else{if($parent_3['data']==null){echo '#';}else{echo base_url('customer/register?top='.$parent_3['data']->id.'&position=1');}} ?>"><br> <img class="img-fluid" style='width:50px; border-radius:40px' src='<?php echo base_url('upload/no_image/profile.gif') ?>'><br><?php if($parent_3['left']!=null){echo $parent_3['left']->bottom_name.' - '.$parent_3['left']->lisensi_name;}else{echo 'ADD';} ?></a>
                                        <ul>
                                            <li>
                                                <a class='link' href="<?php if($parent_6['left']!=null){echo base_url('customer/structure/'.$parent_6['left']->bottom);}else{if($parent_6['data']==null){echo '#';}else{echo base_url('customer/register?top='.$parent_6['data']->id.'&position=1');}} ?>"><br> <img class="img-fluid" style='width:50px; border-radius:40px' src='<?php echo base_url('upload/no_image/profile.gif') ?>'><br><?php if($parent_6['left']!=null){echo $parent_6['left']->bottom_name.' - '.$parent_6['left']->lisensi_name;}else{echo 'ADD';} ?></a>
                                            </li>
                                            <li>
                                                <a class='link' href="<?php if($parent_6['right']!=null){echo base_url('customer/structure/'.$parent_6['right']->bottom);}else{if($parent_6['data']==null){echo '#';}else{echo base_url('customer/register?top='.$parent_6['data']->id.'&position=2');}} ?>"><br> <img class="img-fluid" style='width:50px; border-radius:40px' src='<?php echo base_url('upload/no_image/profile.gif') ?>'><br><?php if($parent_6['right']!=null){echo $parent_6['right']->bottom_name.' - '.$parent_6['right']->lisensi_name;}else{echo 'ADD';} ?></a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a class='link' href="<?php if($parent_3['right']!=null){echo base_url('customer/structure/'.$parent_3['right']->bottom);}else{if($parent_3['data']==null){echo '#';}else{echo base_url('customer/register?top='.$parent_3['data']->id.'&position=2');}} ?>"><br> <img class="img-fluid" style='width:50px; border-radius:40px' src='<?php echo base_url('upload/no_image/profile.gif') ?>'><br><?php if($parent_3['right']!=null){echo $parent_3['right']->bottom_name.' - '.$parent_3['right']->lisensi_name;}else{echo 'ADD';} ?></a>
                                        <ul>
                                            <li>
                                                <a class='link' href="<?php if($parent_7['left']!=null){echo base_url('customer/structure/'.$parent_7['left']->bottom);}else{if($parent_7['data']==null){echo '#';}else{echo base_url('customer/register?top='.$parent_7['data']->id.'&position=1');}} ?>"><br> <img class="img-fluid" style='width:50px; border-radius:40px' src='<?php echo base_url('upload/no_image/profile.gif') ?>'><br><?php if($parent_7['left']!=null){echo $parent_7['left']->bottom_name.' - '.$parent_7['left']->lisensi_name;}else{echo 'ADD';} ?></a>
                                            </li>
                                            <li>
                                                <a class='link' href="<?php if($parent_7['right']!=null){echo base_url('customer/structure/'.$parent_7['right']->bottom);}else{if($parent_7['data']==null){echo '#';}else{echo base_url('customer/register?top='.$parent_7['data']->id.'&position=2');}} ?>"><br> <img class="img-fluid" style='width:50px; border-radius:40px' src='<?php echo base_url('upload/no_image/profile.gif') ?>'><br><?php if($parent_7['right']!=null){echo $parent_7['right']->bottom_name.' - '.$parent_7['right']->lisensi_name;}else{echo 'ADD';} ?></a>
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


</body>

</html>
  
                      
    