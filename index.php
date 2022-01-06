<?php
    require 'includes/header.php';
    // prx($user);
    $date = date('Y-m-d');
    $ProductDetails =  ProductDetails('where  product_status= 1');
    
?>
<style>
.swiper {
    width: 100%;
    height: 100%;
}

@media only screen and (max-width:600px) {
    /* .swiper {
            width: 100%;
            height: 400px;
        } */

}

.swiper-slide {
    text-align: center;
    font-size: 18px;
    background: #fff;

    /* Center slide text vertically */
    display: -webkit-box;
    display: -ms-flexbox;
    display: -webkit-flex;
    display: flex;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    -webkit-justify-content: center;
    justify-content: center;
    -webkit-box-align: center;
    -ms-flex-align: center;
    -webkit-align-items: center;
    align-items: center;
}

.swiper-slide img {
    display: block;
    width: 100vw;
    height: 100%;
    object-fit: cover;
}
</style>
<div class="">
    <div class="row">
        <div id="content-wrapper" class="col-lg-12 col-xs-12">
            <section id="main">
                <!-- Swiper -->
                <!-- <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide"><a href=""><img src="media/banner/1.jpg" alt=""></a></div>
                        <div class="swiper-slide"><a href=""><img src="media/banner/2.jpg" alt=""></a></div>
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-pagination"></div>
                </div> -->

                <div class="container">
                    <h1 class="text-center mb-3">New Arrivals</h1>
                    <div class="row row-cols-5 ">
                        <?php
                            foreach($ProductDetails as $productdata){
                                $qc_status = explode(",",$productdata['qc_status']);
                                $end_qc_status = end($qc_status);
                                if($end_qc_status == 1) {
                                    $ProductImageById = ProductImageById($productdata['id'], 'limit 2');
                                    array_unshift($ProductImageById,"");
                                    unset($ProductImageById[0]);

                                    $ProductSizes = $productdata['product_size'];
                                    $sizes = explode(",", $ProductSizes);
                                    

                                    $DiscountPercentage  =  100 - (($productdata['product_price'] / $productdata['product_oldPrice']) * 100) ;
                                    $DiscountPercentage = floor($DiscountPercentage);

                                    if($DiscountPercentage > 50) {
                                        $changeDiscountColor = 'green';
                                    }else{
                                        $changeDiscountColor = 'red';
                                    }

                                    ?>
                        <article
                            class="product-miniature js-product-miniature col-lg-3 col-md-4 col-sm-6 col-6 pl-sm-1  pr-sm-1  w-20">
                            <div class="thumbnail-container">
                                <div class="product-image">
                                    <a href="<?= FRONT_SITE_PATH.'product-details?productname='.urlencode($productdata['product_name']) ?>"
                                        class="thumbnail product-thumbnail img-fluid">

                                        <img class="img-fluid rb-cover"
                                            src="<?= FRONT_SITE_IMAGE_PRODUCT.$ProductImageById[1]['product_img'] ?>"
                                            alt="<?= $productdata['product_name'] ?>"
                                            data-full-size-image-url="<?= FRONT_SITE_IMAGE_PRODUCT.$ProductImageById[1]['product_img'] ?>">
                                        <div class="product-hover">
                                            <img class="img-fluid rb-image image-hover"
                                                src="<?= FRONT_SITE_IMAGE_PRODUCT.$ProductImageById[2]['product_img'] ?>"
                                                title="<?= $productdata['product_name'] ?>" width="600" height="686">
                                        </div>
                                    </a>

                                    <ul class="product-flags">
                                        <?php
                                                                                                                                
                                                                                                                                    if(RemainingStock($productdata['id']) == '<span style="color:red">Out of Stock</span>')   {
                                                                                                                                        ?>
                                        <li class="product-flag discount" style="color: red">
                                            <?= RemainingStock($productdata['id']) ?>
                                        </li>
                                        <?php
                                                                                                                                    }else{
                                                                                                                                        ?>
                                        <li class="product-flag discount" style="color: <?= $changeDiscountColor ?>">
                                            <?= $DiscountPercentage."%" ?>
                                        </li>
                                        <?php
                                                                                                                                    }

                                                                                                                                    ?>
                                    </ul>



                                    <?php
                                                                                                                                if(isset($_SESSION['UID'])) {
                                                                                                                                ?>
                                    <div class="product-flags" style="left:calc(100% - 25%)">
                                        <div class="dropdown rb-wishlist-dropdown ">
                                            <button
                                                class="rb-wishlist-button rb-btn-product show-list btn-product btn rb_added"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"
                                                style="background: none;">
                                                <span class="rb-wishlist-content">
                                                    <i class="icon-btn-product icon-wishlist icon-Icon_Wishlist"></i>
                                                </span>
                                            </button>
                                            <div class="dropdown-menu rb-list-wishlist rb-list-wishlist-4">
                                                <?php
                                                                                                                                            $WishlistData = WishlistData($user['id']);
                                                                                                                                            
                                                                                                                                            foreach($WishlistData as $key => $val){
                                                                                                                                                $ProductSizes = $productdata['product_size'];
                                                                                                                                                $sizes = explode(",", $ProductSizes);
                                                                                                                                                
                                                                                                                                                // Convert Product from string to array 
                                                                                                                                                $productFromWishlist = explode(",", $val['wishlist_prod_id']);
                                                                                                                                                
                                                                                                                                                if (in_array($productdata['id'], $productFromWishlist)) {
                                                                                                                                                    $icon = 'fa fa-check';
                                                                                                                                                    $css_wish_id = 'color:green;pointer-events:none';
                                                                                                                                                }else{
                                                                                                                                                    $icon = 'icon-btn-product icon-wishlist icon-Icon_Wishlist';
                                                                                                                                                    $css_wish_id = '';
                                                                                                                                                }
                                                                                                                                                ?>
                                                <a href="javascript:void(0)"
                                                    onclick="AddtoWishList('<?= $val['id'] ?>', '<?= $productdata['id'] ?>', '<?= $sizes['0'] ?>')"
                                                    class="rb-wishlist-link dropdown-item list-group-item list-group-item-action wishlist-item rb_added<?= $val['id'].'_'.$productdata['id'] ?> "
                                                    title="Remove from Wishlist" style="<?= $css_wish_id ?>">
                                                    <i class="<?= $icon ?>"></i>
                                                    <?= $val['wishlist_name'] ?>
                                                </a>
                                                <?php
                                                                                                                                            }
                                                                                                                                        ?>

                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                                                                                                                }else{
                                                                                                                                    ?>
                                    <div class="rb-wishlist">
                                        <a href="javascript:void(0)" class="no_login_wishlist_2">
                                            <i class="icon-btn-product icon-wishlist icon-Icon_Wishlist"></i>
                                        </a>
                                    </div>
                                    <?php
                                                                                                                                }
                                                                                                                            ?>


                                    <div class="functional-buttons clearfix">

                                        <?php
                                                                                                                                if(RemainingStock($productdata['id']) == '<span style="color:red">Out of Stock</span>')   {
                                                                                                                                    
                                                                                                                                }else{
                                                                                                                                    ?>
                                        <div class="product-add-cart hidden-sm-down">
                                            <!-- begin /var/www/html/demo/rb_evo_demo/themes/rb_evo/modules/rbthemefunction/views/templates/hook/rb-cart.tpl -->
                                            <div class="product-add-to-cart-rb">

                                                <div class="product-quantity">
                                                    <div class="add">
                                                        <button class="btn rb-btn-product add-to-cart"
                                                            title="Add to cart"
                                                            onclick="addtoCart('<?= $productdata['id'] ?>', '<?= $user['id'] ?>', '1',  '<?= $productdata['product_price'] ?>', '<?= $sizes['0'] ?>')">
                                                            <span class="icon-title">Add
                                                                To
                                                                Cart</span>
                                                        </button>


                                                        <span class="product-availability hidden">
                                                        </span>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="product-quickview hidden-sm-down">
                                            <a class="rb-quick-view rb-btn-product" href="javascript:void(0)"
                                                data-link-action="quickview"
                                                onclick="quickviewaction('<?= $productdata['id'] ?>')">
                                                <i class="icon-Icon_Quick-view"></i>
                                                <span class="icon-title">Quick
                                                    view</span>
                                            </a>
                                        </div>

                                        <div class="product-quick-view" style="display:none;">
                                            <a class="quick-view rb-btn-product" href="#" data-link-action="quickview">
                                                <i class="icon-Icon_Quick-view search"></i>
                                                <span class="icon-title">Quick
                                                    view</span>
                                            </a>
                                        </div>
                                        <?php
                                                                                                                                }
                                                                                                                                ?>

                                    </div>

                                </div>

                                <div class="product-meta pl-sm-1  pr-sm-1">
                                    <h2 class="h3 product-title" itemprop="name">
                                        <a href="<?= FRONT_SITE_PATH.'product-details?productname='.urlencode($productdata['product_name']) ?>"
                                            itemprop="url"
                                            content="<?= FRONT_SITE_PATH.'product-details?productname='.urlencode($productdata['product_name']) ?>">
                                            <?= $productdata['product_name'] ?></a>
                                    </h2>

                                    <div class="product-price-and-shipping">
                                        <span class="regular-price" aria-label="Regular price">₹
                                            <?= $productdata['product_oldPrice'] ?></span>

                                        <span class="price" aria-label="Price">₹
                                            <?= $productdata['product_price'] ?></span>
                                        <div itemprop="offers" itemscope itemtype="http://schema.org/Offer"
                                            class="invisible">
                                            <meta itemprop="priceCurrency" content="USD" />
                                            <meta itemprop="price" content="19.12" />
                                        </div>




                                    </div>

                                </div>

                            </div>
                        </article>
                        <?php
                                }
                                
                            }        
                        ?>


                    </div>
                </div>

                <!-- Trending Products -->
                <div class="container">
                    <h1 class="text-center mb-3">Trending Products</h1>
                    <div class="row row-cols-5">
                        <?php
                            $top_sell_row = SqlQuery("Select * from payment_details");
                            $prod_ids_payment = array();
                            if (mysqli_num_rows($top_sell_row) > 0) {
                                foreach ($top_sell_row as $key => $value) {
                                    $prod_ids_payment[] = $value['product_id'];
                                }
                                $record_product = join(",",$prod_ids_payment);
                                $all_productvalue = explode(",",$record_product);
                                $dups = array();
                                foreach(array_count_values($all_productvalue) as $val => $c)
                                    if($c > TOP_SALE_RANGE) $dups[] = $val;
                                        foreach ($dups as $key => $value) {
                                            $Top_Selling_Products = ProductDetails("WHERE id = '$value'"); 
                                            $Top_Selling_Products = $Top_Selling_Products[0];

                                            $ProductImageById = ProductImageById($Top_Selling_Products['id'], 'limit 2');
                                            array_unshift($ProductImageById,"");
                                            unset($ProductImageById[0]);

                                            $ProductSizes = $Top_Selling_Products['product_size'];
                                            $sizes = explode(",", $ProductSizes);
                                            

                                            $DiscountPercentage  =  100 - (($Top_Selling_Products['product_price'] / $Top_Selling_Products['product_oldPrice']) * 100) ;
                                            $DiscountPercentage = floor($DiscountPercentage);

                                            if($DiscountPercentage > 50) {
                                                $changeDiscountColor = 'green';
                                            }else{
                                                $changeDiscountColor = 'red';
                                            }
                                        

                                            ?>
                                            <article
                                                class="product-miniature js-product-miniature col-lg-3 col-md-4 col-sm-6 col-6 pl-sm-1  pr-sm-1  w-20"
                                                data-id-product="1" data-id-product-attribute="1" itemscope
                                                itemtype="http://schema.org/Product">
                                                <div class="thumbnail-container">
                                                    <div class="product-image">

                                                        <a href="<?= FRONT_SITE_PATH.'product-details?productname='.urlencode($Top_Selling_Products['product_name']) ?>"
                                                            class="thumbnail product-thumbnail">

                                                            <img class="img-fluid rb-cover"
                                                                src="<?= FRONT_SITE_IMAGE_PRODUCT.$ProductImageById[1]['product_img'] ?>"
                                                                alt="<?= $Top_Selling_Products['product_name'] ?>"
                                                                data-full-size-image-url="<?= FRONT_SITE_IMAGE_PRODUCT.$ProductImageById[1]['product_img'] ?>">
                                                            <div class="product-hover">
                                                                <img class="img-fluid rb-image image-hover"
                                                                    src="<?= FRONT_SITE_IMAGE_PRODUCT.$ProductImageById[2]['product_img'] ?>"
                                                                    title="<?= $Top_Selling_Products['product_name'] ?>" width="600"
                                                                    height="686">
                                                            </div>
                                                        </a>

                                                        <ul class="product-flags">
                                                            <?php
                                                                                                                                        
                                                                                                                                            if(RemainingStock($Top_Selling_Products['id']) == '<span style="color:red">Out of Stock</span>')   {
                                                                                                                                                ?>
                                                            <li class="product-flag discount" style="color: red">
                                                                <?= RemainingStock($Top_Selling_Products['id']) ?>
                                                            </li>
                                                            <?php
                                                                                                                                            }else{
                                                                                                                                                ?>
                                                            <li class="product-flag discount" style="color: <?= $changeDiscountColor ?>">
                                                                <?= $DiscountPercentage."%" ?>
                                                            </li>
                                                            <?php
                                                                                                                                            }

                                                                                                                                            ?>
                                                        </ul>



                                                        <?php
                                                                                                                                        if(isset($_SESSION['UID'])) {
                                                                                                                                        ?>
                                                        <div class="product-flags" style="left:calc(100% - 25%)">
                                                            <div class="dropdown rb-wishlist-dropdown ">
                                                                <button
                                                                    class="rb-wishlist-button rb-btn-product show-list btn-product btn rb_added"
                                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                                    <span class="rb-wishlist-content">
                                                                        <i class="icon-btn-product icon-wishlist icon-Icon_Wishlist"></i>
                                                                    </span>
                                                                </button>
                                                                <div class="dropdown-menu rb-list-wishlist rb-list-wishlist-4">
                                                                    <?php
                                                                                                                                                    $WishlistData = WishlistData($user['id']);
                                                                                                                                                    
                                                                                                                                                    foreach($WishlistData as $key => $val){
                                                                                                                                                        $ProductSizes = $Top_Selling_Products['product_size'];
                                                                                                                                                        $sizes = explode(",", $ProductSizes);
                                                                                                                                                        
                                                                                                                                                        // Convert Product from string to array 
                                                                                                                                                        $productFromWishlist = explode(",", $val['wishlist_prod_id']);
                                                                                                                                                        
                                                                                                                                                        if (in_array($Top_Selling_Products['id'], $productFromWishlist)) {
                                                                                                                                                            $icon = 'fa fa-check';
                                                                                                                                                            $css_wish_id = 'color:green;pointer-events:none';
                                                                                                                                                        }else{
                                                                                                                                                            $icon = 'icon-btn-product icon-wishlist icon-Icon_Wishlist';
                                                                                                                                                            $css_wish_id = '';
                                                                                                                                                        }
                                                                                                                                                        ?>
                                                                    <a href="javascript:void(0)"
                                                                        onclick="AddtoWishList('<?= $val['id'] ?>', '<?= $Top_Selling_Products['id'] ?>', '<?= $sizes['0'] ?>')"
                                                                        class="rb-wishlist-link dropdown-item list-group-item list-group-item-action wishlist-item rb_added<?= $val['id'].'_'.$productdata['id'] ?> "
                                                                        title="Remove from Wishlist" style="<?= $css_wish_id ?>">
                                                                        <i class="<?= $icon ?>"></i>
                                                                        <?= $val['wishlist_name'] ?>
                                                                    </a>
                                                                    <?php
                                                                                                                                                    }
                                                                                                                                                ?>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                                                                                                        }else{
                                                                                                                                            ?>
                                                        <div class="rb-wishlist">
                                                            <a href="javascript:void(0)" class="no_login_wishlist_2">
                                                                <i class="icon-btn-product icon-wishlist icon-Icon_Wishlist"></i>
                                                            </a>
                                                        </div>
                                                        <?php
                                                                                                                                        }
                                                                                                                                    ?>


                                                        <div class="functional-buttons clearfix">

                                                            <?php
                                                                                                                                        if(RemainingStock($Top_Selling_Products['id']) == '<span style="color:red">Out of Stock</span>')   {
                                                                                                                                            
                                                                                                                                        }else{
                                                                                                                                            ?>
                                                            <div class="product-add-cart hidden-sm-down">
                                                                <!-- begin /var/www/html/demo/rb_evo_demo/themes/rb_evo/modules/rbthemefunction/views/templates/hook/rb-cart.tpl -->
                                                                <div class="product-add-to-cart-rb ">

                                                                    <div class="product-quantity">
                                                                        <div class="add">
                                                                            <button class="btn rb-btn-product add-to-cart"
                                                                                title="Add to cart"
                                                                                onclick="addtoCart('<?= $Top_Selling_Products['id'] ?>', '<?= $user['id'] ?>', '1',  '<?= $Top_Selling_Products['product_price'] ?>', '<?= $sizes['0'] ?>')">
                                                                                <span class="icon-title">Add
                                                                                    To
                                                                                    Cart</span>
                                                                            </button>


                                                                            <span class="product-availability hidden">
                                                                            </span>

                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="product-quickview hidden-sm-down">
                                                                <a class="rb-quick-view rb-btn-product" href="javascript:void(0)"
                                                                    data-link-action="quickview"
                                                                    onclick="quickviewaction('<?= $Top_Selling_Products['id'] ?>')">
                                                                    <i class="icon-Icon_Quick-view"></i>
                                                                    <span class="icon-title">Quick
                                                                        view</span>
                                                                </a>
                                                            </div>

                                                            <div class="product-quick-view" style="display:none;">
                                                                <a class="quick-view rb-btn-product" href="#" data-link-action="quickview">
                                                                    <i class="icon-Icon_Quick-view search"></i>
                                                                    <span class="icon-title">Quick
                                                                        view</span>
                                                                </a>
                                                            </div>
                                                            <?php
                                                                                                                                        }
                                                                                                                                        ?>

                                                        </div>

                                                    </div>

                                                    <div class="product-meta">
                                                        <h2 class="h3 product-title" itemprop="name">
                                                            <a href="<?= FRONT_SITE_PATH.'product-details?productname='.urlencode($Top_Selling_Products['product_name']) ?>"
                                                                itemprop="url"
                                                                content="<?= FRONT_SITE_PATH.'product-details?productname='.urlencode($Top_Selling_Products['product_name']) ?>">
                                                                <?= $Top_Selling_Products['product_name'] ?></a>
                                                        </h2>

                                                        <div class="product-price-and-shipping">
                                                            <span class="regular-price" aria-label="Regular price">₹
                                                                <?= $Top_Selling_Products['product_oldPrice'] ?></span>

                                                            <span class="price" aria-label="Price">₹
                                                                <?= $Top_Selling_Products['product_price'] ?></span>
                                                            <div itemprop="offers" itemscope itemtype="http://schema.org/Offer"
                                                                class="invisible">
                                                                <meta itemprop="priceCurrency" content="USD" />
                                                                <meta itemprop="price" content="19.12" />
                                                            </div>




                                                        </div>

                                                    </div>

                                                </div>
                                            </article>
                                            <?php
                                    }
                            }
                                                                    
                        ?>
                    </div>
                </div>

                <section id="content" class="page-content card card-block">
                    <div id="rb" class="rb">
                        <div id="rb" class="rb">
                            <div id="rb-inner">
                                <div id="rb-section-wrap">
                                    <div class="layout-1 rb-section rb-element rb-element-ihgqz31 rb-top-section rb-section-boxed rb-section-height-default rb-section-height-default"
                                        data-element_type="section">
                                        <div class="container rb-container rb-column-gap-default">
                                            <div class="row">
                                                <div class="col-md-3 col-sm-6 col-xs-12 rb-column rb-element rb-element-8q7avfn col-md-3 rb-top-column"
                                                    data-element_type="column">
                                                    <div class="rb-column-wraprb-element-populated">
                                                        <div class="rb-widget-wrap">
                                                            <div class="rb-widget rb-element rb-element-7xhy8vf rb-widget-icon-box rb-view-default rb-position-top rb-vertical-align-top"
                                                                data-element_type="icon-box">
                                                                <div class="rb-widget-container">
                                                                    <div class="rb-icon-box-wrapper">
                                                                        <div class="rb-icon-box-icon">
                                                                            <span class="rb-icon rb-animation-">
                                                                                <i class="fa fa-truck"></i>
                                                                            </span>
                                                                        </div>
                                                                        <div class="rb-icon-box-content">
                                                                            <h3 class="rb-icon-box-title">
                                                                                <span>Free shipping</span>
                                                                            </h3>
                                                                            <div class="rb-icon-box-description">
                                                                                <p>on all orders over $49.00
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-6 col-xs-12 rb-column rb-element rb-element-n90i2kw col-md-3 rb-top-column"
                                                    data-element_type="column">
                                                    <div class="rb-column-wraprb-element-populated">
                                                        <div class="rb-widget-wrap">
                                                            <!-- end /var/www/html/demo/rb_evo_demo/modules/rbthemedream/views/templates/column.tpl -->
                                                            <div class="rb-widget rb-element rb-element-vb5ggqf rb-widget-icon-box rb-view-default rb-position-top rb-vertical-align-top"
                                                                data-element_type="icon-box">
                                                                <!-- begin /var/www/html/demo/rb_evo_demo/modules/rbthemedream/views/templates/widget.tpl -->
                                                                <div class="rb-widget-container">
                                                                    <!-- begin /var/www/html/demo/rb_evo_demo/modules/rbthemedream/views/templates/widget/rb-icon-box.tpl -->
                                                                    <div class="rb-icon-box-wrapper">
                                                                        <div class="rb-icon-box-icon">
                                                                            <span class="rb-icon rb-animation-">
                                                                                <i class="fa fa-history"></i>
                                                                            </span>
                                                                        </div>
                                                                        <div class="rb-icon-box-content">
                                                                            <h3 class="rb-icon-box-title">
                                                                                <span>15 days returns</span>
                                                                            </h3>
                                                                            <div class="rb-icon-box-description">
                                                                                <p>moneyback guarantee</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end /var/www/html/demo/rb_evo_demo/modules/rbthemedream/views/templates/widget/rb-icon-box.tpl -->
                                                                </div>
                                                                <!-- end /var/www/html/demo/rb_evo_demo/modules/rbthemedream/views/templates/widget.tpl -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- begin /var/www/html/demo/rb_evo_demo/modules/rbthemedream/views/templates/column.tpl -->
                                                <div class="col-md-3 col-sm-6 col-xs-12 rb-column rb-element rb-element-m8jzljp col-md-3 rb-top-column"
                                                    data-element_type="column">
                                                    <div class="rb-column-wraprb-element-populated">
                                                        <div class="rb-widget-wrap">
                                                            <!-- end /var/www/html/demo/rb_evo_demo/modules/rbthemedream/views/templates/column.tpl -->
                                                            <div class="rb-widget rb-element rb-element-rsu85uj rb-widget-icon-box rb-view-default rb-position-top rb-vertical-align-top"
                                                                data-element_type="icon-box">
                                                                <!-- begin /var/www/html/demo/rb_evo_demo/modules/rbthemedream/views/templates/widget.tpl -->
                                                                <div class="rb-widget-container">
                                                                    <!-- begin /var/www/html/demo/rb_evo_demo/modules/rbthemedream/views/templates/widget/rb-icon-box.tpl -->
                                                                    <div class="rb-icon-box-wrapper">
                                                                        <div class="rb-icon-box-icon">
                                                                            <span class="rb-icon rb-animation-">
                                                                                <i class="fa fa-credit-card"></i>
                                                                            </span>
                                                                        </div>
                                                                        <div class="rb-icon-box-content">
                                                                            <h3 class="rb-icon-box-title">
                                                                                <span>Secure checkout</span>
                                                                            </h3>
                                                                            <div class="rb-icon-box-description">
                                                                                <p>100% protected by Paypal
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end /var/www/html/demo/rb_evo_demo/modules/rbthemedream/views/templates/widget/rb-icon-box.tpl -->
                                                                </div>
                                                                <!-- end /var/www/html/demo/rb_evo_demo/modules/rbthemedream/views/templates/widget.tpl -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- begin /var/www/html/demo/rb_evo_demo/modules/rbthemedream/views/templates/column.tpl -->
                                                <div class="col-md-3 col-sm-6 col-xs-12 rb-column rb-element rb-element-56vlsf5 col-md-3 rb-top-column"
                                                    data-element_type="column">
                                                    <div class="rb-column-wraprb-element-populated">
                                                        <div class="rb-widget-wrap">
                                                            <!-- end /var/www/html/demo/rb_evo_demo/modules/rbthemedream/views/templates/column.tpl -->
                                                            <div class="rb-widget rb-element rb-element-62cpnec rb-widget-icon-box rb-view-default rb-position-top rb-vertical-align-top"
                                                                data-element_type="icon-box">
                                                                <!-- begin /var/www/html/demo/rb_evo_demo/modules/rbthemedream/views/templates/widget.tpl -->
                                                                <div class="rb-widget-container">
                                                                    <!-- begin /var/www/html/demo/rb_evo_demo/modules/rbthemedream/views/templates/widget/rb-icon-box.tpl -->
                                                                    <div class="rb-icon-box-wrapper">
                                                                        <div class="rb-icon-box-icon">
                                                                            <span class="rb-icon rb-animation-">
                                                                                <i class="fa fa-life-ring"></i>
                                                                            </span>
                                                                        </div>
                                                                        <div class="rb-icon-box-content">
                                                                            <h3 class="rb-icon-box-title">
                                                                                <span>100% free
                                                                                    warranty</span>
                                                                            </h3>
                                                                            <div class="rb-icon-box-description">
                                                                                <p>moneyback guarantee</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end /var/www/html/demo/rb_evo_demo/modules/rbthemedream/views/templates/widget/rb-icon-box.tpl -->
                                                                </div>
                                                                <!-- end /var/www/html/demo/rb_evo_demo/modules/rbthemedream/views/templates/widget.tpl -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end /var/www/html/demo/rb_evo_demo/modules/rbthemedream/views/templates/front/front.tpl -->

                    </div>

                </section>


                <footer class="page-footer">
                    <!-- Footer content -->
                </footer>


            </section>
        </div>
    </div>

</div>

<?php
     require 'includes/footer.php';
     ?>

<script>
var swiper = new Swiper(".mySwiper", {
    pagination: {
        el: ".swiper-pagination",
        type: "progressbar",
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
});
</script>