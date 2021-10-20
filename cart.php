<?php
    require 'includes/header.php';

?>
<section id="wrapper">

    <nav data-depth="1" class="breadcrumb">
        <div class="container">
            <ol itemscope="" itemtype="http://schema.org/BreadcrumbList" class="p-a-0">

                <li itemprop="itemListElement">
                    <a itemprop="item" href="<?= FRONT_SITE_PATH ?>">
                        <span itemprop="name">Home</span>
                    </a>
                    <meta itemprop="position" content="1">
                </li>


                <li>
                    <span>Cart</span>
                </li>

            </ol>
        </div>
    </nav>


    <div class="container" id="cart_container">
        <div class="row">

            <div id="content-wrapper" class="col-lg-12 col-xs-12">

                <section id="main">
                    <div class="cart-grid row">

                        <!-- Left Block: cart product informations & shpping -->
                        <div class="cart-grid-body col-xs-12 col-lg-8">

                            <!-- cart products fdetailed -->
                            <div class="card cart-container">
                                <div class="card-block">
                                    <h1 class="h1">Shopping Cart</h1>
                                </div>
                                <hr class="separator">


                                <div class="cart-overview js-cart" data-refresh-url="">
                                    <ul class="cart-items">

                                    </ul>
                                </div>


                            </div>


                            <a class="label" href="<?= FRONT_SITE_PATH ?>">
                                <i class="material-icons">chevron_left</i>Continue shopping
                            </a>


                            <!-- shipping informations -->

                        </div>

                        <!-- Right Block: cart subtotal & cart total -->
                        <div class="cart-grid-right col-xs-12 col-lg-4">
                            <div class="card cart-summary rb-cart-checkout">
                                <div class="cart-detailed-totals">
                                    <div class="head-cart-total">
                                        <h4>Cart totals</h4>
                                    </div>
                                    <div class="card-block">
                                        <div class="cart-summary-line" id="cart-subtotal-products">
                                            <span class="label js-subtotal">
                                            </span>
                                            <span class="value">

                                            </span>
                                        </div>
                                        <div class="cart-summary-line" id="cart-subtotal-shipping">
                                            <span class="label">
                                                Shipping
                                            </span>
                                            <span class="value">

                                            </span>
                                            <!-- <div><small class="value"></small></div> -->
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="card-block cart-summary-totals">
                                        <div class="cart-summary-line">
                                            <span class="label">Total Payabale</span>
                                            <span class="value" id='Total_Payabale'></span>
                                        </div>

                                    </div>


                                </div>

                                <div class="checkout cart-detailed-actions card-block">
                                    <div class="text-sm-center">
                                        <?php
                                                        if (isset($_SESSION['UID'])) {
                                                            ?>
                                        <a href="<?= FRONT_SITE_PATH.'checkout' ?>"
                                            class="btn btn-primary btn-block btn-lg">Checkout</a>
                                        <?php
                                                        }else{
                                                            ?>
                                        <a href="javascript:void(0)" id="cart_checkout_id"
                                            class="btn btn-primary btn-block btn-lg">Login to Checkout</a>
                                        <?php
                                                        }
                                                    ?>
                                    </div>
                                </div>



                            </div>



                            <div class="block-reassurance">
                                <ul>
                                    <li>
                                        <div class="block-reassurance-item">
                                            <img src="media/security.svg" alt="Security policy">
                                            <div>
                                                <span style="color:#000000;">Security policy</span>
                                                <p style="color:#000000;">(edit with the Customer Reassurance
                                                    module)</p>

                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="block-reassurance-item">
                                            <img src="media/carrier.svg" alt="Delivery policy">
                                            <div>
                                                <span style="color:#000000;">Delivery policy</span>
                                                <p style="color:#000000;">(edit with the Customer Reassurance
                                                    module)</p>

                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="block-reassurance-item">
                                            <img src="media/parcel.svg" alt="Return policy">
                                            <div>
                                                <span style="color:#000000;">Return policy</span>
                                                <p style="color:#000000;">(edit with the Customer Reassurance
                                                    module)</p>

                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>



                        </div>

                    </div>
                </section>


            </div>



        </div>

    </div>

</section>

<?php
            require 'includes/footer.php';
        ?>