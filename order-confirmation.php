<?php
    require 'includes/header.php';

    

    if (isset($_GET['orderId'])) {
        $orderId = get_safe_value($_GET['orderId']);
        $SQL = "SELECT * FROM payment_details WHERE Order_Id = '$orderId'";
        $res = mysqli_query($con, $SQL);
        $row = mysqli_fetch_assoc($res);

        if($row['Order_Id'] == $orderId){
            $product_ids = explode(',', $row['product_id']);
            array_unshift($product_ids,"");
            unset($product_ids[0]);
            
        }else{
            redirect(FRONT_SITE_PATH);
        }
        
    } else{
        redirect(FRONT_SITE_PATH);
    }

    
?>


<section id="wrapper">

    <nav data-depth="1" class="breadcrumb">
        <div class="container">
            <ol itemscope="" itemtype="http://schema.org/BreadcrumbList" class="p-a-0">

                <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                    <a itemprop="item" href="<?= FRONT_SITE_PATH ?>">
                        <span itemprop="name">Home</span>
                    </a>
                    <meta itemprop="position" content="1">
                </li>


                <li>
                    <span>Order confirmation</span>
                </li>

            </ol>
        </div>
    </nav>


    <div class="container">
        <div class="row">



            <div id="content-wrapper" class="col-lg-12 col-xs-12">
                <section id="main">
                    <section id="content-hook_order_confirmation" class="card">
                        <div class="card-block">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="h1 card-title">
                                        <i class="material-icons rtl-no-flip done"></i>Your order is confirmed
                                    </h3>

                                    <p>
                                        An email has been sent to the <?= $user['email'] ?> address.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section id="content" class="page-content page-order-confirmation card box mb-2">
                        <div class="card-block">
                            <div class="row">


                                <div id="order-items" class="col-md-12">
                                    <div class="row">

                                        <h3 class="card-title h3 col-md-6 col-12">Order items</h3>
                                        <h3 class="card-title h3 col-md-2 text-md-center _desktop-title">Unit
                                            price</h3>
                                        <h3 class="card-title h3 col-md-2 text-md-center _desktop-title">
                                            Quantity</h3>
                                        <h3 class="card-title h3 col-md-2 text-md-center _desktop-title">Total
                                            products</h3>

                                    </div>

                                    <div class="order-confirmation-table">

                                        <?php
                                        foreach ($product_ids as $key => $value) {
                                            $Prdsql = "SELECT * from product_details where id = '$value'";
                                            $Prdres = mysqli_query($con , $Prdsql);
                                            while ($Prdrow = mysqli_fetch_assoc($Prdres)) {
                                                $ProductImageById = ProductImageById($Prdrow['id'],"limit 1");
                                                array_unshift($ProductImageById,"");
                                                unset($ProductImageById[0]);

                                                $product_varient = explode(',', $row['product_varient']);
                                                array_unshift($product_varient,"");
                                                unset($product_varient[0]);

                                                $product_qty = explode(',', $row['product_qty']);
                                                array_unshift($product_qty,"");
                                                unset($product_qty[0]);
                                                    
                                                    ?>

                                        <div class="order-line row">
                                            <div class="col-sm-2 col-xs-3">
                                                <span class="image">
                                                    <img
                                                        src="<?= FRONT_SITE_IMAGE_PRODUCT.$ProductImageById[1]['product_img'] ?>">
                                                </span>
                                            </div>
                                            <div class="col-sm-4 col-xs-9 details">
                                                <span><?= $Prdrow['product_name']." (Size: ".$product_varient[$key].")" ?></span>

                                            </div>
                                            <div class="col-sm-6 col-xs-12 qty">
                                                <div class="row">
                                                    <div class="col-xs-4 text-sm-center text-xs-left">₹
                                                        <?= $Prdrow['product_price'] ?>
                                                    </div>
                                                    <div class="col-xs-4 text-sm-center"><?= $product_qty[$key] ?></div>
                                                    <div class="col-xs-4 text-sm-center text-xs-right bold">
                                                        ₹ <?= $product_qty[$key] * $Prdrow['product_price'] ?></div>
                                                </div>
                                            </div>
                                        </div>

                                        <?php
                                            }
                                    }
                                    ?>


                                        <hr>

                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td>Subtotal</td>
                                                    <?php
                                                        if ($row['delivery_charge'] == 'Free') {
                                                            $subtotal = $row['amount_captured'];
                                                        }else{
                                                            // if delivery charge is free then don;t remove 500rs in subtotal 
                                                            $subtotal = $row['amount_captured'] - 500;
                                                        }
                                                    ?>
                                                    <td>₹ <?= $subtotal ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Shipping and handling</td>
                                                    <?php
                                                        if ($row['delivery_charge'] == 'Free') {
                                                            $shipping_fee = '<span style="color:green">Free</span>';
                                                        }else{
                                                            $shipping_fee = "₹ 500";
                                                        }
                                                    ?>
                                                    <td> <?= $shipping_fee ?></td>
                                                </tr>

                                                <tr class="total-value font-weight-bold">
                                                    <td><span class="text-uppercase">Total </span>
                                                    </td>

                                                    <td>₹ <?= $row['amount_captured'] ?></td>
                                                </tr>
                                                <tr class="total-value font-weight-bold">
                                                    <td><span class="text-uppercase"> </span>
                                                    </td>

                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>


                                    </div>
                                </div>



                                <div id="order-details" class="col-md-4">
                                    <h3 class="h3 card-title">Order details:</h3>
                                    <ul>
                                        <li>Order reference: <?= $row['fingerprint'] ?></li>
                                        <li>Payment method: Payments by Stripe</li>
                                        <li>
                                            Shipping method: My carrier<br>
                                            <em>Delivery next day!
                                                <?php
                                                echo date("d-m-Y h:i A", strtotime("+1 day", $row['created']));
                                            ?></em>
                                        </li>
                                        <li>Receipt : <a href="<?= $row['receipt_url'] ?>" download target="_blank">View
                                                Receipt From Stripe</a></li>
                                    </ul>
                                </div>


                            </div>
                        </div>
                    </section>


                    <section id="content-hook_payment_return" class="card definition-list">
                        <div class="card-block">
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- begin /var/www/html/demo/rb_evo_demo/modules/ps_checkpayment/views/templates/hook/payment_return.tpl -->
                                    <p>
                                        Your order on <?= SITE_NAME ?> is complete.
                                    </p>

                                    <p>
                                        An email has been sent to you with this information.
                                    </p>

                                    <p>
                                        For any questions or for further information, please contact our
                                        <a href="<?= FRONT_SITE_PATH ?>contact-us">customer
                                            service department.</a>.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <footer class="page-footer">

                        <!-- Footer content -->
                                                        
                    </footer>


                </section>



            </div>



        </div>

    </div>

