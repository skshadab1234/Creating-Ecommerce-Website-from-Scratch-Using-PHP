<?php
    require 'includes/header.php';
    ?>

<section id="wrapper">
    <nav data-depth="2" class="breadcrumb">
        <div class="container">
            <ol itemscope="" itemtype="http://schema.org/BreadcrumbList" class="p-a-0">
                <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"> <a itemprop="item"
                        href="<?= FRONT_SITE_PATH ?>"> <span itemprop="name">Home</span> </a>
                    <meta itemprop="position" content="1">
                </li>
                <li> <span>Login</span></li>
            </ol>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div id="content-wrapper" class="col-lg-12 col-xs-12 js-content-wrapper">
                <section id="main">
                    <header class="page-header">
                        <h1> Login</h1>
                    </header>
                    <section id="content" class="page-content card card-block">
                        <section class="register-form">
                            <p>Don't have an account? <a href="<?= FRONT_SITE_PATH.'register' ?>">Create one</a></p>
                            <form action="" id="LoginiPage_Submit" class="js-customer-form" method="post">
                                <input type="hidden" value='<?= $url ?>' name="page_url">
                                <div>
                                    <div class="form-group row align-items-center "> <label
                                            class="col-md-2 col-form-label required" for="field-email"> Email </label>
                                        <div class="col-md-8"> <input id="field-email" class="form-control" name="email"
                                                type="email" value="" required=""></div>
                                        <div class="col-md-2 form-control-comment"></div>
                                    </div>
                                    <div class="form-group row align-items-center "> <label
                                            class="col-md-2 col-form-label required" for="field-password"> Password
                                        </label>
                                        <div class="col-md-8">
                                            <div class="input-group js-parent-focus"> <input id="field-password"
                                                    class="form-control js-child-focus js-visible-password"
                                                    name="password" type="password" value="" required=""> <span
                                                    class="input-group-append"> 
                                                    
                                                    <button class="btn btn-outline-secondary" type="button" data-action="show-password"> <i class="fa fa-eye-slash" aria-hidden="true"></i> </button> </span></div>
                                        </div>
                                        <div class="col-md-2 form-control-comment"></div>
                                    </div>

                                    <footer class="form-footer clearfix">
                                        <button class="btn btn-primary form-control-submit float-xs-right login-button"
                                            type="submit"> Login </button>
                                    </footer>
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