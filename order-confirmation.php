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

                                <div id="order-details" class="col-md-12">
                                    <h3 class="h3 card-title">Order details:</h3>
                                    <ul>
                                        <li>Order reference: <?= $row['fingerprint'] ?></li>
                                        <li>Payment method: Payments by Stripe</li>
                                        <li>
                                            Shipping method: My carrier<br>
                                            <em>Delivery next day!
                                                <?php
                                                echo date("d-m-Y h:i A", strtotime("+1 day", strtotime($row['created'])));
                                            ?></em>
                                        </li>
                                        <li>Receipt : <a href="<?= $row['receipt_url'] ?>" download target="_blank">View
                                                Receipt From Stripe</a></li>
                                        <li><a class="btn btn-primary float-right" href="download?filename=<?= $row['invoice_file'] ?>&redirect=<?= $url ?>">Download Invoice</a></li>
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

<?php
    require 'includes/footer.php';
?>