</section>

<footer id="footer">

    <div class="footer-container footer-v1">
        <div class="footer-center">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-sp-12">
                        <div class="ps-emailsubscription-block block links" id="blockEmailSubscription_displayRbEmail">
                            <div class="title-newsletter">
                                <h3 class="h3 title_block">Newsletter</h3>
                                <h3 class="h3 title_block v1">Sign up now &amp; get 10% off</h3>
                                <p class="sub-letter">Be the first to know about our new arrivals and exclusive
                                    offers.
                                </p>
                            </div>
                            <div class="block_content" id="footer_block_newsletter">
                                <form action="" method="post">
                                    <div class="input-group newsletter-input-group ">
                                        <input name="email" type="email" value=""
                                            class="form-control input-subscription" placeholder="Your email address"
                                            required="">
                                        <button class="btn btn-outline" name="submitNewsletter" type="submit">
                                            <i class="fa fa-paper-plane" aria-hidden="true"></i>
                                            <span>Subscribe</span>
                                        </button>
                                    </div>
                                    <input type="hidden" name="blockHookName" value="displayRbEmail">
                                    <input type="hidden" name="action" value="0">
                                </form>
                                <div class="msg-block">

                                </div>
                            </div>
                        </div>
                        <div class="rb-social-block ">
                            <h3 class="rb-title hidden-sm-down">Follow us</h3>
                            <div id="footer_social_block">
                                <a href="#">
                                    <i class="fa fa-facebook-square" aria-hidden="true"></i>
                                </a>


                                <a href="#">
                                    <i class="fa fa-instagram" aria-hidden="true"></i>
                                </a>

                                <a href="#">
                                    <i class="fa fa-pinterest-square" aria-hidden="true"></i>
                                </a>

                                <a href="#">
                                    <i class="fa fa-youtube-square" aria-hidden="true"></i>
                                </a>

                                <a href="#">
                                    <i class="fa fa-vimeo-square" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                        <p>Don’t worry. We don’t spam</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container-large">
                <div class="row">
                    <div class="col-md-3 col-sp-12">
                        <a href="index.html">
                            <img class="logo img-fluid" src="logo.png" alt="Evo Fashion Store">
                        </a>
                    </div>
                    <div class="col-md-3 col-sp-12 text-md-right" style="line-height: 60px;">
                        <img class="img-fluid"
                            src="https://rubiktheme.com/demo/rb_evo_demo/themes/rb_evo/assets/img/payment.png"
                            alt="payment">
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div id="rb-back-top" class="progress-wrap active-progress">
        <a href="#">
            <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
                <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"
                    style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 17.9424;">
                </path>
            </svg>
        </a>
    </div>
