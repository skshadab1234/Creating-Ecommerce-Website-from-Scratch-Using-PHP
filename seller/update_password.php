<?php
require '../includes/constant.inc.php';
require '../includes/function.inc.php';
require '../includes/database.inc.php';
if (isset($_GET['seller_email']) && $_GET['seller_email'] != '' && isset($_GET['seller_ResetCode']) && $_GET['seller_ResetCode'] > 0) {
    $email = get_safe_value($_GET['seller_email']);
    $seller_ResetCode = get_safe_value($_GET['seller_ResetCode']);
    $SellerDetails = ExecutedQuery("SELECT * FROM seller_account WHERE seller_email = '$email'");    
    if($SellerDetails[0]['seller_ResetCode'] != $seller_ResetCode){
        redirect(SELLER_FRONT_SITE) ;
    }
    
    $rand = rand(11111,99999);
    mysqli_query($con, "update seller_account set seller_ResetCode='$rand' WHERE seller_email = '$email'");
}else{
    redirect(SELLER_FRONT_SITE);
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
        <a href="<?= SELLER_FRONT_SITE ?>" class="h1"><b><?= SITE_NAME ?></b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">You are only one step a way from your new password, recover your password now.</p>
      <form action="" id='update-password-admin' method="post">
      <input type="hidden" value='<?= $SellerDetails[0]['id'] ?>' name='seller_id_update_pass'> 
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
      <a href="<?= ADMIN_FRONT_SITE.'login' ?>"> Login</a>
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
<!-- jquery-validation -->
<script src="https://adminlte.io/themes/v3/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="https://adminlte.io/themes/v3/plugins/jquery-validation/additional-methods.min.js"></script>
<!-- Sweet Alert CDN  -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<script>
    // Update Password Admin 
    $("#update-password-admin").submit((e) => {
        e.preventDefault();

        var form_data = $("#update-password-admin").serialize();
        $.ajax({
            url: 'seller_ajax_call.php',
            method: 'post',
            data: form_data,
            success: (res) => {
                var data = $.parseJSON(res);

                if (data.status == 'error') {
                    swal(data.message, '', 'error');
                }
                if (data.status == 'success') {
                    swal(data.message, '', 'success');
                    setTimeout(() => {
                        window.location = 'logintoseller';
                    }, 2000);
                }
            }
        });
    })
</script>

</body>
</html>
