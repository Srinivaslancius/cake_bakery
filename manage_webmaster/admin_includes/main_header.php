<?php 
ob_start();
include_once('admin_includes/config.php');
include_once('admin_includes/common_functions.php');
$getSiteSettings = getDataFromTables('site_settings',$status=NULL,$clause='id',$id=1,$activeStatus=NULL,$activeTop=NULL); 
$getSiteSettingsData = $getSiteSettings->fetch_assoc();

if(!isset($_SESSION['admin_user_id'])) {
  header("Location: logout.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">  
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="">
    <title><?php echo $getSiteSettingsData['admin_title'];?></title>
    <link rel="icon" type="image/png" href="<?php echo $base_url . 'uploads/logo/'.$getSiteSettingsData['logo'] ?>" sizes="32x32">    
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500,700" rel="stylesheet">
    <link rel="stylesheet" href="css/vendor.min.css">
    <link rel="stylesheet" href="css/cosmos.min.css">
    <link rel="stylesheet" href="css/application.min.css">
  </head>
  <body class="layout layout-header-fixed layout-left-sidebar-fixed">
    <div class="site-overlay"></div>
    <div class="site-header">
      <nav class="navbar navbar-default" style="background-color:#D4E6F1 !important;">
        <div class="navbar-header">
          <a class="navbar-brand" href="dashboard.php">
            <img src="<?php echo $base_url . 'uploads/logo/'.$getSiteSettingsData['logo'] ?>" accept="image/*" height="20">
            <span><?php echo $getSiteSettingsData['admin_title'];?></span>
          </a>
          <button class="navbar-toggler left-sidebar-toggle pull-left visible-xs" type="button">
            <span class="hamburger"></span>
          </button>
          <button class="navbar-toggler right-sidebar-toggle pull-right visible-xs-block" type="button">
            <i class="zmdi zmdi-long-arrow-left"></i>
            <div class="dot bg-danger"></div>
          </button>
          <button class="navbar-toggler pull-right visible-xs-block" type="button" data-toggle="collapse" data-target="#navbar">
            <span class="more"></span>
          </button>
        </div>
        <div class="navbar-collapsible">
          <div id="navbar" class="navbar-collapse collapse">
            <button class="navbar-toggler left-sidebar-collapse pull-left hidden-xs" type="button">
              <span class="hamburger"></span>
            </button>
            <button class="navbar-toggler right-sidebar-toggle pull-right hidden-xs" type="button">
              <i class="zmdi zmdi-long-arrow-left"></i>
              <div class="dot bg-danger"></div>
            </button>           
            
            <ul class="nav navbar-nav navbar-right">              
              <li class="nav-table dropdown hidden-sm-down">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  <span class="nav-cell p-r-10">
                    <img class="img-circle" src="img/avatars/1.jpg" alt="" width="32" height="32">
                  </span>
                  <span class="nav-cell"><?php echo $_SESSION['admin_user_name']; ?>
                    <span class="caret"></span>
                  </span>
                </a>
                <ul class="dropdown-menu">
                  <li>
                    <a href="logout.php">
                      <i class="zmdi zmdi-power m-r-10"></i> Logout</a>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </div>
  <div class="site-main">
    <?php include_once 'admin_includes/side_navigation.php'; ?>
    <?php if(isset($_GET['msg']) && $_GET['msg']=='success') { ?>
    <div class="col-sm-6 col-md-offset-5" style="margin-left:32.667% !important; margin-top:7px;" id="set_valid_msg">
      <div class="alert alert-success alert-icon-bg alert-dismissable" role="alert" style="margin-bottom:-7px;">
        <div class="alert-icon">
          <i class="zmdi zmdi-check"></i>
        </div>
        <div class="alert-message">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">
              <i class="zmdi zmdi-close"></i>
            </span>
          </button>
          <strong>Well done!</strong> Your data updated successfully  .
        </div>
      </div>
    </div>
    <div class="clearfix"></div>
    <?php } elseif(isset($_GET['msg']) && $_GET['msg']=='fail') { ?>
    <div class="col-sm-6 col-md-offset-5" style="margin-left:32.667% !important; margin-top:7px;" id="set_valid_msg">
      <div class="alert alert-danger alert-icon-bg alert-dismissable" role="alert" style="margin-bottom:-7px;">
        <div class="alert-icon">
          <i class="zmdi zmdi-check"></i>
        </div>
        <div class="alert-message">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">
              <i class="zmdi zmdi-close"></i>
            </span>
          </button>
          <strong>Oops!</strong> Your data updation failed.
        </div>
      </div>
    </div>
    <div class="clearfix"></div>
  <?php } else {  ?>
  <div class="clearfix"></div>
  <?php } ?>