</footer>

</main>

<div id="blockcart-modal-wrap" style="display: none;">

    <div id="blockcart-modal" class="modal " tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        style="display: none;">
        <!-- fade in -->
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="modal-title"><i class="fa fa-check rtl-no-flip" aria-hidden="true"></i> Product
                        successfully added to your shopping cart</span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="box-cart-modal">
                        <div class=" col-sm-4 col-xs-12 divide-right">
                            <div class="row no-gutters align-items-center">
                                <div class="col-6 text-center">
                                    <a
                                        href="https://rubiktheme.com/demo/rb_evo_demo/en/accessories/9-22-mountain-fox-cushion.html#/8-color-white">
                                        <img src="https://rubiktheme.com/demo/rb_evo_demo/136-medium_default/mountain-fox-cushion.jpg"
                                            alt="Ottoto Arezzo" class="img-fluid">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-8 col-xs-12">
                            <div class="cart-info">
                                <div class="pb-1">
                                    <span class="product-name"><a
                                            href="https://rubiktheme.com/demo/rb_evo_demo/en/accessories/9-22-mountain-fox-cushion.html#/8-color-white">Ottoto
                                            Arezzo</a></span>
                                </div>
                                <div class="product-attributes text-muted pb-1">
                                    <div class="product-line-info">
                                        <span class="label">Color:</span>
                                        <span class="value">White</span>
                                    </div>
                                </div>
                                <span class="text-muted">1 x</span> <span>$18.90</span>
                            </div>
                            <div class="cart-content pt-2">
                                <p class="cart-products-count">There is 1 item in your cart.</p>
                                <p>
                                    <strong>Total products:</strong>&nbsp;$18.90
                                </p>

                                <div class="cart-content-btn">
                                    <a href="//rubiktheme.com/demo/rb_evo_demo/en/cart?action=show"
                                        class="btn btn-primary btn-block btn-lg">Proceed to
                                        checkout</a>
                                    <button type="button" class="btn btn-secondary btn-block"
                                        data-dismiss="modal">Continue shopping</button>
                                </div>
                            </div>
                        </div>
                    </div>




                </div>
            </div>
        </div>
    </div>

    <div id="blockcart-notification" class="ns-box  ns-effect-thumbslider">
        <div class="ns-box-inner row align-items-center no-gutters">
            <div class="ns-thumb col-3">
                <img src="https://rubiktheme.com/demo/rb_evo_demo/136-small_default/mountain-fox-cushion.jpg"
                    alt="Ottoto Arezzo" class="img-fluid">
            </div>
            <div class="ns-content col-9">
                <span class="ns-title"><i class="fa fa-check" aria-hidden="true"></i> <strong>Ottoto Arezzo</strong>
                    is added to your shopping cart</span>
            </div>
            <div class="ns-delivery col-12 mt-4"></div>

        </div>
    </div>

</div>

<div class="modal-backdrop " style="display: none;"></div>
<script type="text/javascript" src="script/bottom-60e2c725.js"></script>
</body>

</html>