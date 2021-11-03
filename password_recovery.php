<?php
    require 'includes/header.php';
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
                    <span>Reset your password</span>
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
                            Forgot your password?
                        </h1>
                    </header>




                    <section id="content" class="page-content card card-block">


                        <form action="" id='forgotten-password'
                            class="forgotten-password" method="post">

                            <ul class="ps-alert-error">
                            </ul>

                            <header>
                                <p class="send-renew-password-link">Please enter the email address you used to register.
                                    You will receive a temporary link to reset your password.</p>
                            </header>

                            <section class="form-fields">
                                <div class="form-group center-email-fields">
                                    <label class="col-md-3 form-control-label required">Email address</label>
                                    <div class="col-md-5 email">
                                        <input type="email" name="reset_email" id="reset_email" value="" class="form-control"
                                            required="">
                                    </div>
                                    <button class="form-control-submit btn btn-primary hidden-xs-down" id='reset_pass_button' name="submit"
                                        type="submit">
                                        Send reset link
                                    </button>
                                </div>
                            </section>

                        </form>

                    </section>


                    <footer class="page-footer">

                        <a href="javascript:void(0)" class="btn account-link" id='back_to_login_forgot_password'>
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