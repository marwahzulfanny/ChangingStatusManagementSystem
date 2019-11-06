<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ABCIS - <?=strip_tags($title)?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?=asset_url('bootstrap/css/bootstrap.min.css')?>">
  <!-- Font Awesome -->
  <!--link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css"-->
  <link rel="stylesheet" href="<?=asset_url('bootstrap/css/font-awesome.min.css');?>">
  <!-- Ionicons -->
  <!--link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css"-->
  <link rel="stylesheet" href="<?=asset_url('bootstrap/css/ionicons.min.css');?>">

  <?=(isset($add) ? $add : '');?>

  <!-- Theme style -->
  <link rel="stylesheet" href="<?=asset_url('dist/css/AdminLTE.min.css');?>">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?=asset_url('dist/css/skins/_all-skins.min.css');?>">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?=asset_url('plugins/iCheck/flat/blue.css');?>">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?=asset_url('plugins/morris/morris.css');?>">
  <link rel="stylesheet" href="<?=asset_url('plugins/datatables/jquery.dataTables.min.css');?>">
  <!-- jvectormap -->
  <!--link rel="stylesheet" href="<?=asset_url('plugins/jvectormap/jquery-jvectormap-1.2.2.css');?>"-->
  <!-- Date Picker -->
  <!--link rel="stylesheet" href="<?=asset_url('plugins/datepicker/datepicker3.css');?>"-->
  <!-- Daterange picker -->
  <!--link rel="stylesheet" href="<?=asset_url('plugins/daterangepicker/daterangepicker.css');?>"-->
  <!-- bootstrap wysihtml5 - text editor -->
  <!--link rel="stylesheet" href="<?=asset_url('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css');?>"-->

  <link rel="stylesheet" href="<?=asset_url('plugins/iCheck/square/blue.css');?>">
	<link rel="stylesheet" href="<?php echo base_url().'assets/plugins/toastr/toastr.min.css';?>">

    <?php if (isset($output)) {
			foreach($output->css_files as $file): ?>
				<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
			<?php endforeach; foreach($output->js_files as $file): ?>
				<script src="<?php echo $file; ?>"></script>
			<?php endforeach;
    } ?>
		
		
	
	<style>
	.crud-form .container{float:left}
	.table-label{background:none}
	.table-container{border:none}
	.floatR.r5.minimize-maximize-container.minimize-maximize{display:none}
	.floatR.r5.gc-full-width{display:none}
	</style>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<body class="hold-transition skin-blue <?=(!isset($simple) ? 'sidebar-mini' : '')?> <?=(isset($add_body_class) ? $add_body_class : '');?>">
<?php if(!isset($simple)) { ?>
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="<?=base_url();?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>ABC</b>IS</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>ABC</b>IS</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

			<?php if($this->session->login){ ?>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php 
							if($this->session->photo!=""){
								$parts = explode(".", $this->session->photo);
								$ext = array_pop($parts);
								$filename = implode('.', $parts);
							}else{
								$filename = 'o';
								$ext = 'png';
							}
							echo asset_url('uploads/user_photo/'.$filename.'_thumb.'.$ext); 
							?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?=$this->session->name;?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
			  
                <img src="<?=asset_url('uploads/user_photo/'.$filename.'_thumb.'.$ext);?>" class="img-circle" alt="User Image">

                <p>
                  <?=$this->session->name;?> - <?=$this->session->role;?>
                  <small><?=$this->session->email;?></small>
                </p>
              </li>
              <!-- Menu Body -->
              <!-- Menu Footer-->
              <li class="user-footer">
				<div class="pull-left">
                  <a href="<?=base_url('users/index/edit/'.$this->session->id) ;?>" class="btn btn-default btn-flat">Edit Profile & Password</a>
                </div>
                <div class="pull-right">
                  <a href="<?=base_url('logout');?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
        </ul>
      </div>
			<?php } ?>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <!--div class="user-panel">
        <div class="pull-left image">
          <img src="<?=asset_url('uploads/user_photo/'.$filename.'_thumb.'.$ext);?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?=$this->session->name;?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div-->
      <!-- search form -->
      <!--form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form-->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
		<?php $this->load->view('parts/menu');?>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$title;?>
        <!--small>Control panel</small-->
      </h1>
      <!--ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?=$title;?></li>
      </ol-->
    </section>
<?php } ?>