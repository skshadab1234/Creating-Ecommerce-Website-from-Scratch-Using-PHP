<?php
    require 'includes/header.php';
    if (isset($_GET['referCode']) && $_GET['referCode'] != '' && isset($_GET['UserId']) && $_GET['UserId'] > 0) {
        $referCode = get_safe_value($_GET['referCode']);
        $UserId = get_safe_value($_GET['UserId']);
        $data = ExecutedQuery("SELECT * FROM users WHERE MyReferralCode = '$referCode' && id = '$UserId'");
        if($data == 0) redirect(FRONT_SITE_PATH);
    }else {
        $referCode = '';
        $UserId = '';
    }
    ?>

<section id="wrapper">
    <nav data-depth="2" class="breadcrumb">
        <div class="container">
            <ol itemscope="" itemtype="http://schema.org/BreadcrumbList" class="p-a-0">
                <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"> <a itemprop="item"
                        href="<?= FRONT_SITE_PATH ?>"> <span itemprop="name">Home</span> </a>
                    <meta itemprop="position" content="1">
                </li>
                <li> <span>Create an account</span></li>
            </ol>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div id="content-wrapper" class="col-lg-12 col-xs-12 js-content-wrapper">
                <section id="main">
                    <header class="page-header">
                        <h1> Create an account</h1>
                    </header>
                    <section id="content" class="page-content card card-block">
                        <section class="register-form">
                            <p>Already have an account? <a href="<?= FRONT_SITE_PATH.'login' ?>">Log
                                    in instead!</a></p>
                            <form action="" id="RegisterPageSignup" class="js-customer-form" method="post">
                                <input type="hidden" value='<?= FRONT_SITE_PATH.'login' ?>' name="page_url">
                                <div>
                                    <div class="form-group row align-items-center "> <label
                                            class="col-md-2 col-form-label" for="field-id_gender"> Social title </label>
                                        <div class="col-md-8 form-control-valign"> <label class="radio-inline"
                                                for="field-id_gender-1"> <span class="custom-radio"> <input
                                                        name="id_gender" id="field-id_gender-1" type="radio" value="Mr" required="">
                                                    <span></span> </span> Mr. </label> <label class="radio-inline"
                                                for="field-id_gender-2"> <span class="custom-radio"> <input
                                                        name="id_gender" id="field-id_gender-2" type="radio" required=""
                                                        value="Mrs">
                                                    <span></span> </span> Mrs. </label></div>
                                        <div class="col-md-2 form-control-comment"></div>
                                    </div>
                                    <div class="form-group row align-items-center "> <label
                                            class="col-md-2 col-form-label required" for="field-firstname"> First name
                                        </label>
                                        <div class="col-md-8"> <input id="field-firstname" class="form-control"
                                                name="firstname" type="text" value="" required=""> <span
                                                class="form-control-comment"> Only letters and the dot (.) character,
                                                followed by a space, are allowed. </span></div>
                                        <div class="col-md-2 form-control-comment"></div>
                                    </div>
                                    <div class="form-group row align-items-center "> <label
                                            class="col-md-2 col-form-label required" for="field-lastname"> Last name
                                        </label>
                                        <div class="col-md-8"> <input id="field-lastname" class="form-control"
                                                name="lastname" type="text" value="" required=""> <span
                                                class="form-control-comment"> Only letters and the dot (.) character,
                                                followed by a space, are allowed. </span></div>
                                        <div class="col-md-2 form-control-comment"></div>
                                    </div>
                                    <div class="form-group row align-items-center "> <label
                                            class="col-md-2 col-form-label required" for="field-email"> Email </label>
                                        <div class="col-md-8"> <input id="field-email" class="form-control"
                                                name="email_signup" type="email" value="" required=""></div>
                                        <div class="col-md-2 form-control-comment"></div>
                                    </div>
                                    <div class="form-group row align-items-center "> <label
                                            class="col-md-2 col-form-label required" for="field-password"> Password
                                        </label>
                                        <div class="col-md-8">
                                            <div class="input-group js-parent-focus"> <input id="field-password"
                                                    class="form-control js-child-focus js-visible-password"
                                                    name="password_signup" title="At least 5 characters long"
                                                    aria-label="Password input of at least 5 characters" type="password"
                                                    value="" pattern=".{5,}" required=""> <span
                                                    class="input-group-append"> <button
                                                        class="btn btn-outline-secondary" type="button"
                                                        data-action="show-password"> <i class="fa fa-eye-slash"
                                                            aria-hidden="true"></i> </button> </span></div>
                                        </div>
                                        <div class="col-md-2 form-control-comment"></div>
                                    </div>

                                    <div class="form-group row relative">
                                        <label class="col-md-2 col-form-label required"> Referral Code</label>
                                        <div class="col-md-8 icon-true">

                                            <input class="form-control" name="referral_code" type="text"
                                                value="<?= $referCode ?>" placeholder="Enter Referral Code">
                                            <input type="hidden" name="UserId" value="<?= $UserId ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-2 col-form-label" for="field-psgdpr"> </label>
                                        <div class="col-md-8"> 
                                            <span class="custom-checkbox d-flex align-items-center"> 
                                                <input name="newsletter" id="newsletter12" type="checkbox"  value="1">
                                                <span>
                                                        <i class="fa fa-check rtl-no-flip checkbox-checked" aria-hidden="true"></i>
                                                </span> 
                                                <label class="required mt-1" for="newsletter12"> &nbsp;&nbsp; Sign up for our newsletter</label> 
                                            </span>
                                        </div>
                                        <div class="col-md-2 form-control-comment"></div>
                                    </div>

                                    <footer class="form-footer clearfix"> 
                                        <button class="btn btn-primary form-control-submit float-xs-right register-button" type="submit"> Register </button>
                                    </footer>
                                    <div class="error_place_register">
                                    </div>
                            </form>
                        </section>
                    </section>
                    <footer class="page-footer"> </footer>
                </section>
            </div>
        </div>
    </div>
</section>
<?php
    require 'includes/footer.php';
    ?>