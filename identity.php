<?php
    require 'includes/header.php';
    
?>

        <section id="wrapper">

            <nav data-depth="3" class="breadcrumb">
                <div class="container">
                    <ol itemscope="" itemtype="http://schema.org/BreadcrumbList" class="p-a-0">

                        <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                            <a itemprop="item" href="">
                                <span itemprop="name">Home</span>
                            </a>
                            <meta itemprop="position" content="1">
                        </li>


                        <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                            <a itemprop="item" href="">
                                <span itemprop="name">Your account</span>
                            </a>
                            <meta itemprop="position" content="2">
                        </li>


                        <li>
                            <span>Your personal information</span>
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
                                    Your personal information
                                </h1>
                            </header>




                            <section id="content" class="page-content">



                                <aside id="notifications">
                                    <div class="container">

                                    </div>
                                </aside>







                                <form action="https://rubiktheme.com/demo/rb_evo_demo/en/identity" id="customer-form"
                                    class="js-customer-form" method="post">
                                    <section>





                                        <div class="form-group row align-items-center ">
                                            <label class="col-md-2 col-form-label">
                                                Social title
                                            </label>
                                            <div class="col-md-8 form-control-valign">
                                            <?php
                                                $array = array('Mr','Mrs');

                                                foreach ($array as $value) {
                                                    if($value == $user['social_title']){
                                                        ?>
                                                    <label class="radio-inline">
                                                        <span class="custom-radio">
                                                            <input name="id_gender" type="radio" value="<?= $value ?>" checked="">
                                                            <span></span>
                                                        </span>
                                                        <?= $value  ?>
                                                    </label>

                                                    <?php
                                                    }else{
                                                        ?>

                                                    <label class="radio-inline">
                                                        <span class="custom-radio">
                                                            <input name="id_gender" type="radio" value="<?= $value ?>" >
                                                            <span></span>
                                                        </span>
                                                        <?= $value  ?>
                                                    </label>
                                                    <?php
                                                    }
                                                }
                                            ?>
                                            

                                            </div>

                                            <div class="col-md-2 form-control-comment">


                                            </div>
                                        </div>







                                        <div class="form-group row align-items-center ">
                                            <label class="col-md-2 col-form-label required">
                                                First name
                                            </label>
                                            <div class="col-md-8">



                                                <input class="form-control" name="firstname" type="text" value="<?= $user['firstname'] ?>"
                                                    required="">
                                                <span class="form-control-comment">
                                                    Only letters and the dot (.) character, followed by a space, are
                                                    allowed.
                                                </span>






                                            </div>

                                            <div class="col-md-2 form-control-comment">


                                            </div>
                                        </div>







                                        <div class="form-group row align-items-center ">
                                            <label class="col-md-2 col-form-label required">
                                                Last name
                                            </label>
                                            <div class="col-md-8">



                                                <input class="form-control" name="lastname" type="text" value="<?= $user['lastname'] ?>"
                                                    required="">
                                                <span class="form-control-comment">
                                                    Only letters and the dot (.) character, followed by a space, are
                                                    allowed.
                                                </span>






                                            </div>

                                            <div class="col-md-2 form-control-comment">


                                            </div>
                                        </div>







                                        <div class="form-group row align-items-center ">
                                            <label class="col-md-2 col-form-label required">
                                                Email
                                            </label>
                                            <div class="col-md-8">



                                                <input class="form-control" name="email" type="email"
                                                    value="<?= $user['email'] ?>" required="">






                                            </div>

                                            <div class="col-md-2 form-control-comment">
                                            </div>
                                        </div>

                                        <div class="form-group row align-items-center ">
                                            <label class="col-md-2 col-form-label required">
                                                Password
                                            </label>
                                            <div class="col-md-8">


                                                <div class="input-group js-parent-focus">
                                                    <input class="form-control js-child-focus js-visible-password"
                                                        name="password" title="At least 5 characters long"
                                                        type="password" value="" pattern=".{5,}" required="">
                                                    <span class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            data-action="show-password">
                                                            <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-md-2 form-control-comment">
                                            </div>
                                        </div>







                                        <div class="form-group row align-items-center ">
                                            <label class="col-md-2 col-form-label">
                                                New password
                                            </label>
                                            <div class="col-md-8">



                                                <div class="input-group js-parent-focus">
                                                    <input class="form-control js-child-focus js-visible-password"
                                                        name="new_password" title="At least 5 characters long"
                                                        type="password" value="" pattern=".{5,}">
                                                    <span class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            data-action="show-password">
                                                            <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                                        </button>
                                                    </span>
                                                </div>






                                            </div>

                                            <div class="col-md-2 form-control-comment">
                                                Optional
                                                </div>
                                        </div>

                                        <div class="form-group row align-items-center ">
                                            <label class="col-md-2 col-form-label">
                                            </label>
                                            <div class="col-md-8">



                                                <span class="custom-checkbox">
                                                    <input name="optin" id="ff_optin" type="checkbox" value="1"
                                                        checked="checked">
                                                    <span><i class="fa fa-check rtl-no-flip checkbox-checked"
                                                            aria-hidden="true"></i></span>
                                                    <label class="" for="ff_optin">Receive offers from our
                                                        partners</label>
                                                </span>






                                            </div>

                                            <div class="col-md-2 form-control-comment">


                                            </div>
                                        </div>







                                        <div class="form-group row align-items-center ">
                                            <label class="col-md-2 col-form-label">
                                            </label>
                                            <div class="col-md-8">



                                                <span class="custom-checkbox">
                                                    <input name="customer_privacy" id="ff_customer_privacy"
                                                        type="checkbox" value="1" required="">
                                                    <span><i class="fa fa-check rtl-no-flip checkbox-checked"
                                                            aria-hidden="true"></i></span>
                                                    <label class=" required" for="ff_customer_privacy">Customer data
                                                        privacy<br><em>The personal data you provide is used to answer
                                                            queries, process orders or allow access to specific
                                                            information. You have the right to modify and delete all the
                                                            personal information found in the "My Account"
                                                            page.</em></label>
                                                </span>






                                            </div>

                                            <div class="col-md-2 form-control-comment">


                                            </div>
                                        </div>







                                        <div class="form-group row align-items-center ">
                                            <label class="col-md-2 col-form-label">
                                            </label>
                                            <div class="col-md-8">



                                                <span class="custom-checkbox">
                                                    <input name="newsletter" id="ff_newsletter" type="checkbox"
                                                        value="1" checked="checked">
                                                    <span><i class="fa fa-check rtl-no-flip checkbox-checked"
                                                            aria-hidden="true"></i></span>
                                                    <label class="" for="ff_newsletter">Sign up for our
                                                        newsletter<br><em>Be the first to know about our new arrivals
                                                            and exclusive offers.</em></label>
                                                </span>






                                            </div>

                                            <div class="col-md-2 form-control-comment">


                                            </div>
                                        </div>







                                        <div class="form-group row align-items-center ">
                                            <label class="col-md-2 col-form-label">
                                            </label>
                                            <div class="col-md-8">



                                                <span class="custom-checkbox">
                                                    <input name="psgdpr" id="ff_psgdpr" type="checkbox" value="1"
                                                        required="">
                                                    <span><i class="fa fa-check rtl-no-flip checkbox-checked"
                                                            aria-hidden="true"></i></span>
                                                    <label class=" required" for="ff_psgdpr">I agree to the terms and
                                                        conditions and the privacy policy</label>
                                                </span>






                                            </div>

                                            <div class="col-md-2 form-control-comment">


                                            </div>
                                        </div>





                                    </section>


                                    <footer class="form-footer clearfix">
                                        <input type="hidden" name="submitCreate" value="1">

                                        <button class="btn btn-primary form-control-submit float-xs-right"
                                            data-link-action="save-customer" type="submit">
                                            Save
                                        </button>

                                    </footer>


                                </form>



                            </section>



                            <footer class="page-footer">



                                <a href="javascript:void(0)" onclick="location.href = document.referrer; return false;"
                                    class="btn account-link">
                                    <i class="material-icons"></i>
                                    <span>Back to your account</span>
                                </a>
                                <a href="https://rubiktheme.com/demo/rb_evo_demo/en/" class="btn account-link">
                                    <i class="material-icons"></i>
                                    <span>Home</span>
                                </a>



                            </footer>


                        </section>



                    </div>



                </div>

            </div>

        </section>

       <?php
       require 'includes/footer.php';