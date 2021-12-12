<?php
require 'includes/header.php';
if (isset($_GET['track_id']) && $_GET['track_id'] > 0 && isset($_GET['Order_id']) && $_GET['Order_id'] != '') {
    $track_id = get_safe_value($_GET['track_id']);
    $Order_id = get_safe_value($_GET['Order_id']);

    // Here i am trying to get product details from track id 
    $res = SqlQuery("SELECT * FROM payment_details WHERE Order_Id = '$Order_id'");
    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $db_track_ids = explode(",",$row['tracking_id']);
        $track_id_index = array_search($track_id, $db_track_ids);
        
        // Here Product Id Exploding 
        $product_id_array = explode(",",$row['product_id']);
        $payment_prod_price = explode(",",$row['payment_prod_price']);
        $product_qty = explode(",",$row['product_qty']);
        $product_size_array = explode(",",$row['product_varient']);
        $estimate_delivery_date_array = explode(",",$row['estimate_delivery_date']);

        $product_id = $product_id_array[$track_id_index]; // Here we get product id using tracking id Index
        $product_id_res = SqlQuery("SELECT * FROM product_details WHERE id = '$product_id'");
        if (mysqli_num_rows($product_id_res) > 0) {
            $product_row = mysqli_fetch_assoc($product_id_res);
            $ProductImageById = ProductImageById($product_row['id'],"limit 1");
            array_unshift($ProductImageById,"");
            unset($ProductImageById[0]);
        }else{
            redirect(FRONT_SITE_PATH);
        }
    }else{
        redirect(FRONT_SITE_PATH);
    }
}else{
    redirect(FRONT_SITE_PATH);
}
?>
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css"> -->
<style>
    .wrappers_progress {
        width: 100%;
        font-family: 'Helvetica';
        font-size: 14px;
        border: 1px solid #CCC;
        padding: 20px;
    }

    .StepProgress {
        position: relative;
        padding-left: 45px;
        list-style: none;
    }

    .StepProgress::before {
        display: inline-block;
        content: '';
        position: absolute;
        top: 0;
        left: 15px;
        width: 10px;
        height: 100%;
        border-left: 2px solid #CCC;
    }

    .StepProgress-item {
        position: relative;
        counter-increment: list;
    }

    .StepProgress-item:not(:last-child) {
        padding-bottom: 20px;
    }

    .StepProgress-item::before {
        display: inline-block;
        content: '';
        position: absolute;
        left: -30px;
        height: 100%;
        width: 10px;
    }

    .StepProgress-item::after {
        content: '';
        display: inline-block;
        position: absolute;
        top: 0;
        left: -39px;
        width: 20px;
        height: 20px;
        border: 2px solid #CCC;
        border-radius: 50%;
        background-color: #FFF;
    }

    .StepProgress-item.is-done::before {
        border-left: 2px solid green;
    }

    .StepProgress-item.is-done::after {
        content: "✔";
        font-size: 10px;
        color: #FFF;
        text-align: center;
        border: 2px solid green;
        background-color: green;
    }

    .StepProgress-item.is-cancel::before {
        border-left: 2px solid red;
    }

    .StepProgress-item.is-cancel::after {
        content: "X";
        font-size: 10px;
        color: #FFF;
        text-align: center;
        border: 2px solid red;
        background-color: red;
    }

    .StepProgress-item.current::before {
        border-left: 2px solid green;
    }

    .StepProgress-item.current::after {
        content: counter(list);
        padding-top: 1px;
        width: 20px;
        height: 20px;
        top: 0;
        left: -40px;
        font-size: 14px;
        text-align: center;
        color: green;
        border: 2px solid green;
        background-color: white;
    }

    .StepProgress strong {
        display: block;
    }

    @import url(//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css);

    /****** Style Star Rating Widget *****/

    .rating { 
        width: 100%;
        border: none;
    }

    .rating > input { display: none; } 
    .rating > label:before { 
    margin: 5px;
    font-size: 1.25em;
    font-family: FontAwesome;
    display: inline-block;
    content: "\f005";
    }

    .rating > .half:before { 
    content: "\f089";
    position: absolute;
    }

    .rating > label { 
    color: #ddd; 
    float: right; 
    }

    /***** CSS Magic to Highlight Stars on Hover *****/

    .rating > input:checked ~ label, /* show gold star when clicked */
    .rating:not(:checked) > label:hover, /* hover current star */
    .rating:not(:checked) > label:hover ~ label { color: #FFD700;  } /* hover previous stars in list */

    .rating > input:checked + label:hover, /* hover current star when changing rating */
    .rating > input:checked ~ label:hover,
    .rating > label:hover ~ input:checked ~ label, /* lighten current selection */
    .rating > input:checked ~ label:hover ~ label { color: #FFED85;  } 

    .rating_class{
        text-align: center;
        background: green;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #fff;
        font-weight: 900;
        border-radius: 10%;
        font-size: 18px;
        padding: 10px;
    }
</style>

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
                    <a itemprop="item" href="<?= FRONT_SITE_PATH.'order-history?orderDetails='.$Order_id ?>">
                        <span itemprop="name">Order history</span>
                    </a>
                    <meta itemprop="position" content="2">
                </li>


                <li>
                    <span>Track Order</span>
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
                            <?= $Order_id ?> (Estimate Delivery : <?= date("D M d, Y", strtotime($estimate_delivery_date_array[$track_id_index])) ?>)
                        </h1>
                    </header>
                    <section id="content" class="page-content">
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <table id="order-products" class="table table-bordered">
                                    <thead class="thead-default">
                                        <tr>
                                            <th width="10%"></th>
                                            <th>Product Details</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <img class="img-fluid" width="200px" height="200px"
                                                    src="<?= FRONT_SITE_IMAGE_PRODUCT.$ProductImageById[1]['product_img'] ?>"
                                                    alt="" title="" itemprop="image">
                                            </td>
                                            <td>
                                                <strong>
                                                    <?= $product_row['product_name'] ?>
                                                </strong> <br>
                                                Size : <?= $product_size_array[$track_id_index] ?> <br>
                                                Qty :
                                                <?= $product_qty[$track_id_index].' x '.$payment_prod_price[$track_id_index] ?>
                                                <br>
                                                Total Price : <strong>₹
                                                    <?= number_format($product_qty[$track_id_index] *  $payment_prod_price[$track_id_index]) ?></strong>
                                            </td>
                                            <td align="center">
                                                Track id : <?= $track_id ?>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>

                                <?php
                                                $track_res = SqlQuery("Select * from ordertrackingdetails WHERE track_id = '$track_id'");
                                                
                                                if (mysqli_num_rows($track_res) > 0) {
                                                    $track_rows = mysqli_fetch_assoc($track_res);
                                                    $Tracking_Name = explode(",",$track_rows['Tracking_Name']);
                                                    $Tracking_time = explode(",",$track_rows['Tracking_time']);

                                                    foreach($track_res as $track_res_key => $track_res_val) {
                                                        ?>
                                                    <div class="wrappers_progress mt-5">
                                                        <ul class="StepProgress mt-3">
                                                        <?php
                                                            foreach($Tracking_Name as $key => $val) {
                                                               $ordered_message = array();
                                                               $current_status = explode(",",$track_rows['Current_Status']);
                                                               if (in_array("Canceled",$current_status)) {
                                                                    if (isset($current_status[$key+1]) == 'Canceled') {
                                                                            $class_name = 'is-done';
                                                                        }else{
                                                                            $class_name = 'is-cancel';
                                                                            $val = 'Canceled '.$val;
                                                                        }
                                                               }else{
                                                                   if (in_array($val,$current_status)) {
                                                                       $class_name= 'is-done';
                                                                       $val = $val.' - '.date("D M d, Y", strtotime($Tracking_time[$key]));
                                                                   }else{
                                                                       $class_name = '';
                                                                       $val = $val;
                                                                   }
                                                               }
                                                                if (isset(array($track_rows['Tracking_Details'])[$track_res_key])) {
                                                                    $ordered_message = explode(",PS_FASHION_STORE,", array($track_rows['Tracking_Details'])[$track_res_key]);
                                                                }
                                                                ?>
                                                                    <li class="StepProgress-item <?= $class_name ?>" >
                                                                        <strong><?= $val ?> </strong>
                                                                        <div class="mt-1" style="line-height:10px;" >
                                                                            
                                                                            <!-- <p class="text-muted"> Mon Nov 15, 2021 12:20 am</p><p ><strong>Hey Bro How are you</strong></p><p><strong> <i class="fa fa-map-marker"></i> DOMBIVAL EAST</strong></p><hr> -->
                                                                            
                                                                            <?php
                                                                                if (isset($ordered_message[$key]) ) {
                                                                                    echo $ordered_message[$key];
                                                                                } 
                                                                            ?>
                                                                            
                                                                        </div>
                                                                    </li>            
                                                                <?php
                                                            }
                                                        ?>
                                                        
                                                        </ul>
                                                        <?php
                                                            if($track_rows['Canceled_By'] == 'user'){
                                                                ?>
                                                                <div class="alert alert-danger mt-5">
                                                                    You Canceled the Order
                                                                </div>
                                                                <?php
                                                            }

                                                            else  if($track_rows['Canceled_By'] == 'admin'){
                                                                ?>
                                                                <div class="alert alert-danger mt-5">
                                                                    Your Order has been canceled by <?= SITE_NAME ?>
                                                                </div>
                                                                <?php
                                                            }else{

                                                            }
                                                        ?>
                                                        
                                                    </div>

                                                    <?php
                                                    }
                                                }else{
                                                    echo 'No Shipping Details Found';
                                                }
                                        ?>


                            </div>
                            
                        </div>
                        
                        <div id="rating_system_add">
                            <?php
                                if (in_array("Delivered",$current_status)) {
                                    $rate_res = SqlQuery("SELECT * FROM product_rating WHERE Order_ID = '$Order_id' && Track_id='$track_id'");
                                    if (mysqli_num_rows($rate_res) > 0) {
                                        // show rated comment
                                        $rate_row = mysqli_fetch_assoc($rate_res);
                                        if($rate_row['rated_no'] >= 2.5) {
                                            $text_color = 'green';
                                        }else{
                                            $text_color = 'red';
                                        }
                                        ?>
                                            <div class="container-fluid mt-2">
                                                <header class="page-header">
                                                    <h1>
                                                        Thanks for Rating
                                                    </h1>
                                                </header>
                                                <div class="card">
                                                    <div class="row">
                                                        <div class="col-sm-10">
                                                            <p class="text-justify p-2"><?= $rate_row['rate_comment'] ?></p>
                                                        </div>
                                                        <div class="col-sm-2 " style="display: flex;justify-content: center;align-items: center;padding: 20px">
                                                            <h1 class="rating_class" style="background: <?= $text_color ?>"><?= $rate_row['rated_no'] ?> <span class="ml-1"><i class="fa fa-star "></i></span></h1>
                                                        </div>
                                                    
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                    }else{
                                        // Add a comment
                                        ?>
                                        <div class="container-fluid mt-2">
                                            <header class="page-header">
                                                <h1>
                                                    Thanks for Shopping
                                                </h1>
                                            </header>
                                            <div class="product_reviews_block_tab">
                                                <!-- <div class="rb-review-list">
                                                    <p class="alert alert-info">No comment at this time.</p>

                                                </div> -->

                                                <div class="rb-new-review-form">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title h2">
                                                            Write a review
                                                        </h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form class="" id="product_review_submit" action="" method="POST">
                                                            <input type="hidden" name="order_id_rate" value="<?= $Order_id ?>">
                                                            <input type="hidden" name="track_id_rate" value="<?= $track_id ?>">
                                                            <input type="hidden" name="product_id_rate" value="<?= $product_id ?>">
            
                                                            <div class="form-group">
                                                                <fieldset class="rating">
                                                                    <input type="radio" id="star5" class="form-control" name="rating" value="5" required/>
                                                                    <label class = "full" for="star5" title="Awesome - 5 stars"></label>

                                                                    <input type="radio" id="star4half" class="form-control" name="rating" value="4.5" required/>
                                                                    <label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>

                                                                    <input type="radio" id="star4" class="form-control" name="rating" value="4" required/>
                                                                    <label class = "full" for="star4" title="Pretty good - 4 stars"></label>

                                                                    <input type="radio" id="star3half" class="form-control" name="rating" value="3.5" required/>
                                                                    <label class="half" for="star3half" title="Meh - 3.5 stars"></label>

                                                                    <input type="radio" id="star3" class="form-control" name="rating" value="3" required/>
                                                                    <label class = "full" for="star3" title="Meh - 3 stars"></label>

                                                                    <input type="radio" id="star2half" class="form-control" name="rating" value="2.5" required/>
                                                                    <label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>

                                                                    <input type="radio" id="star2"  class="form-control" name="rating" value="2" required/>
                                                                    <label class = "full" for="star2" title="Kinda bad - 2 stars"></label>

                                                                    <input type="radio" id="star1half" class="form-control" name="rating" value="1.5" required/>
                                                                    <label class="half" for="star1half" title="Meh - 1.5 stars"></label>

                                                                    <input type="radio" id="star1" class="form-control" name="rating" value="1" required/>
                                                                    <label class = "full" for="star1" title="Sucks big time - 1 star"></label>

                                                                    <input type="radio" id="starhalf" class="form-control" name="rating" value="0.5" required/>
                                                                    <label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
                                                                </fieldset>
                                                                
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="form-control-label" for="new_review_content">
                                                                    Comment <sup class="required">*</sup>
                                                                </label>

                                                                <textarea type="text" class="form-control" id="rb_review_content"
                                                                    required="" name="rb_review_content"></textarea>
                                                            </div>

                                                            <div class="cssload-container rb-ajax-loading">
                                                                <div class="cssload-double-torus"></div>
                                                            </div>
                                                            <button class="btn btn-primary  pull-xs-right"
                                                                type="submit">
                                                                Submit
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    
                                    <?php
                                }
                            ?>
                        </div>
                       
                    </section>

                </section>


            </div>
        </div>
    </div>
</section>


<?php
require 'includes/footer.php';
?>