<?php
    require 'includes/header.php';
    if (isset($_GET['email']) && $_GET['email'] != '' && isset($_GET['userLoginCode']) && $_GET['userLoginCode'] > 0) {
        $email = get_safe_value($_GET['email']);
        $uselogincode = get_safe_value($_GET['userLoginCode']);
        $UsersDetails = UsersDetails("WHERE email = '$email'");    
        if($UsersDetails[0]['userLoginCode'] != $uselogincode){
            redirect(FRONT_SITE_PATH);
        }
            $rand = rand(11111,99999);
            mysqli_query($con, "update users set userLoginCode='$rand' WHERE email = '$email'");
        
    }else{
        redirect(FRONT_SITE_PATH);
    }
    
?>

<section id="wrapper">

    <nav data-depth="2" class="breadcrumb">
        <div class="container">
            <ol itemscope="" itemtype="http://schema.org/BreadcrumbList" class="p-a-0">

                <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                    <a itemprop="item" href="<?= FRONT_SITE_PATH ?>">
                        <span itemprop="name">Home</span>
                    </a>
                    <meta itemprop="position" content="1">
                </li>


                <li>
                    <span>Change your password</span>
                </li>

            </ol>
        </div>
    </nav>


    <div class="container">
        <div class="row">



            <div id="content-wrapper" class="col-lg-12 col-xs-12">



                <section id="main">



                    <header class="page-header">
                        <h1>
                            Change your password
                        </h1>
                    </header>




                    <section id="content" class="page-content card card-block">


                        <form action="" id='update-password' method="post">
                            <input type="hidden" value='<?= $UsersDetails[0]['id'] ?>' name='user_id_update_pass'> 
                            <ul class="ps-alert-error">
                            </ul>

                            <header>
                                <p><strong>Note :  </strong> This page is tempeorary page one time use only. Once you open this page you will not be able to open it again.</p>
                            </header>

                            <section class="form-fields">
                                
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group center-email-fields">
                                        <label class="col-md-3 form-control-label ">New Password</label>
                                        <div class="col-md-5 email">
                                            <input type="password" name="new_password" id="new_password" value="" class="form-control"
                                                required="">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 mt-2">
                                    <div class="form-group center-email-fields">
                                        <label class="col-md-3 form-control-label ">Confirm Password</label>
                                        <div class="col-md-5 email">
                                            <input type="text" name="confirm_password" id="confirm_password" value="" class="form-control"
                                                required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 mt-2"  style="display: flex;justify-content: center;margin-top: 20px;">
                                    <button class="form-control-submit btn btn-success hidden-xs-down"  id='reset_pass_button' name="submit"
                                            type="submit">
                                            Update
                                    </button>
                                </div>
                                
                            </div>

                                
                            </section>

                        </form>

                    </section>


                    <footer class="page-footer">

                        <a href="javascript:void(0)" class="btn account-link" id="back_to_login_forgot_password">
                            <i class="material-icons"></i>
                            <span>Back to login</span>
                        </a>

                    </footer>


                </section>



            </div>



        </div>

    </div>

</section>
<?php
    require 'includes/footer.php';
?>