<?php
require '../includes/constant.inc.php';
require '../includes/function.inc.php';
require '../includes/database.inc.php';
if (isset($_GET['delivery_boy_email']) && $_GET['delivery_boy_email'] != '' && isset($_GET['deliveryLoginCode']) && $_GET['deliveryLoginCode'] > 0) {
    $email = get_safe_value($_GET['delivery_boy_email']);
    $deliveryLoginCode = get_safe_value($_GET['deliveryLoginCode']);
    $DeliveryDetails = DeliveryDetails("WHERE delivery_boy_email = '$email'");    
    if($DeliveryDetails[0]['deliveryLoginCode'] != $deliveryLoginCode){
        redirect(DELIVERY_FRONT_SITE);
    }
    
    $rand = rand(11111,99999);
    // mysqli_query($con, "update delivery_boy set deliveryLoginCode='$rand' WHERE delivery_boy_email = '$email'");
}else{
    redirect(DELIVERY_FRONT_SITE);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> Update Password</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/icheck-bootstrap/icheck-bootstrap.min.css">

  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

  <link rel="shortcut icon" href="<?= FRONT_SITE_PATH.'logo.png' ?>" type="image/x-icon">
  <!-- Theme style -->
  <link rel="stylesheet" href="https://adminlte.io/themes/v3/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
        <a href="<?= FRONT_SITE_PATH ?>" class="h1"><b><?= SITE_NAME ?></b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">You are only one step a way from your new password, recover your password now.</p>
      <form action="" id='update-password-delivery' method="post">
      <input type="hidden" value='<?= $DeliveryDetails[0]['delivery_boy_id'] ?>' name='delivery_id_update_pass'> 
        <div class="input-group mb-3">
          <input type="password" class="form-control" name='new_password' placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Change password</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mt-3 mb-1">
      <a href="<?= DELIVERY_FRONT_SITE.'login' ?>"> Login</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->


<!-- jQuery -->
<script src="https://adminlte.io/themes/v3/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://adminlte.io/themes/v3/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://adminlte.io/themes/v3/dist/js/adminlte.min.js"></script>

<!-- Custom Script  -->
<script src= "<?= DELIVERY_FRONT_SITE.'admin_assets/js/script.js' ?>"></script>

<!-- Sweet Alert CDN  -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>



</body>
</html>
