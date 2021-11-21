<?php
    require 'includes/header.php';
?>

<section id="wrapper">

    <nav data-depth="3" class="breadcrumb">
        <div class="container">
            <ol itemscope="" itemtype="http://schema.org/BreadcrumbList" class="p-a-0">

                <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                    <a itemprop="item" href="<?= FRONT_SITE_PATH ?>">
                        <span itemprop="name">Home</span>
                    </a>
                    <meta itemprop="position" content="1">
                </li>


                <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                    <a itemprop="item" href="<?= FRONT_SITE_PATH.'identity' ?>">
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
                                        <!-- <a href="#"
                                                class="button-primary">Reorder</a> -->
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
                                    <address><?= $row['delivery_address_id'] ?></address>
                                </article>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <article id="invoice-address" class="box">
                                    <h4>Invoice address </h4>
                                    <address><?= $row['delivery_address_id'] ?></address>
                                </article>
                            </div>
                            <div class="clearfix"></div>
                        </div>


                        <div class="box table-responsive">
                            <table id="order-products" class="table table-bordered ">
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
                                        
                                        $track_id = explode(",",$row['tracking_id']);
                                        foreach ($product_ids as $key => $value) {
                                            $Prdsql = "SELECT * from product_details where id = '$value'";
                                            $Prdres = mysqli_query($con , $Prdsql);
                                            
                                            $track_res = SqlQuery("SELECT * FROM ordertrackingdetails WHERE track_id = '$track_id[$key]'");
                                            $track_row = mysqli_fetch_assoc($track_res);
                                            $current_status_track = explode(",",$track_row['Current_Status']);

                                            if (in_array("Delivered",$current_status_track)) {
                                                $rate_res = SqlQuery("SELECT * FROM product_rating where Track_id = '".$track_row['track_id']."'");
                                                $rate_row = mysqli_fetch_assoc($rate_res);
                                                
                                                if ($rate_row != '') {
                                                    $appen_table_head = '<th>Rated</th>';
                                                    $star_rate = '<span class="float-right">
                                                                '.star_rate($rate_row['rated_no']).'               
                                                              </span>';    
                                                    $appen_table_body = '<td>'.$star_rate.'</td>';
                                                }else{
                                                    $appen_table_head = '<th>Rate Now</th>';
                                                    // rating_system_add
                                                    $star_rate = "<a href=".FRONT_SITE_PATH.'trackmyorder?track_id='.$track_id[$key].'&Order_id='.$row['Order_Id'].'#rating_system_add'." target='_blank'>Rate this product</a>";
                                                    $appen_table_body = '<td>'.$star_rate.'</td>';
                                                }
                                                
                                            }else{
                                                $star_rate = '';
                                                $appen_table_head = '';
                                                $appen_table_body = '';
                                            }
                
                                            while ($Prdrow = mysqli_fetch_assoc($Prdres)) {
                                                $ProductImageById = ProductImageById($Prdrow['id'],"limit 1");
                                                array_unshift($ProductImageById,"");
                                                unset($ProductImageById[0]);

                                                $product_varient = explode(',', $row['product_varient']);

                                                $product_qty = explode(',', $row['product_qty']);
                                                    
                                                $payment_prod_price = explode(',', $row['payment_prod_price']);
                                               
                                                $product_message = explode(",PSFASHIONSTORE,",$row['product_message']);

                                                $estimate_delivery_date = explode(',', $row['estimate_delivery_date']);

                                                $per_product_invoice = explode(',', $row['per_product_invoice']);

                                                $message_display = '';
                                                if(!empty($product_message[$key])){
                                                    $message_display .= ' <textarea class="form-control" rows="10" id="textareacommentorder_'.$orderDetails.'" disabled>'.$product_message[$key].'</textarea>';
                                                }
                                            ?>

                                    <tr>
                                        <td>
                                            <img style="width:5rem;height:100%;max-width: 5rem;" src="<?= FRONT_SITE_IMAGE_PRODUCT.$ProductImageById[1]['product_img'] ?>" >
                                        </td>
                                        <td>
                                            <strong>
                                                <a>
                                                    <?= $Prdrow['product_name'] ?>
                                                </a>
                                            </strong><br>

                                            Size: <?= $product_varient[$key] ?><br>
                                            <table class="table table-striped">
                                                <thead>
                                                    <th>Estimate Delivery</th>
                                                    <th>Tracking Id</th>
                                                    <th>Current Status</th>
                                                    <th>Download Invoice</th>
                                                    <?= $appen_table_head ?>
                                                </thead>
                                                <tbody>
                                                    <td><?= date("D M d, Y", strtotime($estimate_delivery_date[$key])) ?></td>
                                                    <td><a href="<?= FRONT_SITE_PATH.'trackmyorder?track_id='.$track_id[$key].'&Order_id='.$row['Order_Id'] ?>" target="_blank"><?= $track_id[$key] ?></a></td>
                                                    <td><span style="color:green"><?= end($current_status_track) ?></td>
                                                    <th><a href="javascript:void(0)" id='DownloadInvoiceAtag_<?= $Prdrow['id'] ?>' onclick="DownloadInvoice('<?= $orderDetails ?>', '<?= $Prdrow['id'] ?>', '<?= $product_qty[$key] ?>', '<?= $product_varient[$key] ?>', '<?= $payment_prod_price[$key] ?>', '<?= $per_product_invoice[$key] ?>','<?= $page_url ?>')">Download</a></th>
                                                    <?= $appen_table_body ?>
                                                </tbody>
                                            </table>
                                            <div id="mesage_display_order_<?= $key ?>"
                                                class="callout callout-success mt-2">
                                                <?= $message_display ?>
                                            </div>
                                        </td>
                                        <td>
                                            <?= $product_qty[$key] ?>
                                        </td>
                                        <td class="text-xs-right">₹ <?= number_format($payment_prod_price[$key])  ?></td>
                                        <td class="text-xs-right">₹ <?= number_format($product_qty[$key] * $payment_prod_price[$key]) ?></td>
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

                        <div class="box">
                            <table class="table table-striped table-bordered hidden-sm-down">
                                <thead class="thead-default">
                                    <tr>
                                        <th>Date</th>
                                        <th>Carrier</th>
                                        <th>Shipping cost</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?= date("d-m-Y", strtotime("+1 day", strtotime($row['created']))); ?></td>
                                        <td>My carrier</td>
                                        <td><?= $shipping_fee ?></td>

                                    </tr>
                                </tbody>
                            </table>
                            <div class="hidden-md-up shipping-lines">
                                <div class="shipping-line">
                                    <ul>
                                        <li>
                                            <strong>Date</strong>
                                            <?=  date("d-m-Y", strtotime("+1 day", strtotime($row['created']))); ?>
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
                            <?php

                                
                            ?>
                            <form action="" id="addcommentforyourOrder" method="post">
                                <input type="hidden" name="order_id" value="<?= $orderDetails ?>">
                                <header>
                                    <h3>Add a message</h3>
                                    <p>If you would like to add a comment about your order, please write it in
                                        the field below before your product get Shipped</p>
                                </header>

                                <section class="form-fields">
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Product</label>
                                        <div class="col-md-5">
                                            <select name="addcommentforyourOrder" class="form-control form-control-select" required>
                                                <option value="" disabled selected>-- please choose --</option>
                                                <?php
                                                $product_id_comment =explode(",", $row['product_id']);
                                                foreach ($product_id_comment as $key => $value) {
                                                    $Prdsql = "SELECT * from product_details where id = '$value'";
                                                    $Prdres = mysqli_query($con , $Prdsql);
                                                    $product_varient = explode(',', $row['product_varient']);
                                                   
                                                    $track_res = SqlQuery("SELECT * FROM ordertrackingdetails WHERE track_id = '$track_id[$key]'");
                                                    $track_row = mysqli_fetch_assoc($track_res);

                                                    $current_status = explode(",",$track_row['Current_Status']);
                                                    if (in_array("Shipped",$current_status)) {
                                                        $selected = 'disabled';
                                                        $message = '- Product '.end($current_status);
                                                        $color_opt = 'red';
                                                    }else{
                                                        $selected = '';
                                                        $message = '';
                                                        $color_opt = '';
                                                    }

                                                    foreach($Prdres as $prd_key => $Prdrow) {
                                                        
                                                            ?>
                                                            <option style="color:<?= $color_opt ?>" value="<?= $key ?>" <?= $selected ?>><?= $Prdrow['product_name'].' - ('.$product_varient[$key].')'.' '.$message ?>
                                                            </option>
                                                            <?php
                                                        
                                                    }
                                                 }
                                            ?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label"></label>
                                        <div class="col-md-9">
                                            <textarea rows="3" name="msgText" class="form-control addcomentfororder"
                                                required></textarea>
                                        </div>
                                    </div>

                                </section>

                                <footer class="form-footer text-sm-center">
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
                                    <th scope="row"><?= $row['Order_Id'].' - ('.count(explode(",",$row['product_id'])).' items)' ?></th>
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
                                        <a
                                            href="download?filename=<?= $row['invoice_file'] ?>&filepath=UserInvoice/<?= $row['invoice_file'] ?>&redirect=<?= $url ?>">Download</a>
                                    </td>
                                    <td class="text-sm-center order-actions">
                                        <a href="<?= FRONT_SITE_PATH.'order-history?orderDetails='.$row['Order_Id'] ?>"
                                            data-link-action="view-order-details">
                                            Details
                                        </a>

                                    </td>
                                </tr>
                                <?php
                                                }
                                            ?>


                            </tbody>
                        </table>

                        <div class="orders hidden-md-up mt-2">
                            <div class="order">
                                <div class="row">
                                    <?php
                                     $uid = $user['id'];
                                     $Sql = "SELECT * FROM payment_details where payment_user_id = '$uid'  order by id desc";
                                     $res = mysqli_query($con, $Sql);
                                                               
                                                            
                                         while ($row = mysqli_fetch_assoc($res)) {
                                            if($row['payment_status'] == 'succeeded') {
                                                // Done 
                                                $text = '<i class="fa fa-check-circle text-success" aria-hidden="true"></i>';
                                                $color = 'green';
                                            }else{
                                                // Error 
                                                $text = '<i class="fa fa-times-circle text-danger"  aria-hidden="true"></i>';
                                                $color = 'red';
                                            }
                                            ?>
                                    <div class="col-xs-8 mt-2">
                                        <a href="<?= FRONT_SITE_PATH.'order-history?orderDetails='.$row['Order_Id'] ?>">
                                            <h3><?= $row['Order_Id'].' - ('.count(explode(",",$row['product_id'])).' items Ordered)' ?></h3>
                                        </a>
                                        <div class="date"><?= date("D M d, Y h:i A", strtotime($row['created'])) ?></div>
                                        <div class="total">₹ <?= $row['amount_captured'] ?></div>
                                        
                                    </div>
                                    <div class="col-xs-4 mt-2 text-xs-right">
                                        <div>
                                            <a href="<?= FRONT_SITE_PATH.'order-history?orderDetails='.$row['Order_Id'] ?>"
                                                data-link-action="view-order-details" title="Details">
                                                <i class="material-icons"></i>
                                            </a>
                                            <a href="download?filename=<?= $row['invoice_file'] ?>&redirect=<?= $url ?>"
                                                data-link-action="view-order-details" title="Download Invoice">
                                                <i class="fa fa-download"></i>
                                            </a>
                                            <a href="javacript:void(0)" title="Payment Status"><?= $text ?></a>
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