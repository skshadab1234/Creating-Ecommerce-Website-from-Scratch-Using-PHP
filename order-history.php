<?php
    require 'includes/header.php';
?>

<section id="wrapper">

    <nav data-depth="3" class="breadcrumb">
        <div class="container">
            <ol itemscope="" itemtype="http://schema.org/BreadcrumbList" class="p-a-0">

                <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                    <a itemprop="item" href="https://rubiktheme.com/demo/rb_evo_demo/en/">
                        <span itemprop="name">Home</span>
                    </a>
                    <meta itemprop="position" content="1">
                </li>


                <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                    <a itemprop="item" href="https://rubiktheme.com/demo/rb_evo_demo/en/my-account">
                        <span itemprop="name">Your account</span>
                    </a>
                    <meta itemprop="position" content="2">
                </li>


                <li>
                    <span>Order history</span>
                </li>

            </ol>
        </div>
    </nav>


    <div class="container">
        <div class="row">
            <div id="content-wrapper" class="col-lg-12 col-xs-12">


                <section id="main">

                    <?php

                            if(isset($_GET['orderDetails']) && $_GET['orderDetails'] != '') {
                                $orderDetails = get_safe_value($_GET['orderDetails']);

                                $Sql = "SELECT * FROM payment_details WHERE Order_Id = '$orderDetails'";
                                $res = mysqli_query($con, $Sql);
                                $row = mysqli_fetch_assoc($res);

                                $getAddressById = getAddressById($row['delivery_address_id']);
                                
                                

                                ?>

                    <!-- Details of Products Invoice -->
                    <header class="page-header">
                        <h1>
                            Order details
                        </h1>
                    </header>

                    <section id="content" class="page-content">



                        <aside id="notifications">
                            <div class="container">



                            </div>
                        </aside>




                        <div id="order-infos">
                            <div class="box">
                                <div class="row">
                                    <div class="col-xs-9">
                                        <strong>
                                            Order ID <?= $row['Order_Id'] ?> - placed on
                                            <?= date("d-m-Y", strtotime($row['created'])) ?>
                                        </strong>
                                    </div>
                                    <div class="col-xs-3 text-xs-right">
                                        <a href="#"
                                            class="button-primary">Reorder</a>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="box">
                                <ul>
                                    <li><strong>Carrier</strong> My carrier</li>
                                    <li><strong>Payment method</strong> Stripe</li>



                                </ul>
                            </div>
                        </div>

                        <!-- <section id="order-history" class="box">
                            <h3>Follow your order's status step-by-step</h3>
                            <table class="table table-striped table-bordered table-labeled hidden-xs-down">
                                <thead class="thead-default">
                                    <tr>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>10/08/2021</td>
                                        <td>
                                            <span class="label label-pill bright" style="background-color:#34209E">
                                                Awaiting bank wire payment
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="hidden-sm-up history-lines">
                                <div class="history-line">
                                    <div class="date">10/08/2021</div>
                                    <div class="state">
                                        <span class="label label-pill bright" style="background-color:#34209E">
                                            Awaiting bank wire payment
                                        </span>
                                    </div>
                                </div>
                            </div>
                            </section> -->




                        <div class="addresses">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <article id="delivery-address" class="box">
                                    <h4>Delivery address </h4>
                                    <address><?= $getAddressById['add_firstname'].' '.$getAddressById['add_lastname'].', '.$getAddressById['company'].'<br>'.$getAddressById['address'].', '.$getAddressById['addres_complement'].'<br>'.$getAddressById['city'].' - '.$getAddressById['postal_code'].'<br>'.$getAddressById['state'].'<br>'.$getAddressById['country']
                                .'<br>'.$getAddressById['phone_number']  ?></address>
                                </article>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <article id="invoice-address" class="box">
                                    <h4>Invoice address </h4>
                                    <address><?= $getAddressById['add_firstname'].' '.$getAddressById['add_lastname'].', '.$getAddressById['company'].'<br>'.$getAddressById['address'].', '.$getAddressById['addres_complement'].'<br>'.$getAddressById['city'].' - '.$getAddressById['postal_code'].'<br>'.$getAddressById['state'].'<br>'.$getAddressById['country']
                                                 .'<br>'.$getAddressById['phone_number']  ?></address>
                                  </article>
                            </div>
                            <div class="clearfix"></div>
                        </div>


                        <div class="box hidden-sm-down">
                            <table id="order-products" class="table table-bordered">
                                <thead class="thead-default">
                                    <tr>
                                        <th width="10%"></th>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Unit price</th>
                                        <th>Total price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                        $product_ids = explode(',', $row['product_id']);
                                        array_unshift($product_ids,"");
                                        unset($product_ids[0]);
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

                                    <tr>
                                        <td>
                                        <img class="img-fluid" width="200px" height="200px"
                                                    src="<?= FRONT_SITE_IMAGE_PRODUCT.$ProductImageById[1]['product_img'] ?>" alt=""
                                                    title="" itemprop="image">
                                        </td>
                                        <td>
                                            <strong>
                                                <a>
                                                
                                                    <?= $Prdrow['product_name'] ?>
                                                </a>
                                            </strong><br>
                                            Size: <?= $product_varient[$key] ?><br>
                                        </td>
                                        <td>
                                            <?= $product_qty[$key] ?>
                                        </td>
                                        <td class="text-xs-right">₹ <?= $Prdrow['product_price'] ?></td>
                                        <td class="text-xs-right">₹ <?= $product_qty[$key] * $Prdrow['product_price'] ?></td>
                                    </tr>

                                    <?php
                                            }
                                        }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr class="text-xs-right line-products">
                                        <td colspan="4">Subtotal</td>
                                        <?php
                                            if ($row['delivery_charge'] == 'Free') {
                                                $subtotal = $row['amount_captured'];
                                            }else{
                                                // if delivery charge is free then don;t remove 500rs in subtotal 
                                                $subtotal = $row['amount_captured'] - 500;
                                            }
                                        ?>
                                        <td><?= "₹ ".$subtotal ?></td>
                                    </tr>
                                    <tr class="text-xs-right line-shipping">
                                        <td colspan="4">Shipping and handling</td>
                                        <?php
                                            if ($row['delivery_charge'] == 'Free') {
                                                $shipping_fee = '<span style="color:green">Free</span>';
                                            }else{
                                                $shipping_fee = "₹ 500";
                                            }
                                        ?>
                                        <td><?= $shipping_fee ?></td>
                                    </tr>
                                    
                                    <tr class="text-xs-right line-total">
                                        <td colspan="4">Total</td>
                                        <td>₹ <?= $row['amount_captured'] ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>


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
                        <div class="order-items hidden-md-up box">
                            <div class="order-item">
                                <div class="row">
                                    <div class="col-sm-5 desc">
                                        <div style="display: flex;justify-content: center;">
                                        <img class="img-fluid" width="50px" height="50px"
                                                    src="<?= FRONT_SITE_IMAGE_PRODUCT.$ProductImageById[1]['product_img'] ?>" alt=""
                                                    title="" itemprop="image">
                                        </div>
                                        <div class="name" style="display: flex;justify-content: center;"><?= $Prdrow['product_name'] ?></div>
                                        <div class="ref" style="display: flex;justify-content: center;">Size: <?= $product_varient[$key] ?></div>
                                    </div>
                                    <div class="col-sm-7 qty">
                                        <div class="row">
                                            <div class="col-xs-4 text-sm-left text-xs-left">
                                                ₹ <?= $Prdrow['product_price'] ?>
                                            </div>
                                            <div class="col-xs-4">
                                                <?= $product_qty[$key] ?>
                                            </div>
                                            <div class="col-xs-4 text-xs-right">
                                                ₹ <?= $product_qty[$key] * $Prdrow['product_price'] ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <?php
                                }
                            }
                        ?>
                        <div class="order-totals hidden-md-up box">
                            <div class="order-total row">
                                <div class="col-xs-8"><strong>Subtotal</strong></div>
                                <div class="col-xs-4 text-xs-right"><?= "₹ ".$subtotal ?></div>
                            </div>
                            <div class="order-total row">
                                <div class="col-xs-8"><strong>Shipping and handling</strong></div>
                                <div class="col-xs-4 text-xs-right"><?= $shipping_fee ?></div>
                            </div>
                            
                            <div class="order-total row">
                                <div class="col-xs-8"><strong>Total</strong></div>
                                <div class="col-xs-4 text-xs-right">₹ <?= $row['amount_captured'] ?></div>
                            </div>
                        </div>




                        <div class="box">
                            <table class="table table-striped table-bordered hidden-sm-down">
                                <thead class="thead-default">
                                    <tr>
                                        <th>Date</th>
                                        <th>Carrier</th>
                                        <th>Shipping cost</th>
                                        <th>Tracking number</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?= date("d-m-Y", strtotime("+1 day", strtotime($row['created']))); ?></td>
                                        <td>My carrier</td>
                                        <td><?= $shipping_fee ?></td>
                                        <td>-</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="hidden-md-up shipping-lines">
                                <div class="shipping-line">
                                    <ul>
                                        <li>
                                            <strong>Date</strong> <?=  date("d-m-Y", strtotime("+1 day", strtotime($row['created']))); ?>
                                        </li>
                                        <li>
                                            <strong>Carrier</strong> My carrier
                                        </li>
                                        
                                        <li>
                                            <strong>Shipping cost</strong> <?= $shipping_fee ?>
                                        </li>
                                        <li>
                                            <strong>Tracking number</strong> -
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <section class="order-message-form box">
                            <form action="https://rubiktheme.com/demo/rb_evo_demo/en/index.php?controller=order-detail"
                                method="post">

                                <header>
                                    <h3>Add a message</h3>
                                    <p>If you would like to add a comment about your order, please write it in
                                        the field below.</p>
                                </header>

                                <section class="form-fields">

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Product</label>
                                        <div class="col-md-5">
                                            <select name="id_product" class="form-control form-control-select">
                                                <option value="0">-- please choose --</option>
                                                <option value="8">Cream Square Shirt</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label"></label>
                                        <div class="col-md-9">
                                            <textarea rows="3" name="msgText" class="form-control"></textarea>
                                        </div>
                                    </div>

                                </section>

                                <footer class="form-footer text-sm-center">
                                    <input type="hidden" name="id_order" value="8">
                                    <button type="submit" name="submitMessage"
                                        class="btn btn-primary form-control-submit">
                                        Send
                                    </button>
                                </footer>

                            </form>
                        </section>



                    </section>

                    <?php
                            } else {
                                ?>
                    <!-- Total Order Details  -->

                    <header class="page-header">
                        <h1>
                            Order history
                        </h1>
                    </header>

                    <section id="content" class="page-content">

                        <h6>Here are the orders you've placed since your account was created.</h6>

                        <table class="table table-striped table-bordered table-labeled hidden-sm-down">
                            <thead class="thead-default">
                                <tr>
                                    <th>Order ID</th>
                                    <th>Date</th>
                                    <th>Total price</th>
                                    <th class="hidden-md-down">Payment</th>
                                    <th class="hidden-md-down">Status</th>
                                    <th>Invoice</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                                $uid = $user['id'];
                                                $Sql = "SELECT * FROM payment_details where payment_user_id = '$uid' order by id desc";
                                                $res = mysqli_query($con, $Sql);
                                                while ($row = mysqli_fetch_assoc($res)) {
                                                    ?>
                                <tr>
                                    <th scope="row"><?= $row['Order_Id'] ?></th>
                                    <td><?= date("d M,Y h:i:s A", strtotime($row['created'])) ?></td>
                                    <td class="text-xs-right">₹ <?= $row['amount_captured'] ?></td>
                                    <td class="hidden-md-down">By Card</td>
                                    <td>
                                        <?php
                                            if($row['payment_status'] == 'succeeded') {
                                                // Done 
                                                $text = 'Success';
                                                $color = 'green';
                                            }else{
                                                // Error 
                                                $text = 'Error';
                                                $color = 'red';
                                            }
                                        ?>
                                        <span class="label label-pill bright" style="background-color:<?= $color ?> ">
                                            <?= $text ?>
                                        </span>
                                    </td>
                                    <td class="text-sm-center hidden-md-down">
                                        <a href="">Download</a>
                                    </td>
                                    <td class="text-sm-center order-actions">
                                        <a href="<?= FRONT_SITE_PATH.'order-history?orderDetails='.$row['Order_Id'] ?>"
                                            data-link-action="view-order-details">
                                            Details
                                        </a>
                                        <!-- <a
                                                                href="https://rubiktheme.com/demo/rb_evo_demo/en/order?submitReorder=&amp;id_order=8">Reorder</a> -->
                                    </td>
                                </tr>
                                <?php
                                                }
                                            ?>


                            </tbody>
                        </table>

                        <div class="orders hidden-md-up">
                            <div class="order">
                                <div class="row">
                                    <?php
                                     $uid = $user['id'];
                                     $Sql = "SELECT * FROM payment_details where payment_user_id = '$uid'";
                                     $res = mysqli_query($con, $Sql);
                                                               
                                                            
                                         while ($row = mysqli_fetch_assoc($res)) {
                                            if($row['payment_status'] == 'succeeded') {
                                                // Done 
                                                $text = 'Success';
                                                $color = 'green';
                                            }else{
                                                // Error 
                                                $text = 'Error';
                                                $color = 'red';
                                            }
                                            ?>
                                    <div class="col-xs-10">
                                        <a href="<?= FRONT_SITE_PATH.'order-history?orderDetails='.$row['Order_Id'] ?>">
                                            <h3><?= $row['Order_Id'] ?></h3>
                                        </a>
                                        <div class="date"><?= date("d-m-Y", $row['created']) ?></div>
                                        <div class="total">₹ <?= $row['amount_captured'] ?></div>
                                        <div class="status" style='height: 51px;margin-top: 10px;'>
                                            <span class="label label-pill bright"
                                                style="background-color:<?= $color ?>;background-color: green;padding: 10px;color: #fff;">
                                                <?= $text ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-xs-2 text-xs-right">
                                        <div>
                                            <a href="<?= FRONT_SITE_PATH.'order-history?orderDetails='.$row['Order_Id'] ?>"
                                                data-link-action="view-order-details" title="Details">
                                                <i class="material-icons"></i>
                                            </a>
                                        </div>
                                        <div>
                                            <!-- <a href="https://rubiktheme.com/demo/rb_evo_demo/en/order?submitReorder=&amp;id_order=8"
                                                title="Reorder">
                                                <i class="material-icons"></i>
                                            </a> -->
                                        </div>
                                    </div>
                                    <?php
                                         }
                                    ?>

                                </div>
                            </div>
                        </div>


                    </section>

                    <footer class="page-footer">
                        <a href="<?= FRONT_SITE_PATH.'identity' ?>" class="btn account-link">
                            <i class="material-icons"></i>
                            <span>Back to your account</span>
                        </a>
                        <a href="<?= FRONT_SITE_PATH ?>" class="btn account-link">
                            <i class="material-icons"></i>
                            <span>Home</span>
                        </a>



                    </footer>

                    <?php
                            }
                        ?>


                </section>



            </div>



        </div>

    </div>

</section>


<?php
            require 'includes/footer.php'
        ?>