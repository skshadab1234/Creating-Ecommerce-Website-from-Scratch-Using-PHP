<?php
    require 'includes/header.php';
    if($getCartTotal == 0){
        redirect(FRONT_SITE_PATH);
    }
    require('config.php');
    unset($_SESSION['id_address_delivery']);    
?>
<section id="wrapper">

    <div class="container">
        <section id="content">
            <div class="row">
                <div class="cart-grid-body col-xs-12 col-lg-8">
                    <section id="checkout-personal-information-step"
                        class="checkout-step -reachable -complete -clickable">
                        <h1 class="step-title h3">
                            <i class="material-icons rtl-no-flip done">&#xE876;</i>
                            <span class="step-number">1</span>
                            Personal Information
                            <span class="step-edit text-muted"><i class="fa fa-pencil-square-o"></i></span>
                        </h1>
                        <div class="content">
                            <p class="identity">
                                Connected as <a
                                    href="<?= FRONT_SITE_PATH ?>identity"><?= $user['firstname'].' '.$user['lastname'] ?></a>.
                            </p>
                            <p>
                                Not you? <a href="<?= FRONT_SITE_PATH.'logout' ?>">Log out</a>
                            </p>
                            <p><small>If you sign out now, your cart will be emptied.</small></p>

                            <div class="clearfix">
                                <form method="GET" action="">
                                    <button class="continue btn btn-primary float-xs-right" name="controller"
                                        type="submit" value="order">
                                        Continue
                                    </button>
                                </form>
                            </div>
                        </div>
                    </section>
                    <!-- -current -reachable js-current-step -clickable -->
                    <?php
                        if(isset($_SESSION['id_address_delivery']) && $_SESSION['id_address_delivery'] > 0){
                            $setClass = 'checkout-step -reachable -clickable -complete';
                            $setPayClass = 'checkout-step -current -reachable js-current-step -clickable';
                        }else {
                            $setClass = 'checkout-step -current -reachable js-current-step -clickable';
                            $setPayClass = 'checkout-step current -reachable -clickable -unreachable';
                        }
                    ?>
                    <section class="<?= $setClass ?>" id="checkout-addresses-step">
                        <h1 class="step-title h3">
                            <i class="material-icons rtl-no-flip done"></i>
                            <span class="step-number">2</span>
                            Addresses
                            <span class="step-edit text-muted"><i class="fa fa-pencil-square-o"></i></span>
                        </h1>

                        <div class="content">
                            <div class="js-address-form">
                                <form method="POST" action="" id='submitAddress'>

                                    <p>
                                        The selected address will be used both as your personal address (for
                                        invoice) and as your delivery address.
                                    </p>

                                    <div id="delivery-addresses" class="address-selector js-address-selector">
                                        <?php
                                            $addresss_data = FetchUserAddresssDetails($user['id']);
                                            if (empty($addresss_data)) {
                                                $FOOTERBUTTON = '';
                                            }else {
                                                $FOOTERBUTTON = '<footer class="form-footer clearfix">
                                                                    <button type="submit" class="continue btn btn-primary float-xs-right"
                                                                        name="confirm-addresses" id="continue_address">
                                                                        Continue
                                                                    </button>

                                                                    <div class="page-loading-overlay main-product-details-loading"
                                                                        style="position:absolute"></div>
                                                                </footer>';
                                                                
                                                foreach ($addresss_data as $key => $value) {
                                                    if (isset($_SESSION['id_address_delivery'])) {
                                                        if ($_SESSION['id_address_delivery'] == $value['id']) {
                                                            $setCheck = 'checked';
                                                            $selected = 'selected';
                                                        }else{
                                                            $setCheck = '';
                                                            $selected = '';
                                                        }
                                                    }else {
                                                        if($value['default_address'] > 0){
                                                            $setCheck = 'checked';
                                                            $selected = 'selected';
                                                        }else {
                                                            $setCheck = '';
                                                            $selected = '';
                                                        }
                                                    }
                                                    ?>
                                                <article class="address-item <?= $selected ?>"
                                                    id="id-address-delivery-address-15">
                                                    <header class="h4">
                                                        <label class="radio-block">
                                                            <span class="custom-radio">
                                                                <input type="radio" name="id_address_delivery" <?= $setCheck ?>
                                                                    value="<?= $value['id'] ?>" required>
                                                                <span></span>
                                                            </span>
                                                            <span
                                                                class="address-alias h4"><?= $value['add_firstname'].' '.$value['add_lastname'] ?></span>
                                                            <div class="address">
                                                                <?= $value['company'] ?><br><?= $value['address'] ?><br><?= $value['addres_complement'] ?><br><?= $value['city'].', '.$value['state'].'-'.$value['postal_code'] ?><br><?= $value['country'] ?><br><?= $value['phone_number'] ?>
                                                            </div>
                                                        </label>
                                                    </header>
                                                    <hr>
                                                    <footer class="address-footer">
                                                        <a class="edit-address text-muted" data-link-action="edit-address"
                                                            href="<?= FRONT_SITE_PATH.'addresses?controller=update&id='.$value['id'].'&redirect='.$url.'' ?>">
                                                            <i class="fa fa-pencil-square-o edit"></i>Edit
                                                        </a>
                                                        <a class="delete-address text-muted" data-link-action="delete-address"
                                                            href="<?= FRONT_SITE_PATH.'addresses?controller=delete&id='.$value['id'].'&redirect='.$url ?>">
                                                            <i class="fa fa-trash-o delete"></i>Delete
                                                        </a>
                                                    </footer>
                                                </article>
                                            <?php
                                            }
                                        } 
                                         ?>

                                    </div>

                                    <div id="delivery-address">

                                        <div class="js-address-form">

                                            <div class="addresses-footer" style="margin: 10px;">
                                                <a href="<?= FRONT_SITE_PATH.'addresses?controller=add&redirect='.$page_url  ?>"
                                                    data-link-action="add-address">
                                                    <i class="material-icons"></i>
                                                    <span>Create new address</span>
                                                </a>
                                            </div>

                                            <?= $FOOTERBUTTON ?>    



                                        </div>


                                    </div>

                                </form>




                            </div>

                        </div>

                    </section>


                    <section class="<?= $setPayClass ?>" id="checkout-payment-step">

                        <h1 class="step-title h3">
                            <i class="material-icons rtl-no-flip done"></i>
                            <span class="step-number">3</span>
                            Payment
                            <span class="step-edit text-muted"><i class="fa fa-pencil-square-o"></i></span>
                        </h1>


                        <div class="content">

                            <div class="js-cart-payment-step-refresh"></div>


                            <section id="order-summary-content" class="page-content page-order-confirmation">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="h4 black">Please check your order before payment</h4>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="h4">
                                            Addresses
                                            <span class="step-edit step-to-addresses js-edit-addresses"><i
                                                    class="material-icons edit">mode_edit</i> edit</span>
                                        </h4>
                                    </div>
                                </div>

                                <?php
                                    
                                ?>
                                <div class="row" id='payment_confirm_address'>
                                            
                                </div>

                                <div class="row">

                                    <div id="order-items" class="col-md-12">
                                        <div class="row">

                                            <h3 class="card-title h3 col-md-6 col-12">Order items</h3>
                                            <h3 class="card-title h3 col-md-2 text-md-center _desktop-title">Unit price
                                            </h3>
                                            <h3 class="card-title h3 col-md-2 text-md-center _desktop-title">Quantity
                                            </h3>
                                            <h3 class="card-title h3 col-md-2 text-md-center _desktop-title">Total
                                                products</h3>

                                        </div>

                                        <div class="order-confirmation-table">
                                            <div id="product_payment_section">

                                            </div>

                                            <hr>

                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td>Subtotal</td>
                                                        <td class="price-total"></td>
                                                    </tr>
                                                    <tr id="cart-subtotal-shipping">
                                                        <td>Shipping</td>
                                                        <td class="value"></td>
                                                    </tr>
                                                    <tr class="sub taxes">
                                                        <td><span class="label"
                                                                style="font-weight:600;font-size: 20px">Total:</td>
                                                        <td><span class="label" style="font-weight:600;font-size: 20px"
                                                                id="Total_Payabale"></td>
                                                    </tr>
                                                </tbody>
                                            </table>


                                        </div>
                                    </div>

                                </div>
                            </section>

                            <div class="payment-options ">
                                <h5 class="mb-2">Choose Payment Mode:</h5>
                                <div>
                                    <div class="form-group row">
                                        <div class="radio custom col-xs-12 col-lg-4">
                                            <label>
                                                <input type="radio"  name="choosePaymentMode" value="stripe">
                                                <img
                                                    src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/ba/Stripe_Logo%2C_revised_2016.svg/2560px-Stripe_Logo%2C_revised_2016.svg.png"
                                                    alt="" style="width: 100px;height: 50px;"> 
                                            </label>
                                        </div>
                                        <div class="radio custom col-xs-12 col-lg-4">
                                            <label>
                                                <?php
                                                 $uid = $user['id'];
                                                 $sql = "SELECT *, cart.id as cid FROM `cart` left join product_details on cart.product_id = product_details.id where cart.user_id = '$uid'";
                                                 $result = mysqli_query($con , $sql);
                                                  $price_total = "";
                                                 if (mysqli_num_rows($result) > 0) {
                                                     while ($row = mysqli_fetch_assoc($result)) {
                                                         $price_total = $price_total.",";
                                                         $price_total .= $row['product_price'] * $row['qty'];
                                                         $price_total_arr = explode(",", $price_total);
                                                         $price_total = array_sum($price_total_arr);
                                                     }
         
                                                     if($price_total > 500) {
                                                         $total_payable = $price_total;
                                                     }else {
                                                         $total_payable = ($price_total + 500);
                                                     }
                                                 }   

                                                    $disabledRadioButton = '';
                                                    $disp_color = 'text-success';
                                                    if($FetchUserWalletAmt['Total_WalletAmt'] < $total_payable ) {
                                                        $disabledRadioButton = "disabled";
                                                        $disp_color = 'text-danger';
                                                    }
                                                ?>
                                                <input type="radio"  name="choosePaymentMode" <?= $disabledRadioButton ?> value="wallet">
                                                <img
                                                    src="https://www.kindpng.com/picc/m/421-4213376_credit-wallet-png-icon-transparent-png.png"
                                                    alt="" style="width: 50px;height: 50px;"><span class="<?= $disp_color ?>">(<?= "₹".number_format($FetchUserWalletAmt['Total_WalletAmt'],2) ?>)</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div id="payment-confirmation">
                                <div class="ps-shown-by-js">
                                    <div id="PayWithStripe"  style="display:none">
                                        <form action="submit.php" method="post">
                                            <input type="hidden" name="btnname" value="stripe">
                                            <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                                data-key="<?php echo $publishableKey?>"
                                                data-amount="<?= $total_payable * 100?>"
                                                data-name="Programming with Shadab"
                                                data-description="Programming with Shadab Desc"
                                                data-image="https://pbs.twimg.com/profile_images/932986247642939392/CDq_0Vcw_400x400.jpg"
                                                data-currency="inr" data-email="ks615044@gmail.com">
                                            </script>
                                        </form>
                                    </div>
                                    <div class="form-group" id="payfromwallet" style="display:none">
                                        <form action="submit.php" method="post">
                                            <input type="hidden" name="btnname" value="wallet">
                                            <button type="submit" class="btn btn-primary form-control">Pay From Wallet</button>
                                        </form>
                                    </div>
                                </div>
                            </div>



                            <div class="modal fade" id="modal">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <div class="js-modal-content"></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </section>
                </div>

                <div class="cart-grid-right col-xs-12 col-lg-4">
                    <section id="js-checkout-summary" class="card js-cart rb-cart-checkout">
                        <div class="card-block">
                            <div class="cart-summary-products">
                                <div class="head-cart-total">
                                    <h4>Cart totals</h4>
                                    <p><span class="js-subtotal"></span> </p>
                                </div>
                                <p>
                                    <a href="#" data-toggle="collapse" data-target="#cart-summary-product-list">
                                        show details
                                        <i class="material-icons">expand_more</i>
                                    </a>
                                </p>


                                <div class="collapse" id="cart-summary-product-list">
                                    <ul class="media-list" id="detaills_page_data">

                                    </ul>
                                </div>

                            </div>

                            <div class="card-block cart-summary-subtotals-container">

                                <div class="cart-summary-line cart-summary-subtotals" id="cart-subtotal-products">

                                    <span class="label">
                                        Subtotal
                                    </span>

                                    <span class="value">
                                        $38.24
                                    </span>
                                </div>
                                <div class="cart-summary-line cart-summary-subtotals" id="cart-subtotal-shipping">

                                    <span class="label">
                                        Shipping
                                    </span>

                                    <span class="value">
                                        $7.00
                                    </span>
                                </div>

                            </div>
                        </div>

                        <div class="card-block cart-summary-totals">

                            <div class="cart-summary-line">
                                <span class="label sub">Total Payable:</span>
                                <span class="value sub" id='Total_Payabale'>$0.00</span>
                            </div>


                        </div>


                    </section>


                    <div class="block-reassurance">
                        <ul>
                            <li>
                                <div class="block-reassurance-item">
                                    <img src="media/security.svg" alt="Security policy">
                                    <div>
                                        <span style="color:#000000;">Security policy</span>
                                        <p style="color:#000000;">(edit with the Customer Reassurance module)</p>

                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="block-reassurance-item">
                                    <img src="media/carrier.svg" alt="Delivery policy">
                                    <div>
                                        <span style="color:#000000;">Delivery policy</span>
                                        <p style="color:#000000;">(edit with the Customer Reassurance module)</p>

                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="block-reassurance-item">
                                    <img src="media/parcel.svg" alt="Return policy">
                                    <div>
                                        <span style="color:#000000;">Return policy</span>
                                        <p style="color:#000000;">(edit with the Customer Reassurance module)</p>

                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </section>

    </div>

</section>

<?php
require 'includes/footer.php';
?>

<script>
    $('input[type=radio][name=choosePaymentMode]').on('change', function() {
        if($(this).val() == 'stripe'){
            $("#PayWithStripe").show();
            $("#payfromwallet").hide();
        }

        else if($(this).val() == 'wallet') {
            $("#PayWithStripe").hide();
            $("#payfromwallet").show();
        }
    });
</script>