<?php
require '../includes/constant.inc.php';
require '../includes/function.inc.php';
require '../includes/database.inc.php';
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> Forgot Password</title>

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
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="<?= FRONT_SITE_PATH ?>" class="h1"><b><?= SITE_NAME ?></b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
      <form action="" id="delivery_forgot_password" method="post">
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="reset_email" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" id="reset_pass_button" class="btn btn-primary btn-block">Send reset Link</button>
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
