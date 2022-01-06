<?php
    require 'includes/header.php';
    if (isset($_GET['action']) && $_GET['action'] == 'topup') {
        require('config.php');
        ?>
         <section id="wrapper">
            <nav data-depth="2" class="breadcrumb">
                <div class="container">
                    <ol itemscope="" itemtype="http://schema.org/BreadcrumbList" class="p-a-0">
                        <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"> <a itemprop="item"
                                href="<?= FRONT_SITE_PATH ?>"> <span itemprop="name">Home</span> </a>
                            <meta itemprop="position" content="1">
                        </li>
                        <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"> <a itemprop="item"
                                href="<?= FRONT_SITE_PATH.'identity' ?>"> <span itemprop="name"><?=  $user['firstname'].' '.$user['lastname'].' - My Account'; ?></span> </a>
                            <meta itemprop="position" content="2">
                        </li>
                        <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"> <a itemprop="item"
                                href="<?= FRONT_SITE_PATH.'wallet' ?>"> <span itemprop="name">Wallet</span> </a>
                            <meta itemprop="position" content="3">
                        </li>
                        <li> <span>Top up</span></li>
                    </ol>
                </div>
            </nav>
        </section>   

        <div class="content" style="background:#FEE3EC">
            <div id="mainContent" style="margin: 28px auto 0;max-width: 600px;padding:50px 0;">
                <div class="card pl-2 pt-1  pr-1" style="background:#fff;border-left: 5px solid #2CD2B1">
                    <h5><strong>Info:</strong></h5>
                    <p>Top-up amount will be added in the <?= CASH_LABEL_NAME ?> Balance</p>
                </div>
                <div class="card p-1" style="background:#fff">
                    <div class="row">
                        <h5 class="col-xs-8">Available <?= CASH_LABEL_NAME ?> Balance</h5>
                        <h5 class="col-xs-4" style="text-align:right"><?= "₹".number_format($FetchUserWalletAmt['Total_WalletAmt'],2) ?> </h5>
                    </div>
                    <hr>
                    <p class="lead">Top-up Your <?= CASH_LABEL_NAME ?></p>
                    <div class="form-group row">
                        <div class="radio custom col-xs-4 col-lg-3">
                            <label>
                                <input type="radio"  name="AmountSelectToAdd" value="100">
                                ₹100
                            </label>
                        </div>
                        <div class="radio custom col-xs-4 col-lg-3">
                            <label>
                                <input type="radio" name="AmountSelectToAdd" value="500">
                                ₹500
                            </label>
                        </div>
                        <div class="radio custom col-xs-4 col-lg-3">
                            <label>
                                <input type="radio" name="AmountSelectToAdd" value="1000">
                                ₹1,000
                            </label>
                        </div>
                        <div class="radio custom col-xs-4 col-lg-3">
                            <label>
                                <input type="radio" name="AmountSelectToAdd" value="1500">
                                ₹1,500
                            </label>
                        </div>
                        <div class="radio custom col-xs-4 col-lg-3">
                            <label>
                                <input type="radio" name="AmountSelectToAdd" value="2000">
                                ₹2,000
                            </label>
                        </div>

                        <div class="radio custom col-xs-4 col-lg-3">
                            <label>
                                <input type="radio" name="AmountSelectToAdd" value="2500">
                                ₹2,500
                            </label>
                        </div>
                    </div>  
                    <div class="form-group">
                        <label for="amount_input">₹ Enter an amount (eg:1000)</label>
                        <input type="number" id="amount_input" placeholder="₹ Enter an amount (eg:1000)" class="form-control">
                    </div> 
                    <div class="form-group">
                        <form action="refillwallet.php" method="post">
                            <input type="hidden" id="amountselecttopay" name="amountselecttopay" value=""> 
                            <script defer src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                data-key="<?php echo $publishableKey?>"
                                data-name="Programming with Shadab"
                                data-description="Programming with Shadab Desc"
                                data-image="https://pbs.twimg.com/profile_images/932986247642939392/CDq_0Vcw_400x400.jpg"
                                data-currency="inr" data-email="ks615044@gmail.com">
                            </script>
                        </form>
                   
                    </div>
                    
                </div>
            </div>
        </div>
        <?php
    }else{
        ?>
        <section id="wrapper">
            <nav data-depth="2" class="breadcrumb">
                <div class="container">
                    <ol itemscope="" itemtype="http://schema.org/BreadcrumbList" class="p-a-0">
                        <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"> <a itemprop="item"
                                href="<?= FRONT_SITE_PATH ?>"> <span itemprop="name">Home</span> </a>
                            <meta itemprop="position" content="1">
                        </li>
                        <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"> <a itemprop="item"
                                href="<?= FRONT_SITE_PATH.'identity' ?>"> <span itemprop="name"><?=  $user['firstname'].' '.$user['lastname'].' - My Account'; ?></span> </a>
                            <meta itemprop="position" content="2">
                        </li>
                        <li> <span>Wallet</span></li>
                    </ol>
                </div>
            </nav>
        </section>   

        <div class="border p-2 text-height-1" style="widht:400px;margin: 28px auto 0;max-width: 800px;padding:">
            <h5 class="text-success  text-center lead display-4">TOTAL AVAILABLE <?= CASH_LABEL_NAME ?></h5>
            <h1 class="display-2  text-center "><?= "₹".number_format($FetchUserWalletAmt['Total_WalletAmt'],2)  ?></h1>
            <p class="lead text-center ">Your total <?= CASH_LABEL_NAME ?> is worth <?= "₹".number_format($FetchUserWalletAmt['Total_WalletAmt'],2) ?></p>
            <hr>
            <div class="row text-center mt-5">
                <div class="col-xs-6">
                    <p class="lead text-muted">Add Balance</p>
                    <a href="<?= FRONT_SITE_PATH.'wallet?action=topup' ?>" class="text-info font-weight-bold">TOP UP</a>
                </div>
                <div class="col-xs-6">
                    <p class="lead text-muted">Have a Gift Card ?</p>
                    <a href="" class="text-info font-weight-bold">ADD GIFT CARD</a>
                </div>
            </div>
        </div>
        <div class="border p-2 " style="widht:400px;margin: 28px auto 0;max-width: 800px;">
            <h6 class="text-muted font-weight-bold">TOTAL AVAILABLE <?= CASH_LABEL_NAME ?></h5>
            <hr>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th width="40%">Description</th>
                            <th width="20%">Credit</th>
                            <th width="20%">Debit</th>
                            <th width="20%">Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                            if (isset($FetchUserWalletAmt['WalletAmt'])) {
                                $WalletAmt = explode(",",$FetchUserWalletAmt['WalletAmt']);
                                $Notes_Wallet = explode(",PS_FASHION_STORE,",$FetchUserWalletAmt['Notes_Wallet']);
                                $Transact_Date = explode(",",$FetchUserWalletAmt['Transact_Date']);
                                $transact_type = explode(",",$FetchUserWalletAmt['transact_type']);
                                foreach ($Notes_Wallet as $key => $value) {
                                    if ($transact_type[$key] == 'in') {
                                        $table_text_color = 'text-success';
                                        $WalletAmt_credit = $WalletAmt[$key];
                                        $WalletAmt_debit = 0;
                                    }else{
                                        $table_text_color = 'text-danger';
                                        $WalletAmt_credit = 0;
                                        $WalletAmt_debit = $WalletAmt[$key];
                                    }
        
                                    if (!isset($WalletAmt[$key - 1])) {
                                        $PreviousWalletAmount = 0;
                                    }else{
                                        $PreviousWalletAmount = $WalletAmt[$key - 1];
                                    }
        
                                    $FinalBalance = $PreviousWalletAmount + $WalletAmt[$key];
                                    $WalletAmt[$key] = $FinalBalance; // After Calculating Final we are setting current amount as final value and current value is getting added by Previous value as shown in above line.
                                    ?>
                                        <tr>
                                            <td>
                                                <h5 class="<?= $table_text_color ?>">
                                                    <?= $value ?>
                                                </h5>
                                                <p><?= date("d M,Y h:i A", strtotime($Transact_Date[$key])) ?></p>
                                            </td>
                                            <td><h5 class="<?= $table_text_color ?>"><?=  "₹ ".number_format($WalletAmt_credit,2) ?></h5></td>
                                            <td><h5 class="<?= $table_text_color ?>"><?= "₹ ".number_format($WalletAmt_debit,2) ?></h5> </td>
                                            <td><h5 class="<?= $table_text_color ?>"><?= "₹ ".number_format($FinalBalance,2) ?></h5></td>
                                        </tr>
                                    <?php
                                }
                            }else{
                                ?>
                                    <tr>
                                        <td colspan="4" class="text-center">No Record Found</td>
                                    </tr>
                                <?php
                            }
                        
                    ?>   
                    </tbody>
                </table>
            </div>
        </div>
        <?php
    }

    require 'includes/footer.php';
?>

<script>
    $('input[type=radio][name=AmountSelectToAdd]').on('change', function() {
        var selectedamt = $(this).val();
        $("#amount_input, #amountselecttopay").val(selectedamt);
    });
    $("#amount_input").on("keyup", () => {
        $("#amountselecttopay").val($("#amount_input").val());
    })
</script>