<?php
require '../includes/constant.inc.php';
require '../includes/function.inc.php';
require '../includes/database.inc.php';
    
if (isset($_SESSION['DELIVERY_ID'])) {
    redirect(DELIVERY_FRONT_SITE);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> Log in</title>

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
  <div class="login-logo">
    <a href="<?= DELIVERY_FRONT_SITE ?>"><b><?= SITE_NAME ?></b><sup>delivery boy</sup></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="" id="delivery_Login_Form" method="post">
        <div class="input-group mb-3">
          <input type="email" name='delivery_email' class="form-control" placeholder="Email" required=''> 
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="delivery_password" class="form-control" placeholder="Password"  required=''>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <!-- <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div> -->
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" id='sign_button_admin' class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mb-1">
        <a href="<?= DELIVERY_FRONT_SITE ?>forgot_password">I forgot my password</a>
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
