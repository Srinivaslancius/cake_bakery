<!DOCTYPE html>
<html lang="en">
<!-- Mirrored from big-bang-studio.com/cosmos/pages-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 28 Aug 2017 10:14:32 GMT -->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="description" content="">
  <title>Fioten Admin</title>
  <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.html">
  <!-- <link rel="icon" type="image/png" href="favicon-32x32.png" sizes="32x32">
  <link rel="icon" type="image/png" href="favicon-16x16.png" sizes="16x16"> -->
  <link rel="manifest" href="manifest.html">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500,700" rel="stylesheet">
  <link rel="stylesheet" href="css/vendor.min.css">
  <link rel="stylesheet" href="css/cosmos.min.css">
  <link rel="stylesheet" href="css/application.min.css">
</head>
<body class="authentication-body" style="background:url(img/about_3.jpg) no-repeat; background-size:cover; ">
  <div class="container-fluid">
    <div class="authentication-header m-b-30">
      <div class="clearfix">
        <div class="pull-left">
          <a class="authentication-logo" href="index.html">
            <!-- <img src="img/logo.png" alt="" height="25"> -->
            <!-- <span>cosmos</span> -->
          </a>
        </div>
      </div>
    </div>

    <!-- display error message -->
      <?php if(isset($_GET['error']) && $_GET['error']=='fail') { ?>
      <div class="col-sm-4 col-sm-offset-4" id="set_valid_msg">
        <div class="alert alert-danger alert-icon-bg alert-dismissable" role="alert">
          <div class="alert-icon">
            <i class="zmdi zmdi-check"></i>
          </div>
          <div class="alert-message">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">
                <i class="zmdi zmdi-close"></i>
              </span>
            </button>
            <strong>Oh snap!</strong> Entered Username or Password is incorrect!.
          </div>
        </div>
      </div>
      <?php } elseif(isset($_GET['error']) && $_GET['error']=='invalid') {  ?>
      <div class="col-sm-4 col-sm-offset-4" id="set_valid_msg">
        <div class="alert alert-danger alert-icon-bg alert-dismissable" role="alert">
          <div class="alert-icon">
            <i class="zmdi zmdi-check"></i>
          </div>
          <div class="alert-message">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">
                <i class="zmdi zmdi-close"></i>
              </span>
            </button>
            <strong>Oh snap!</strong> Invalid Request!.
          </div>
        </div>
      </div>
      <?php } ?>
      <!-- end error message -->

    <div class="row">
      <div class="col-sm-4 col-sm-offset-4"  style="background:wheat">
        <div class="authentication-content m-b-30">
          <h3 class="m-t-0 m-b-30 text-center">You look great today!</h3>
          <form autocomplete="off" method="post" action="login-script.php" data-toggle="validator">
            <div class="form-group">
              <label for="form-control-1">Email address</label>
              <input type="email" class="form-control" autofocus="autofocus" id="form-control-2" placeholder="Email" name="admin_email" data-error="Please enter a valid email address." required>
              <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
              <label for="form-control-2">Password</label>
              <input type="password" class="form-control" id="form-control-2" placeholder="Password" data-error="Please enter password." required name="admin_password">
              <div class="help-block with-errors"></div>
            </div>
            <button type="submit" class="btn btn-info btn-block">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script src="js/vendor.min.js"></script>
  <script src="js/cosmos.min.js"></script>
  <script src="js/application.min.js"></script>
</body>

<!-- Mirrored from big-bang-studio.com/cosmos/pages-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 28 Aug 2017 10:14:32 GMT -->
</html>
<script type="text/javascript">
$(document).ready(function () {
    setTimeout(function () {
      $('#set_valid_msg').hide();
    }, 2000);
  });
</script>