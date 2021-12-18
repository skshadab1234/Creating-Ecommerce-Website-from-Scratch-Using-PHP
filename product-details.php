<?php
    require 'includes/header.php';
    
    $pname = get_safe_value($_GET['productname']);
    $ProductDetails =  ProductDetails('left join shop_category on product_details.product_categories =  shop_category.cat_id  left join brands on product_details.product_brand = brands.bid  where product_name = "'.$pname.'"');
    $ProductDetails = $ProductDetails[0];
    
    if ($pname == '' || $ProductDetails['product_name'] != $pname || $ProductDetails['product_status'] == 0)  {
        redirect(FRONT_SITE_PATH);
    }

    $DiscountPercentage = 100 - (($ProductDetails['product_price'] / $ProductDetails['product_oldPrice']) * 100) ;
    $DiscountPercentage = floor($DiscountPercentage);

    if($DiscountPercentage > 50) {
        $changeDiscountColor = 'green';
    }else{
        $changeDiscountColor = 'red';
    }

    if(RemainingStock($ProductDetails['id']) == '<span style="color:red">Out of Stock</span>') {
        $disabled = 'disabled';
    }else{
        $disabled = '';
    }

    // For Rating 
    $pro_res_modal =SqlQuery("SELECT * FROM product_rating WHERE rate_product_id='".$ProductDetails['id']."' order by id DESC");
    // fOR Limited Review
    $pro_res =SqlQuery("SELECT * FROM product_rating WHERE rate_product_id='".$ProductDetails['id']."' order by id DESC limit 5");
    ?>
<style>
.has-discount .discount {
    border: 2px solid <?=$changeDiscountColor ?>;
    color: <?=$changeDiscountColor ?>;
}

.has-discount .discount:before {
    border: 13px solid <?=$changeDiscountColor ?>;
    border-right-color: transparent;
}

#rb_review .modal-header{
    padding: 30px;
    text-align: left;
    width: 100%;
    display: flex;
    align-items: center;
}

.modal-title{
    position: absolute;
    left: 17px;
}

.modal-header .close{
    position: absolute;
    right: 16px
}
</style>

<aside id="notifications">
    <div class="container">
    </div>
</aside>


<section id="wrapper">

    <nav data-depth="3" class="breadcrumb">
        <div class="container">
            <ol itemscope class="p-a-0">

                <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    <a itemprop="item" href="<?= FRONT_SITE_PATH ?>">
                        <span itemprop="name">Home</span>
                    </a>
                    <meta itemprop="position" content="1">
                </li>

                <?php
                    if($ProductDetails['category_name'] == ''){

                    }else{
                        ?>
                <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    <a itemprop="item"
                        href="<?= FRONT_SITE_PATH.'categories?cat_name='.urlencode($ProductDetails['category_name']) ?>">
                        <span itemprop="name"><?=  $ProductDetails['category_name'] ?></span>
                    </a>
                    <meta itemprop="position" content="2">
                </li>
                <?php
                    }

                    if ($ProductDetails['product_subCategories'] != '') {
                        ?>
                        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                            <a itemprop="item"
                                href="<?= FRONT_SITE_PATH.'subcategories?subcat_name='.urlencode($ProductDetails['product_subCategories']) ?>">
                                <span itemprop="name"><?=  urldecode($ProductDetails['product_subCategories']) ?></span>
                            </a>
                            <meta itemprop="position" content="2">
                        </li>

                <?php
                    }

                    if ($ProductDetails['product_subCat_Values'] != '') {
                        ?>
                <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    <a itemprop="item"
                        href="<?= FRONT_SITE_PATH.'subcategories?subcat_name='.urlencode($ProductDetails['product_subCategories']) ?>">
                        <span itemprop="name"><?=  urldecode($ProductDetails['product_subCat_Values']) ?></span>
                    </a>
                    <meta itemprop="position" content="2">
                </li>
                <?php
                    }
                ?>

                <li>
                    <span><?= $ProductDetails['product_name'] ?></span>
                </li>

            </ol>
        </div>
    </nav>


    <div class="container">
        <div class="row">
            <div id="content-wrapper" class="col-lg-12 col-xs-12">

                <section id="main" itemscope itemtype="https://schema.org/Product">
                    <meta itemprop="url"
                        content="https://rubiktheme.com/demo/rb_evo_demo/en/women/3-13-the-best-is-yet-to-come-framed-poster.html#/19-dimension-40x60cm">

                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 col-sp-12">

                            <section class="page-content" id="content">


                                <ul class="product-flags">
                                </ul>



                                <div class="images-container">


                                    <div class="product-cover product-img-slick">

                                        <?php
                                        $ProductImageById = ProductImageById($ProductDetails['id']);
                                        array_unshift($ProductImageById,"");
                                        unset($ProductImageById[0]);
                                        foreach ($ProductImageById as $key => $value) {
                                            ?>

                                        <img class="images-zoom"
                                            data-zoom-image="<?= FRONT_SITE_IMAGE_PRODUCT.$value['product_img'] ?>"
                                            data-src="<?= FRONT_SITE_IMAGE_PRODUCT.$value['product_img'] ?>"
                                            data-zoom="<?= FRONT_SITE_IMAGE_PRODUCT.$value['product_img'] ?>"
                                            src="<?= FRONT_SITE_IMAGE_PRODUCT.$value['product_img'] ?>"
                                            style="width:100%"
                                            data-rb-image="<?= FRONT_SITE_IMAGE_PRODUCT.$value['product_img'] ?>">
                                        <?php
                                        }
                                      ?>
                                    </div>



                                    <div id="rb_gallery" class="product-img-slick">

                                        <?php
                                        foreach ($ProductImageById as $key => $value) {
                                            ?>
                                        <a class="thumb-container" href="javascript:void(0)"
                                            data-image="<?= FRONT_SITE_IMAGE_PRODUCT.$value['product_img'] ?>"
                                            data-zoom-image="<?= FRONT_SITE_IMAGE_PRODUCT.$value['product_img'] ?>">
                                            <img class="img img-thumb" id="rb_img_1"
                                                src="<?= FRONT_SITE_IMAGE_PRODUCT.$value['product_img'] ?>" />
                                        </a>
                                        <?php 
                                        }
                                        ?>

                                    </div>

                                </div>
                            </section>

                        </div>
                        <div class="detail-padding-left col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 col-sp-12">

                            <h1 class="h1 product-detail-name" itemprop="name"><?= $ProductDetails['product_name'] ?>
                            </h1>

                            <div class="product-prices">
                                <div class="product-discount">

                                    <span class="regular-price">₹ <?= $ProductDetails['product_oldPrice'] ?></span>
                                </div>

                                <div class="product-price h5 has-discount" itemprop="offers" itemscope=""
                                    itemtype="https://schema.org/Offer">
                                    <link itemprop="availability" href="https://schema.org/InStock">
                                    <meta itemprop="priceCurrency" content="INR">

                                    <div class="current-price">
                                        <span itemprop="price" content="<?= $ProductDetails['product_price'] ?>">₹
                                            <?= $ProductDetails['product_price'] ?></span>

                                        <span class="discount discount-percentage"><?= $DiscountPercentage.'%' ?></span>
                                    </div>

                                </div>


                                <div class="tax-shipping-delivery-label">
                                </div>

                                <div class="product-attributes-label">
                                    <div class="product-manufacturer">
                                        <label class="label">Brand:</label>
                                        <?php
                                            if($ProductDetails['brand_img'] == '' ){
                                                $brand_name_check = $ProductDetails['brand_name'];
                                            }else{
                                                $brand_name_check = ' <img src='.FRONT_SITE_IMAGE_BRAND.$ProductDetails['brand_img'].' class="img img-thumbnail manufacturer-logo" alt="Studio Design">';
                                            }
                                        ?>  
                                        <a
                                            href="<?= FRONT_SITE_PATH.'brand?brand_name='.$ProductDetails['brand_name'] ?>" title="<?= $ProductDetails['brand_name'] ?>">
                                            <?= $brand_name_check ?>
                                        </a>

                                    </div>

                                    <div class="product-quantities">
                                        <label class="label">In stock</label>
                                        <span data-stock="278"
                                            data-allow-oosp="0"><?= RemainingStock($ProductDetails['id']) ?>
                                        </span>
                                    </div>

                                    <?php
                                            $avg_rate_prd = SqlQuery("SELECT AVG(rated_no) as avg_rate FROM product_rating WHERE rate_product_id = '".$ProductDetails['id']."'");
                                            $avg_row = mysqli_fetch_assoc($avg_rate_prd);
                                                
                                            $star_rate = star_rate(number_format($avg_row['avg_rate'],1));

                                            if ($avg_row['avg_rate'] != '') {
                                                ?>
                                                <div class="product-quantities mt-1">
                                                    <label class="label">Average Rating</label>
                                                    
                                                    <span data-stock="278"
                                                        data-allow-oosp="0"><?= $star_rate ?>
                                                    </span>
                                                </div>
                                                <?php
                                            }
                                        ?>
                                    

                                </div>

                                <div id="product-availability">
                                </div>

                            </div>


                            <div class="product-information">

                                <div id="product-description-short-3" class="product-description"
                                    itemprop="description">
                                    <p><?= $ProductDetails['product_desc_short'] ?></p>
                                </div>



                                <div class="product-actions">
                                    <!-- begin /var/www/html/demo/rb_evo_demo/modules/rbthemefunction/views/templates/rb-ajax-loading.tpl -->
                                    <div class="cssload-container rb-ajax-loading">
                                        <div class="cssload-double-torus"></div>
                                    </div>
                                    <!-- end /var/www/html/demo/rb_evo_demo/modules/rbthemefunction/views/templates/rb-ajax-loading.tpl -->
                                    <form method="post" id="add-to-cart-desktop">
                                        <input type="hidden" name='prod_id' value="<?= $ProductDetails['id'] ?>">
                                        <input type="hidden" name='user_id' value="<?= $user['id'] ?>">
                                        <input type="hidden" name='prod_price'
                                            value="<?= $ProductDetails['product_price'] ?>">

                                        <div class="product-variants">
                                            <div class="clearfix product-variants-item">
                                                <ul id="group_3">
                                                    <?php
                                                    // Checking if Item Out of Stock the Disabled Button and all 
                                                        
                                                
                                                        $ProductSizes = $ProductDetails['product_size'];
                                                        
                                                        if (empty($ProductSizes)) {
                                                            
                                                        }else{
                                                            ?>
                                                    <span class="control-label">Size</span>

                                                    <?php
                                                            $sizeExtract = explode(',', $ProductSizes);
                                                            foreach ($sizeExtract as $key => $value) {
                                                                // Hitting Check at inital Size 
                                                                if ($key == 0) {
                                                                    $checked = "checked='checked'";
                                                                }else {
                                                                    $checked = '';
                                                                }
                                                                ?>
                                                    <li class="input-container float-xs-left instock">
                                                        <label>
                                                            <input class="input-radio" type="radio" name="check_sizes"
                                                                value="<?= $value ?>" title="<?= $value ?>" required
                                                                <?= $checked.' '.$disabled ?>>
                                                            <span class="radio-label"><?= $value ?></span>
                                                        </label>
                                                    </li>
                                                    <?php
                                                                }
                                                            }

                                                        ?>
                                                </ul>
                                            </div>
                                        </div>
                                        <section class="product-discounts">
                                        </section>

                                        <div class="product-add-to-cart">

                                            <div class="product-quantity clearfix">
                                                <div class="qty">
                                                    <span class="control-label hidden-xl-down">Quantity</span>
                                                    <input type="text" name="qty" id="quantity_wanted" value="1"
                                                        class="input-group" min="1" aria-label="Quantity"
                                                        <?= $disabled ?>>
                                                </div>


                                                <?php
                                         if(RemainingStock($ProductDetails['id']) != '<span style="color:red">Out of Stock</span>')   {
                                              ?>
                                                <div class="add">
                                                    <button type='submit' class="btn btn-primary add-to-cart">
                                                        <i class="material-icons shopping-cart"></i>
                                                        Add to cart
                                                    </button>
                                                    <div class="page-loading-overlay add-to-cart-loading"></div>
                                                </div>
                                            </div>
                                    </form>

                                    <?php
                                         }else{
                                             ?>
                                    <button class="btn btn-danger">
                                        <i class="material-icons shopping-cart"></i>
                                        Notify Me
                                    </button>
                                </div>
                                <?php
                                         }
                                    ?>


                                <div class="compare-wishlist-button">

                                    <div class="rb-wishlist">
                                        <div class="rb-wishlist">
                                            <div class="dropdown rb-wishlist-dropdown">

                                                <button
                                                    class="rb-wishlist-button rb-btn-product show-list btn-product btn rb_added"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                    data-id-wishlist="9" data-id-product="4"
                                                    data-id-product-attribute="16">
                                                    <span class="rb-wishlist-content">
                                                        <i
                                                            class="icon-btn-product icon-wishlist icon-Icon_Wishlist"></i>
                                                        <span class="icon-title">Add to Wishlist</span>
                                                    </span>
                                                </button>
                                                <div class="dropdown-menu rb-list-wishlist rb-list-wishlist-4">
                                                    <?php
                    $WishlistData = WishlistData($user['id']);
                    
                    foreach($WishlistData as $key => $val){
                        $ProductSizes = $ProductDetails['product_size'];
                        $sizes = explode(",", $ProductSizes);
                        
                        // Convert Product from string to array 
                        $productFromWishlist = explode(",", $val['wishlist_prod_id']);
                        
                        if (in_array($ProductDetails['id'], $productFromWishlist)) {
                            $icon = 'fa fa-check';
                            $css_wish_id = 'color:green;pointer-events:none';
                        }else{
                            $icon = 'icon-btn-product icon-wishlist icon-Icon_Wishlist';
                            $css_wish_id = '';
                        }
                    ?>


                                                    <a href="javascript:void(0)"
                                                        onclick="AddtoWishList('<?= $val['id'] ?>', '<?= $ProductDetails['id'] ?>', '<?= $sizes['0'] ?>')"
                                                        class="rb-wishlist-link dropdown-item list-group-item list-group-item-action wishlist-item rb_added<?= $val['id'].'_'.$ProductDetails['id'] ?> "
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
                                    </div>


                                </div>




                                <p class="product-minimal-quantity">
                                </p>

                            </div>


                            <div class="product-additional-info">
                                <!-- begin /var/www/html/demo/rb_evo_demo/themes/rb_evo/modules/ps_sharebuttons/views/templates/hook/ps_sharebuttons.tpl -->

                                <div class="social-sharing">
                                    <span class="share-this"><i class="fa fa-share-alt"></i>Share
                                        this:</span>
                                    <ul>
                                        <li class="facebook">
                                            <a href="https://www.facebook.com/sharer.php?u=https%3A%2F%2Frubiktheme.com%2Fdemo%2Frb_evo_demo%2Fen%2Fwomen%2F3-the-best-is-yet-to-come-framed-poster.html"
                                                title="Share" target="_blank" rel="noopener noreferrer">
                                                <i class="fa fa-facebook" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                        <li class="twitter">
                                            <a href="https://twitter.com/intent/tweet?text=Cashmere+Tank https%3A%2F%2Frubiktheme.com%2Fdemo%2Frb_evo_demo%2Fen%2Fwomen%2F3-the-best-is-yet-to-come-framed-poster.html"
                                                title="Tweet" target="_blank" rel="noopener noreferrer">
                                                <i class="fa fa-twitter" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                        <li class="pinterest">
                                            <a href="https://www.pinterest.com/pin/create/button/?media=https%3A%2F%2Frubiktheme.com%2Fdemo%2Frb_evo_demo%2F110%2Fthe-best-is-yet-to-come-framed-poster.jpg&amp;url=https%3A%2F%2Frubiktheme.com%2Fdemo%2Frb_evo_demo%2Fen%2Fwomen%2F3-the-best-is-yet-to-come-framed-poster.html"
                                                title="Pinterest" target="_blank" rel="noopener noreferrer">
                                                <i class="fa fa-pinterest-p" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>



                            <a class="rb-print rb-btn-product" href="javascript:print();">
                                <i class="fa fa-print"></i>
                                Print
                            </a>


                            <div class="rb-tag-cate">
                                <div class="rb-category">
                                    <label class="title-cate">
                                        <i class="material-icons">edit</i>
                                        Categories:
                                    </label>


                                    <?php
                                                $categories = explode("/",$ProductDetails['product_categories']);
                                                foreach ($categories as $key => $value) {
                                                    ?>
                                    <span class="rb-items">
                                        <a href="" target="_blank" title="Shop">
                                            <?= $value.', ' ?>
                                        </a>
                                    </span>

                                    <?php 
                                                }                           
                                            ?>

                                </div>

                                <div class="rb-tag">
                                    <label class="title-tag">
                                        <i class="material-icons">bookmark_border</i>
                                        Tags:
                                    </label>

                                    <?php
                                                $tags = explode(",",$ProductDetails['product_tags']);
                                                foreach ($tags as $key => $value) {
                                                    ?>
                                    <span class="rb-items">
                                        <a href="" target="_blank" title="">
                                            <?= trim($value, " ") ?>
                                        </a>
                                    </span>


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
                                            <p style="color:#000000;">(edit with the Customer
                                                Reassurance module)</p>

                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="block-reassurance-item">
                                        <img src="media/carrier.svg" alt="Delivery policy">
                                        <div>
                                            <span style="color:#000000;">Delivery policy</span>
                                            <p style="color:#000000;">(edit with the Customer
                                                Reassurance module)</p>

                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="block-reassurance-item">
                                        <img src="media/parcel.svg" alt="Return policy">
                                        <div>
                                            <span style="color:#000000;">Return policy</span>
                                            <p style="color:#000000;">(edit with the Customer
                                                Reassurance module)</p>

                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>


                    </div>
            </div>

            <div class="col-xs-12">

                <div class="product-tabs tabs">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#description" role="tab"
                                aria-controls="description" aria-selected="true">
                                Description
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#product-details" role="tab"
                                aria-controls="product-details">
                                Product Details
                            </a>
                        </li>

                        <li class="nav-item" id="rb_li_review">
                            <a class="nav-link" data-toggle="tab" href="#rb_review" role="tab"
                                aria-controls="rb_review">
                                Review
                                <span class="rb-number-review">(<?= mysqli_num_rows($pro_res_modal) ?>)</span>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content" id="tab-content">
                        <div class="tab-pane fade in active" id="description" role="tabpanel">

                            <div class="product-description">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <table class="table table-striped table-borderless h-font text-uppercase"
                                            width="955" style="height:137px;">
                                            <tbody>
                                                <tr>
                                                    <td>Size</td>
                                                    <td><b><?= $ProductDetails['product_size'] ?></b></td>
                                                </tr>
                                                <tr>
                                                    <td><span>Waist (cm)</span></td>
                                                    <td><b><?= $ProductDetails['product_waist'] ?></b></td>
                                                </tr>
                                                <tr>
                                                    <td>Hips (cm)</td>
                                                    <td><b><?= $ProductDetails['product_hips'] ?></b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><span>Weight</span></td>
                                                    <td><b><?= $ProductDetails['product_weight'] ?></b></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="mt-30 mt-lg-55">
                                            <p> </p>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <p><?= $ProductDetails['product_desc_long'] ?></p>
                                    </div>
                                </div>
                            </div>

                        </div>


                        <div class="tab-pane fade" id="product-details"
                            data-product="{&quot;id_shop_default&quot;:&quot;1&quot;,&quot;id_manufacturer&quot;:&quot;2&quot;,&quot;id_supplier&quot;:&quot;0&quot;,&quot;reference&quot;:&quot;demo_6&quot;,&quot;is_virtual&quot;:&quot;0&quot;,&quot;delivery_in_stock&quot;:null,&quot;delivery_out_stock&quot;:null,&quot;id_category_default&quot;:&quot;6&quot;,&quot;on_sale&quot;:&quot;0&quot;,&quot;online_only&quot;:&quot;0&quot;,&quot;ecotax&quot;:0,&quot;minimal_quantity&quot;:&quot;1&quot;,&quot;low_stock_threshold&quot;:&quot;0&quot;,&quot;low_stock_alert&quot;:&quot;0&quot;,&quot;price&quot;:&quot;$29.00&quot;,&quot;unity&quot;:null,&quot;unit_price_ratio&quot;:&quot;0.000000&quot;,&quot;additional_shipping_cost&quot;:&quot;0.000000&quot;,&quot;customizable&quot;:&quot;0&quot;,&quot;text_fields&quot;:&quot;0&quot;,&quot;uploadable_files&quot;:&quot;0&quot;,&quot;redirect_type&quot;:&quot;301-category&quot;,&quot;id_type_redirected&quot;:&quot;0&quot;,&quot;available_for_order&quot;:&quot;1&quot;,&quot;available_date&quot;:null,&quot;show_condition&quot;:&quot;0&quot;,&quot;condition&quot;:&quot;new&quot;,&quot;show_price&quot;:&quot;1&quot;,&quot;indexed&quot;:&quot;1&quot;,&quot;visibility&quot;:&quot;both&quot;,&quot;cache_default_attribute&quot;:&quot;13&quot;,&quot;advanced_stock_management&quot;:&quot;0&quot;,&quot;date_add&quot;:&quot;2021-03-08 04:52:07&quot;,&quot;date_upd&quot;:&quot;2021-07-13 06:00:42&quot;,&quot;pack_stock_type&quot;:&quot;3&quot;,&quot;meta_description&quot;:null,&quot;meta_keywords&quot;:null,&quot;meta_title&quot;:null,&quot;link_rewrite&quot;:&quot;the-best-is-yet-to-come-framed-poster&quot;,&quot;name&quot;:&quot;Cashmere Tank&quot;,&quot;description&quot;:&quot;&lt;div class=\&quot;row\&quot;&gt;\r\n&lt;div class=\&quot;col-md-12 col-sm-12 col-xs-12\&quot;&gt;\r\n&lt;table class=\&quot;table table-striped table-borderless h-font text-uppercase\&quot; width=\&quot;955\&quot; style=\&quot;height:137px;\&quot;&gt;\r\n&lt;tbody&gt;\r\n&lt;tr&gt;\r\n&lt;td&gt;Name&lt;\/td&gt;\r\n&lt;td&gt;&lt;b&gt;Glasses&lt;\/b&gt;&lt;\/td&gt;\r\n&lt;\/tr&gt;\r\n&lt;tr&gt;\r\n&lt;td&gt;User&lt;\/td&gt;\r\n&lt;td&gt;&lt;b&gt;Unisex&lt;\/b&gt;&lt;\/td&gt;\r\n&lt;\/tr&gt;\r\n&lt;tr&gt;\r\n&lt;td&gt;Collection&lt;\/td&gt;\r\n&lt;td&gt;&lt;b&gt;Accessories&lt;\/b&gt;&lt;\/td&gt;\r\n&lt;\/tr&gt;\r\n&lt;tr&gt;\r\n&lt;td&gt;Size&lt;\/td&gt;\r\n&lt;td&gt;&lt;b&gt;XS, S, M , L, XL&lt;\/b&gt;&lt;\/td&gt;\r\n&lt;\/tr&gt;\r\n&lt;tr&gt;\r\n&lt;td&gt;&lt;span&gt;Waist (cm)&lt;\/span&gt;&lt;\/td&gt;\r\n&lt;td&gt;&lt;b&gt;60 - 66, 67 - 73, 74 - 81, 82 - 88, 89 - 95&lt;\/b&gt;&lt;\/td&gt;\r\n&lt;\/tr&gt;\r\n&lt;tr&gt;\r\n&lt;td&gt;Hips (cm)&lt;\/td&gt;\r\n&lt;td&gt;&lt;b&gt;80 - 85, 86 - 90, 91 - 95, 96 - 100&lt;\/b&gt;&lt;\/td&gt;\r\n&lt;\/tr&gt;\r\n&lt;tr&gt;\r\n&lt;td&gt;&lt;span&gt;Weight&lt;\/span&gt;&lt;\/td&gt;\r\n&lt;td&gt;&lt;b&gt;0.05, 0.06, 0.07&lt;\/b&gt;&lt;\/td&gt;\r\n&lt;\/tr&gt;\r\n&lt;\/tbody&gt;\r\n&lt;\/table&gt;\r\n&lt;div class=\&quot;mt-30 mt-lg-55\&quot;&gt;\r\n&lt;p&gt;\u00a0&lt;\/p&gt;\r\n&lt;\/div&gt;\r\n&lt;\/div&gt;\r\n&lt;div class=\&quot;col-md-8 col-sm-8 col-xs-12\&quot;&gt;\r\n&lt;p&gt;Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.&lt;\/p&gt;\r\n&lt;p&gt;&lt;span&gt;Donec fringilla sapien sed elit luctus, eget mattis dolor efficitur. Ut id libero nulla. Morbi aliquam tortor massa, in aliquet eros molestie in. Quisque eleifend diam leo, a bibendum mi eleifend eget.&lt;\/span&gt;&lt;\/p&gt;\r\n&lt;p&gt;&lt;em&gt;Sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.&lt;\/em&gt;&lt;\/p&gt;\r\n&lt;\/div&gt;\r\n&lt;div style=\&quot;text-align:left;\&quot; class=\&quot;col-md-4 col-sm-4 col-xs-12 hidden-xs\&quot;&gt;&lt;img alt=\&quot;\&quot; src=\&quot;https:\/\/cdn.shopify.com\/s\/files\/1\/0577\/6284\/0772\/files\/5-3-840x960_480x480.jpg?v=1623920601\&quot; \/&gt;&lt;\/div&gt;\r\n&lt;\/div&gt;&quot;,&quot;description_short&quot;:&quot;&lt;p&gt;Donec fringilla sapien sed elit luctus, eget mattis dolor efficitur. Ut id libero nulla. Morbi aliquam tortor massa, in aliquet eros molestie in. Quisque eleifend diam leo, a bibendum mi eleifend eget.&lt;\/p&gt;&quot;,&quot;available_now&quot;:null,&quot;available_later&quot;:null,&quot;id&quot;:3,&quot;id_product&quot;:3,&quot;out_of_stock&quot;:2,&quot;new&quot;:0,&quot;id_product_attribute&quot;:13,&quot;quantity_wanted&quot;:1,&quot;extraContent&quot;:[{&quot;title&quot;:&quot;Facebook Comments&quot;,&quot;content&quot;:&quot;&lt;div id=\&quot;fcbc\&quot;&gt;&lt;fb:comments href=\&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/women\/3-13-the-best-is-yet-to-come-framed-poster.html\&quot; colorscheme=\&quot;light\&quot; width=\&quot;100%\&quot;&gt;&lt;\/fb:comments&gt;&lt;\/div&gt;&quot;,&quot;attr&quot;:{&quot;id&quot;:&quot;&quot;,&quot;class&quot;:&quot;&quot;},&quot;moduleName&quot;:&quot;rbthemefunction&quot;}],&quot;allow_oosp&quot;:0,&quot;category&quot;:&quot;women&quot;,&quot;category_name&quot;:&quot;Women&quot;,&quot;link&quot;:&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/women\/3-the-best-is-yet-to-come-framed-poster.html&quot;,&quot;attribute_price&quot;:0,&quot;price_tax_exc&quot;:29,&quot;price_without_reduction&quot;:29,&quot;reduction&quot;:0,&quot;specific_prices&quot;:[],&quot;quantity&quot;:899,&quot;quantity_all_versions&quot;:1500,&quot;id_image&quot;:&quot;en-default&quot;,&quot;features&quot;:[{&quot;name&quot;:&quot;Composition&quot;,&quot;value&quot;:&quot;Matt paper&quot;,&quot;id_feature&quot;:&quot;1&quot;,&quot;position&quot;:&quot;0&quot;}],&quot;attachments&quot;:[],&quot;virtual&quot;:0,&quot;pack&quot;:0,&quot;packItems&quot;:[],&quot;nopackprice&quot;:0,&quot;customization_required&quot;:false,&quot;attributes&quot;:{&quot;3&quot;:{&quot;id_attribute&quot;:&quot;19&quot;,&quot;id_attribute_group&quot;:&quot;3&quot;,&quot;name&quot;:&quot;40x60cm&quot;,&quot;group&quot;:&quot;Dimension&quot;,&quot;reference&quot;:&quot;demo_6&quot;,&quot;ean13&quot;:null,&quot;isbn&quot;:null,&quot;upc&quot;:null,&quot;mpn&quot;:null}},&quot;rate&quot;:0,&quot;tax_name&quot;:&quot;&quot;,&quot;ecotax_rate&quot;:0,&quot;unit_price&quot;:&quot;&quot;,&quot;customizations&quot;:{&quot;fields&quot;:[]},&quot;id_customization&quot;:0,&quot;is_customizable&quot;:false,&quot;show_quantities&quot;:true,&quot;quantity_label&quot;:&quot;Items&quot;,&quot;quantity_discounts&quot;:[],&quot;customer_group_discount&quot;:0,&quot;images&quot;:[{&quot;bySize&quot;:{&quot;cart_default&quot;:{&quot;url&quot;:&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/110-cart_default\/the-best-is-yet-to-come-framed-poster.jpg&quot;,&quot;width&quot;:200,&quot;height&quot;:229},&quot;small_default&quot;:{&quot;url&quot;:&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/110-small_default\/the-best-is-yet-to-come-framed-poster.jpg&quot;,&quot;width&quot;:200,&quot;height&quot;:229},&quot;medium_default&quot;:{&quot;url&quot;:&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/110-medium_default\/the-best-is-yet-to-come-framed-poster.jpg&quot;,&quot;width&quot;:452,&quot;height&quot;:517},&quot;home_default&quot;:{&quot;url&quot;:&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/110-home_default\/the-best-is-yet-to-come-framed-poster.jpg&quot;,&quot;width&quot;:600,&quot;height&quot;:686},&quot;thickbox_default&quot;:{&quot;url&quot;:&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/110-thickbox_default\/the-best-is-yet-to-come-framed-poster.jpg&quot;,&quot;width&quot;:600,&quot;height&quot;:686},&quot;large_default&quot;:{&quot;url&quot;:&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/110-large_default\/the-best-is-yet-to-come-framed-poster.jpg&quot;,&quot;width&quot;:840,&quot;height&quot;:960}},&quot;small&quot;:{&quot;url&quot;:&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/110-cart_default\/the-best-is-yet-to-come-framed-poster.jpg&quot;,&quot;width&quot;:200,&quot;height&quot;:229},&quot;medium&quot;:{&quot;url&quot;:&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/110-home_default\/the-best-is-yet-to-come-framed-poster.jpg&quot;,&quot;width&quot;:600,&quot;height&quot;:686},&quot;large&quot;:{&quot;url&quot;:&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/110-large_default\/the-best-is-yet-to-come-framed-poster.jpg&quot;,&quot;width&quot;:840,&quot;height&quot;:960},&quot;legend&quot;:null,&quot;id_image&quot;:&quot;110&quot;,&quot;cover&quot;:&quot;1&quot;,&quot;position&quot;:&quot;1&quot;,&quot;associatedVariants&quot;:[]},{&quot;bySize&quot;:{&quot;cart_default&quot;:{&quot;url&quot;:&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/111-cart_default\/the-best-is-yet-to-come-framed-poster.jpg&quot;,&quot;width&quot;:200,&quot;height&quot;:229},&quot;small_default&quot;:{&quot;url&quot;:&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/111-small_default\/the-best-is-yet-to-come-framed-poster.jpg&quot;,&quot;width&quot;:200,&quot;height&quot;:229},&quot;medium_default&quot;:{&quot;url&quot;:&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/111-medium_default\/the-best-is-yet-to-come-framed-poster.jpg&quot;,&quot;width&quot;:452,&quot;height&quot;:517},&quot;home_default&quot;:{&quot;url&quot;:&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/111-home_default\/the-best-is-yet-to-come-framed-poster.jpg&quot;,&quot;width&quot;:600,&quot;height&quot;:686},&quot;thickbox_default&quot;:{&quot;url&quot;:&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/111-thickbox_default\/the-best-is-yet-to-come-framed-poster.jpg&quot;,&quot;width&quot;:600,&quot;height&quot;:686},&quot;large_default&quot;:{&quot;url&quot;:&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/111-large_default\/the-best-is-yet-to-come-framed-poster.jpg&quot;,&quot;width&quot;:840,&quot;height&quot;:960}},&quot;small&quot;:{&quot;url&quot;:&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/111-cart_default\/the-best-is-yet-to-come-framed-poster.jpg&quot;,&quot;width&quot;:200,&quot;height&quot;:229},&quot;medium&quot;:{&quot;url&quot;:&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/111-home_default\/the-best-is-yet-to-come-framed-poster.jpg&quot;,&quot;width&quot;:600,&quot;height&quot;:686},&quot;large&quot;:{&quot;url&quot;:&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/111-large_default\/the-best-is-yet-to-come-framed-poster.jpg&quot;,&quot;width&quot;:840,&quot;height&quot;:960},&quot;legend&quot;:null,&quot;id_image&quot;:&quot;111&quot;,&quot;cover&quot;:null,&quot;position&quot;:&quot;2&quot;,&quot;associatedVariants&quot;:[]},{&quot;bySize&quot;:{&quot;cart_default&quot;:{&quot;url&quot;:&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/112-cart_default\/the-best-is-yet-to-come-framed-poster.jpg&quot;,&quot;width&quot;:200,&quot;height&quot;:229},&quot;small_default&quot;:{&quot;url&quot;:&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/112-small_default\/the-best-is-yet-to-come-framed-poster.jpg&quot;,&quot;width&quot;:200,&quot;height&quot;:229},&quot;medium_default&quot;:{&quot;url&quot;:&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/112-medium_default\/the-best-is-yet-to-come-framed-poster.jpg&quot;,&quot;width&quot;:452,&quot;height&quot;:517},&quot;home_default&quot;:{&quot;url&quot;:&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/112-home_default\/the-best-is-yet-to-come-framed-poster.jpg&quot;,&quot;width&quot;:600,&quot;height&quot;:686},&quot;thickbox_default&quot;:{&quot;url&quot;:&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/112-thickbox_default\/the-best-is-yet-to-come-framed-poster.jpg&quot;,&quot;width&quot;:600,&quot;height&quot;:686},&quot;large_default&quot;:{&quot;url&quot;:&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/112-large_default\/the-best-is-yet-to-come-framed-poster.jpg&quot;,&quot;width&quot;:840,&quot;height&quot;:960}},&quot;small&quot;:{&quot;url&quot;:&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/112-cart_default\/the-best-is-yet-to-come-framed-poster.jpg&quot;,&quot;width&quot;:200,&quot;height&quot;:229},&quot;medium&quot;:{&quot;url&quot;:&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/112-home_default\/the-best-is-yet-to-come-framed-poster.jpg&quot;,&quot;width&quot;:600,&quot;height&quot;:686},&quot;large&quot;:{&quot;url&quot;:&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/112-large_default\/the-best-is-yet-to-come-framed-poster.jpg&quot;,&quot;width&quot;:840,&quot;height&quot;:960},&quot;legend&quot;:null,&quot;id_image&quot;:&quot;112&quot;,&quot;cover&quot;:null,&quot;position&quot;:&quot;3&quot;,&quot;associatedVariants&quot;:[]},{&quot;bySize&quot;:{&quot;cart_default&quot;:{&quot;url&quot;:&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/113-cart_default\/the-best-is-yet-to-come-framed-poster.jpg&quot;,&quot;width&quot;:200,&quot;height&quot;:229},&quot;small_default&quot;:{&quot;url&quot;:&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/113-small_default\/the-best-is-yet-to-come-framed-poster.jpg&quot;,&quot;width&quot;:200,&quot;height&quot;:229},&quot;medium_default&quot;:{&quot;url&quot;:&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/113-medium_default\/the-best-is-yet-to-come-framed-poster.jpg&quot;,&quot;width&quot;:452,&quot;height&quot;:517},&quot;home_default&quot;:{&quot;url&quot;:&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/113-home_default\/the-best-is-yet-to-come-framed-poster.jpg&quot;,&quot;width&quot;:600,&quot;height&quot;:686},&quot;thickbox_default&quot;:{&quot;url&quot;:&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/113-thickbox_default\/the-best-is-yet-to-come-framed-poster.jpg&quot;,&quot;width&quot;:600,&quot;height&quot;:686},&quot;large_default&quot;:{&quot;url&quot;:&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/113-large_default\/the-best-is-yet-to-come-framed-poster.jpg&quot;,&quot;width&quot;:840,&quot;height&quot;:960}},&quot;small&quot;:{&quot;url&quot;:&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/113-cart_default\/the-best-is-yet-to-come-framed-poster.jpg&quot;,&quot;width&quot;:200,&quot;height&quot;:229},&quot;medium&quot;:{&quot;url&quot;:&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/113-home_default\/the-best-is-yet-to-come-framed-poster.jpg&quot;,&quot;width&quot;:600,&quot;height&quot;:686},&quot;large&quot;:{&quot;url&quot;:&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/113-large_default\/the-best-is-yet-to-come-framed-poster.jpg&quot;,&quot;width&quot;:840,&quot;height&quot;:960},&quot;legend&quot;:null,&quot;id_image&quot;:&quot;113&quot;,&quot;cover&quot;:null,&quot;position&quot;:&quot;4&quot;,&quot;associatedVariants&quot;:[]}],&quot;cover&quot;:{&quot;bySize&quot;:{&quot;cart_default&quot;:{&quot;url&quot;:&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/110-cart_default\/the-best-is-yet-to-come-framed-poster.jpg&quot;,&quot;width&quot;:200,&quot;height&quot;:229},&quot;small_default&quot;:{&quot;url&quot;:&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/110-small_default\/the-best-is-yet-to-come-framed-poster.jpg&quot;,&quot;width&quot;:200,&quot;height&quot;:229},&quot;medium_default&quot;:{&quot;url&quot;:&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/110-medium_default\/the-best-is-yet-to-come-framed-poster.jpg&quot;,&quot;width&quot;:452,&quot;height&quot;:517},&quot;home_default&quot;:{&quot;url&quot;:&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/110-home_default\/the-best-is-yet-to-come-framed-poster.jpg&quot;,&quot;width&quot;:600,&quot;height&quot;:686},&quot;thickbox_default&quot;:{&quot;url&quot;:&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/110-thickbox_default\/the-best-is-yet-to-come-framed-poster.jpg&quot;,&quot;width&quot;:600,&quot;height&quot;:686},&quot;large_default&quot;:{&quot;url&quot;:&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/110-large_default\/the-best-is-yet-to-come-framed-poster.jpg&quot;,&quot;width&quot;:840,&quot;height&quot;:960}},&quot;small&quot;:{&quot;url&quot;:&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/110-cart_default\/the-best-is-yet-to-come-framed-poster.jpg&quot;,&quot;width&quot;:200,&quot;height&quot;:229},&quot;medium&quot;:{&quot;url&quot;:&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/110-home_default\/the-best-is-yet-to-come-framed-poster.jpg&quot;,&quot;width&quot;:600,&quot;height&quot;:686},&quot;large&quot;:{&quot;url&quot;:&quot;https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/110-large_default\/the-best-is-yet-to-come-framed-poster.jpg&quot;,&quot;width&quot;:840,&quot;height&quot;:960},&quot;legend&quot;:null,&quot;id_image&quot;:&quot;110&quot;,&quot;cover&quot;:&quot;1&quot;,&quot;position&quot;:&quot;1&quot;,&quot;associatedVariants&quot;:[]},&quot;has_discount&quot;:false,&quot;discount_type&quot;:null,&quot;discount_percentage&quot;:null,&quot;discount_percentage_absolute&quot;:null,&quot;discount_amount&quot;:null,&quot;discount_amount_to_display&quot;:null,&quot;price_amount&quot;:29,&quot;unit_price_full&quot;:&quot;&quot;,&quot;show_availability&quot;:true,&quot;availability_date&quot;:null,&quot;availability_message&quot;:&quot;&quot;,&quot;availability&quot;:&quot;available&quot;}"
                            role="tabpanel">

                            <div class="product-manufacturer">
                                <a href="<?= FRONT_SITE_PATH.'brand?brand_name='.$ProductDetails['brand_name'] ?>">
                                    <img src="<?= FRONT_SITE_IMAGE_BRAND.$ProductDetails['brand_img'] ?>"
                                        class="img img-thumbnail manufacturer-logo" alt="Studio Design">
                                </a>
                            </div>

                            <div class="product-quantities">
                                <label class="label">In stock</label>
                                <span data-stock="899"
                                    data-allow-oosp="0"><?= RemainingStock($ProductDetails['id']) ?></span>
                            </div>






                            <div class="product-out-of-stock">

                            </div>



                            <section class="product-features">
                                <p class="h6">Data sheet</p>
                                <dl class="data-sheet">

                                    <?php
                                                 $ProductDataSheetById = ProductDataSheetById($ProductDetails['id']);
                                                    foreach ($ProductDataSheetById as $key => $value) {
                                                        ?>
                                    <dt class="name"><?= $value['data_sheet_name'] ?></dt>
                                    <dd class="value"><?= $value['data_sheet_desc'] ?></dd>
                                    <?php
                                                    }
                                                 ?>

                                </dl>
                            </section>







                        </div>

                        <div class="tab-pane fade in "  id="rb_review" role="tabpanel">
                            <?php
                              
                              if (mysqli_num_rows($pro_res) > 0) {
                                  
                                  while($pro_row = mysqli_fetch_assoc($pro_res)) {
                                    $UsersDetails_rate = UsersDetails("WHERE id = '".$pro_row['rate_user_id']."'");
                                    $UsersDetails_rate = $UsersDetails_rate[0];
                                    ?>
                                        <div class="product_reviews_block_tab">
                                            <div class="rb-review-list">
                                                <div id="product_reviews_block">
                                                    <div class="review" itemprop="review" itemscope=""
                                                        itemtype="https://schema.org/Review">
                                                        <div class="review-info">
                                                            <div class="author_image"> <img alt=""
                                                                    src="<?= USER_PROFILE.$UsersDetails_rate['user_img'] ?>"
                                                                    class="avatar avatar-60 photo" height="60" width="60"></div>
                                                            <div class="comment-text">
                                                                <div class="review_author">
                                                                    <div class="review_author_infos"> <strong itemprop="author"><?= $UsersDetails_rate['firstname'].' '.$UsersDetails_rate['lastname'] ?></strong>
                                                                        <meta itemprop="datePublished" content="<?= date("Y-m-d", strtotime($pro_row['rate_added_on']))  ?>"> <em>-
                                                                            <?= date("D M d, Y  h:i A", strtotime($pro_row['rate_added_on'])) ?></em>
                                                                    </div>
                                                                    
                                                                    <?= star_rate($pro_row['rated_no']) ?>
                                                                </div>
                                                                <div class="review-detail mt-2">
                                                                    <p itemprop="reviewBody"><?= $pro_row['rate_comment'] ?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>  
                                            </div>
                                        </div>
                                    <?php
                                  }
                              }
                             
                               
                              else{
                                  ?>
                                    <div class="product_reviews_block_tab">
                                        <div class="rb-review-list">
                                            <p class="alert alert-info">No comment at this time.</p>
                                        </div>
                                    </div>
                            <?php
                              }

                              if (mysqli_num_rows($pro_res_modal) > 5) {
                                ?>
                                  <!-- Button trigger modal -->
                                  <div class="container  w-100" style="display:flex;justify-content:center">
                                      <button type="button" class="btn btn-success " data-toggle="modal" data-target="#exampleModal">
                                          Show more Review
                                      </button>
                                  </div>

                                  <!-- Modal -->
                                  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                      <div class="modal-dialog" role="document">
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                  <h5 class="modal-title" id="exampleModalLongTitle">Comments (<?= mysqli_num_rows($pro_res_modal) ?>)</h5>
                                                  <button  class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                  </button>
                                              </div>
                                              <div class="modal-body">
                                                  <?php
                                                      
                                                      while($pro_row_modal = mysqli_fetch_assoc($pro_res_modal)) {
                                                          ?>
                                                              <div class="container">
                                                                  <div class="product_reviews_block_tab">
                                                                      <div class="rb-review-list">
                                                                          <div id="product_reviews_block">
                                                                              <div class="review" itemprop="review" itemscope=""
                                                                                  itemtype="https://schema.org/Review">
                                                                                  <div class="review-info">
                                                                                      <div class="author_image"> <img alt=""
                                                                                              src="<?= USER_PROFILE.$UsersDetails_rate['user_img'] ?>"
                                                                                              class="avatar avatar-60 photo" height="60" width="60"></div>
                                                                                      <div class="comment-text">
                                                                                          <div class="review_author">
                                                                                              <div class="review_author_infos"> <strong itemprop="author"><?= $UsersDetails_rate['firstname'].' '.$UsersDetails_rate['lastname'] ?></strong>
                                                                                                  <meta itemprop="datePublished" content="<?= date("Y-m-d", strtotime($pro_row['rate_added_on']))  ?>"> <em>-
                                                                                                      <?= date("D M d, Y  h:i A", strtotime($pro_row_modal['rate_added_on'])) ?></em>
                                                                                              </div>
                                                                                              <?= star_rate($pro_row_modal['rated_no']) ?>
                                                                                          </div>
                                                                                          <div class="review-detail mt-2">
                                                                                              <p itemprop="reviewBody"><?= $pro_row_modal['rate_comment'] ?></p>
                                                                                          </div>
                                                                                      </div>
                                                                                  </div>
                                                                              </div>
                                                                          </div>  
                                                                      </div>
                                                                  </div>
                                                              </div>
                                                          <?php
                                                      }
                                                  ?>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                <?php
                            }
                           ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- begin /var/www/html/demo/rb_evo_demo/themes/rb_evo/modules/ps_categoryproducts/views/templates/hook/ps_categoryproducts.tpl -->
        <section class="featured-products clearfix mt-3">
            <h2 class="products-section-title">
                Related Products
                <span class="count-same-category">
                    (There are 16 other products in the same category)
                </span>
            </h2>
            <div class="products featured-products-slick">

                <div itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    <article class="product-miniature js-product-miniature " data-id-product="17"
                        data-id-product-attribute="32" itemscope itemtype="http://schema.org/Product">
                        <div class="thumbnail-container">
                            <div class="product-image">

                                <a href="https://rubiktheme.com/demo/rb_evo_demo/en/clothing/17-32-brown-bear-notebook.html#/22-paper_type-ruled"
                                    class="thumbnail product-thumbnail">
                                    <img class="img-fluid rb-image image-cover"
                                        data-lazy="https://rubiktheme.com/demo/rb_evo_demo/163-home_default/brown-bear-notebook.jpg"
                                        data-full-size-image-url="https://rubiktheme.com/demo/rb_evo_demo/163-large_default/brown-bear-notebook.jpg">


                                    <div class="product-hover">
                                        <img class="img-fluid rb-image image-hover"
                                            data-lazy="https://rubiktheme.com/demo/rb_evo_demo/164-home_default/brown-bear-notebook.jpg"
                                            title="Crossover Leather Sandal" width="600" height="686">
                                    </div>


                                    <div class="rb-image-loading"></div>
                                </a>



                                <ul class="product-flags">
                                    <span class="sr-only">Price</span>

                                </ul>


                                <div class="rb-ajax-loading">
                                    <div class="cssload-container">
                                        <div class="cssload-speeding-wheel"></div>
                                    </div>
                                </div>
                                <div class="functional-buttons clearfix">

                                    <div class="product-add-cart">
                                        <form action="https://rubiktheme.com/demo/rb_evo_demo/en/cart" method="post"
                                            class="add-to-cart-or-refresh">
                                            <input type="hidden" name="token" value="9e645ea2b011b9302f90d49f848c7122">
                                            <input type="hidden" name="id_product" value="17"
                                                class="product_page_product_id">

                                            <!-- begin /var/www/html/demo/rb_evo_demo/themes/rb_evo/modules/rbthemefunction/views/templates/hook/rb-cart.tpl -->
                                            <div class="product-add-to-cart-rb">

                                                <div class="product-quantity">
                                                    <div class="add">
                                                        <button class="btn rb-btn-product add-to-cart"
                                                            title="Add to cart" data-button-action="add-to-cart"
                                                            type="submit">
                                                            <i class="icon-Ico_Cart"></i>
                                                            <span class="icon-title">Add To
                                                                Cart</span>
                                                        </button>


                                                        <span class="product-availability hidden">
                                                        </span>

                                                    </div>
                                                </div>



                                                <p class="product-minimal-quantity hidden">
                                                </p>

                                            </div>
                                        </form>
                                    </div>


                                    <div class="rb-wishlist">
                                        <a class="rb-wishlist-link rb-btn-product " href="#" data-id-wishlist=""
                                            data-id-product="17" data-id-product-attribute="32"
                                            data-id_wishlist_product="0" title="Add to Wishlist">
                                            <i class="icon-btn-product icon-wishlist icon-Icon_Wishlist"></i>
                                            <span class="icon-title">Add to Wishlist</span>
                                        </a>
                                    </div>



                                    <div class="product-quickview hidden-sm-down">
                                        <a class="rb-quick-view rb-btn-product" href="#" data-link-action="quickview">
                                            <i class="icon-Icon_Quick-view"></i>
                                            <span class="icon-title">Quick view</span>
                                        </a>
                                    </div>

                                    <div class="product-quick-view" style="display:none;">
                                        <a class="quick-view rb-btn-product" href="#" data-link-action="quickview">
                                            <i class="icon-Icon_Quick-view search"></i>
                                            <span class="icon-title">Quick view</span>
                                        </a>
                                    </div>


                                </div>




                            </div>


                            <div class="product-meta">
                                <div class="meta-top">

                                    <h3 class="h3 product-brand" itemprop="brand">
                                        <span>Brand: </span>
                                        <a href="https://rubiktheme.com/demo/rb_evo_demo/en/brand/2-graphic-corner"
                                            tabindex="0">Graphic Corner</a>
                                    </h3>



                                    <div class="star_content clearfix">
                                        <div class="star"></div>
                                        <div class="star"></div>
                                        <div class="star"></div>
                                        <div class="star"></div>
                                        <div class="star"></div>
                                        <meta itemprop="worstRating" content="0" />
                                        <meta itemprop="ratingValue" content="0" />
                                        <meta itemprop="bestRating" content="5" />
                                    </div>






                                </div>


                                <h2 class="h3 product-title" itemprop="name"><a href="" itemprop="url"
                                        content="https://rubiktheme.com/demo/rb_evo_demo/en/clothing/17-32-brown-bear-notebook.html#/22-paper_type-ruled">Crossover
                                        Leather Sandal</a></h2>



                                <div class="product-price-and-shipping">




                                    <span class="price" aria-label="Price">$12.90</span>
                                    <div itemprop="offers" itemscope itemtype="http://schema.org/Offer"
                                        class="invisible">
                                        <meta itemprop="priceCurrency" content="USD" />
                                        <meta itemprop="price" content="12.9" />
                                    </div>




                                </div>

                            </div>

                        </div>
                    </article>
                </div>

                <div itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    <article class="product-miniature js-product-miniature " data-id-product="11"
                        data-id-product-attribute="26" itemscope itemtype="http://schema.org/Product">
                        <div class="thumbnail-container">
                            <div class="product-image">

                                <a href="https://rubiktheme.com/demo/rb_evo_demo/en/leather-goods/11-26-hummingbird-cushion.html#/8-color-white"
                                    class="thumbnail product-thumbnail">
                                    <img class="img-fluid rb-image image-cover"
                                        data-lazy="https://rubiktheme.com/demo/rb_evo_demo/141-home_default/hummingbird-cushion.jpg"
                                        data-full-size-image-url="https://rubiktheme.com/demo/rb_evo_demo/141-large_default/hummingbird-cushion.jpg">


                                    <div class="product-hover">
                                        <img class="img-fluid rb-image image-hover"
                                            data-lazy="https://rubiktheme.com/demo/rb_evo_demo/142-home_default/hummingbird-cushion.jpg"
                                            title="Minimal Square Tote" width="600" height="686">
                                    </div>


                                    <div class="rb-image-loading"></div>
                                </a>



                                <ul class="product-flags">
                                    <span class="sr-only">Price</span>

                                </ul>


                                <div class="rb-ajax-loading">
                                    <div class="cssload-container">
                                        <div class="cssload-speeding-wheel"></div>
                                    </div>
                                </div>
                                <div class="functional-buttons clearfix">

                                    <div class="product-add-cart">
                                        <form action="https://rubiktheme.com/demo/rb_evo_demo/en/cart" method="post"
                                            class="add-to-cart-or-refresh">
                                            <input type="hidden" name="token" value="9e645ea2b011b9302f90d49f848c7122">
                                            <input type="hidden" name="id_product" value="11"
                                                class="product_page_product_id">

                                            <!-- begin /var/www/html/demo/rb_evo_demo/themes/rb_evo/modules/rbthemefunction/views/templates/hook/rb-cart.tpl -->
                                            <div class="product-add-to-cart-rb">

                                                <div class="product-quantity">
                                                    <div class="add">
                                                        <button class="btn rb-btn-product add-to-cart"
                                                            title="Add to cart" data-button-action="add-to-cart"
                                                            type="submit">
                                                            <i class="icon-Ico_Cart"></i>
                                                            <span class="icon-title">Add To
                                                                Cart</span>
                                                        </button>


                                                        <span class="product-availability hidden">
                                                        </span>

                                                    </div>
                                                </div>



                                                <p class="product-minimal-quantity hidden">
                                                </p>

                                            </div>
                                            <!-- end /var/www/html/demo/rb_evo_demo/themes/rb_evo/modules/rbthemefunction/views/templates/hook/rb-cart.tpl -->
                                        </form>
                                    </div>


                                    <div class="rb-wishlist">
                                        <a class="rb-wishlist-link rb-btn-product " href="#" data-id-wishlist=""
                                            data-id-product="11" data-id-product-attribute="26"
                                            data-id_wishlist_product="0" title="Add to Wishlist">
                                            <i class="icon-btn-product icon-wishlist icon-Icon_Wishlist"></i>
                                            <span class="icon-title">Add to Wishlist</span>
                                        </a>
                                    </div>



                                    <div class="product-quickview hidden-sm-down">
                                        <a class="rb-quick-view rb-btn-product" href="#" data-link-action="quickview">
                                            <i class="icon-Icon_Quick-view"></i>
                                            <span class="icon-title">Quick view</span>
                                        </a>
                                    </div>

                                    <div class="product-quick-view" style="display:none;">
                                        <a class="quick-view rb-btn-product" href="#" data-link-action="quickview">
                                            <i class="icon-Icon_Quick-view search"></i>
                                            <span class="icon-title">Quick view</span>
                                        </a>
                                    </div>


                                </div>




                            </div>


                            <div class="product-meta">
                                <div class="meta-top">

                                    <h3 class="h3 product-brand" itemprop="brand">
                                        <span>Brand: </span>
                                        <a href="https://rubiktheme.com/demo/rb_evo_demo/en/brand/1-studio-design"
                                            tabindex="0">Studio Design</a>
                                    </h3>



                                    <div class="star_content clearfix" itemprop="reviewRating" itemscope
                                        itemtype="https://schema.org/Rating">
                                        <div class="star"></div>
                                        <div class="star"></div>
                                        <div class="star"></div>
                                        <div class="star"></div>
                                        <div class="star"></div>
                                        <meta itemprop="worstRating" content="0" />
                                        <meta itemprop="ratingValue" content="0" />
                                        <meta itemprop="bestRating" content="5" />
                                    </div>






                                </div>


                                <h2 class="h3 product-title" itemprop="name"><a
                                        href="https://rubiktheme.com/demo/rb_evo_demo/en/leather-goods/11-26-hummingbird-cushion.html#/8-color-white"
                                        itemprop="url"
                                        content="https://rubiktheme.com/demo/rb_evo_demo/en/leather-goods/11-26-hummingbird-cushion.html#/8-color-white">Minimal
                                        Square Tote</a></h2>



                                <div class="product-price-and-shipping">



                                    <span class="price" aria-label="Price">$18.90</span>
                                    <div itemprop="offers" itemscope itemtype="http://schema.org/Offer"
                                        class="invisible">
                                        <meta itemprop="priceCurrency" content="USD" />
                                        <meta itemprop="price" content="18.9" />
                                    </div>




                                </div>

                            </div>



                        </div>
                    </article>
                </div>

            </div>
        </section>
        <!-- end /var/www/html/demo/rb_evo_demo/themes/rb_evo/modules/ps_categoryproducts/views/templates/hook/ps_categoryproducts.tpl -->
        <!-- begin /var/www/html/demo/rb_evo_demo/themes/rb_evo/modules/ps_viewedproduct/views/templates/hook/ps_viewedproduct.tpl -->
        <section class="featured-products clearfix mt-3">
            <h2 class="products-section-title">
                Viewed products
            </h2>
            <div class="products featured-products-slick">

                <div itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    <article class="product-miniature js-product-miniature " data-id-product="9"
                        data-id-product-attribute="22" itemscope itemtype="http://schema.org/Product">
                        <div class="thumbnail-container">
                            <div class="product-image">

                                <a href="https://rubiktheme.com/demo/rb_evo_demo/en/accessories/9-22-mountain-fox-cushion.html#/8-color-white"
                                    class="thumbnail product-thumbnail">
                                    <img class="img-fluid rb-image image-cover"
                                        data-lazy="https://rubiktheme.com/demo/rb_evo_demo/136-home_default/mountain-fox-cushion.jpg"
                                        data-full-size-image-url="https://rubiktheme.com/demo/rb_evo_demo/136-large_default/mountain-fox-cushion.jpg">


                                    <div class="product-hover">
                                        <img class="img-fluid rb-image image-hover"
                                            data-lazy="https://rubiktheme.com/demo/rb_evo_demo/137-home_default/mountain-fox-cushion.jpg"
                                            title="Ottoto Arezzo" width="600" height="686">
                                    </div>


                                    <div class="rb-image-loading"></div>
                                </a>



                                <ul class="product-flags">
                                    <span class="sr-only">Price</span>

                                </ul>


                                <div class="rb-ajax-loading">
                                    <div class="cssload-container">
                                        <div class="cssload-speeding-wheel"></div>
                                    </div>
                                </div>
                                <div class="functional-buttons clearfix">

                                    <div class="product-add-cart">
                                        <form action="https://rubiktheme.com/demo/rb_evo_demo/en/cart" method="post"
                                            class="add-to-cart-or-refresh">
                                            <input type="hidden" name="token" value="9e645ea2b011b9302f90d49f848c7122">
                                            <input type="hidden" name="id_product" value="9"
                                                class="product_page_product_id">

                                            <!-- begin /var/www/html/demo/rb_evo_demo/themes/rb_evo/modules/rbthemefunction/views/templates/hook/rb-cart.tpl -->
                                            <div class="product-add-to-cart-rb">

                                                <div class="product-quantity">
                                                    <div class="add">
                                                        <button class="btn rb-btn-product add-to-cart"
                                                            title="Add to cart" data-button-action="add-to-cart"
                                                            type="submit">
                                                            <i class="icon-Ico_Cart"></i>
                                                            <span class="icon-title">Add To
                                                                Cart</span>
                                                        </button>


                                                        <span class="product-availability hidden">
                                                        </span>

                                                    </div>
                                                </div>



                                                <p class="product-minimal-quantity hidden">
                                                </p>

                                            </div>
                                            <!-- end /var/www/html/demo/rb_evo_demo/themes/rb_evo/modules/rbthemefunction/views/templates/hook/rb-cart.tpl -->
                                        </form>
                                    </div>


                                    <div class="rb-wishlist">
                                        <a class="rb-wishlist-link rb-btn-product " href="#" data-id-wishlist=""
                                            data-id-product="9" data-id-product-attribute="22"
                                            data-id_wishlist_product="0" title="Add to Wishlist">
                                            <i class="icon-btn-product icon-wishlist icon-Icon_Wishlist"></i>
                                            <span class="icon-title">Add to Wishlist</span>
                                        </a>
                                    </div>



                                    <div class="product-quickview hidden-sm-down">
                                        <a class="rb-quick-view rb-btn-product" href="#" data-link-action="quickview">
                                            <i class="icon-Icon_Quick-view"></i>
                                            <span class="icon-title">Quick view</span>
                                        </a>
                                    </div>

                                    <div class="product-quick-view" style="display:none;">
                                        <a class="quick-view rb-btn-product" href="#" data-link-action="quickview">
                                            <i class="icon-Icon_Quick-view search"></i>
                                            <span class="icon-title">Quick view</span>
                                        </a>
                                    </div>


                                </div>




                            </div>


                            <div class="product-meta">
                                <div class="meta-top">

                                    <h3 class="h3 product-brand" itemprop="brand">
                                        <span>Brand: </span>
                                        <a href="https://rubiktheme.com/demo/rb_evo_demo/en/brand/1-studio-design"
                                            tabindex="0">Studio Design</a>
                                    </h3>



                                    <div class="star_content clearfix" itemprop="reviewRating" itemscope
                                        itemtype="https://schema.org/Rating">
                                        <div class="star"></div>
                                        <div class="star"></div>
                                        <div class="star"></div>
                                        <div class="star"></div>
                                        <div class="star"></div>
                                        <meta itemprop="worstRating" content="0" />
                                        <meta itemprop="ratingValue" content="0" />
                                        <meta itemprop="bestRating" content="5" />
                                    </div>






                                </div>


                                <h2 class="h3 product-title" itemprop="name"><a
                                        href="https://rubiktheme.com/demo/rb_evo_demo/en/accessories/9-22-mountain-fox-cushion.html#/8-color-white"
                                        itemprop="url"
                                        content="https://rubiktheme.com/demo/rb_evo_demo/en/accessories/9-22-mountain-fox-cushion.html#/8-color-white">Ottoto
                                        Arezzo</a></h2>



                                <div class="product-price-and-shipping">



                                    <span class="price" aria-label="Price">$18.90</span>
                                    <div itemprop="offers" itemscope itemtype="http://schema.org/Offer"
                                        class="invisible">
                                        <meta itemprop="priceCurrency" content="USD" />
                                        <meta itemprop="price" content="18.9" />
                                    </div>




                                </div>

                            </div>



                        </div>
                    </article>
                </div>

                <div itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    <article class="product-miniature js-product-miniature " data-id-product="1"
                        data-id-product-attribute="1" itemscope itemtype="http://schema.org/Product">
                        <div class="thumbnail-container">
                            <div class="product-image">

                                <a href="https://rubiktheme.com/demo/rb_evo_demo/en/polo-shirts/1-1-hummingbird-printed-t-shirt.html#/1-size-s/8-color-white"
                                    class="thumbnail product-thumbnail">
                                    <img class="img-fluid rb-image image-cover"
                                        data-lazy="https://rubiktheme.com/demo/rb_evo_demo/101-home_default/hummingbird-printed-t-shirt.jpg"
                                        data-full-size-image-url="https://rubiktheme.com/demo/rb_evo_demo/101-large_default/hummingbird-printed-t-shirt.jpg">


                                    <div class="product-hover">
                                        <img class="img-fluid rb-image image-hover"
                                            data-lazy="https://rubiktheme.com/demo/rb_evo_demo/100-home_default/hummingbird-printed-t-shirt.jpg"
                                            title="Harman Blue Sneakers" width="600" height="686">
                                    </div>


                                    <div class="rb-image-loading"></div>
                                </a>



                                <ul class="product-flags">
                                    <li class="product-flag discount">-20%</li>
                                    <span class="sr-only">Price</span>

                                </ul>


                                <div class="rb-ajax-loading">
                                    <div class="cssload-container">
                                        <div class="cssload-speeding-wheel"></div>
                                    </div>
                                </div>
                                <div class="functional-buttons clearfix">

                                    <div class="product-add-cart">
                                        <form action="https://rubiktheme.com/demo/rb_evo_demo/en/cart" method="post"
                                            class="add-to-cart-or-refresh">
                                            <input type="hidden" name="token" value="9e645ea2b011b9302f90d49f848c7122">
                                            <input type="hidden" name="id_product" value="1"
                                                class="product_page_product_id">

                                            <!-- begin /var/www/html/demo/rb_evo_demo/themes/rb_evo/modules/rbthemefunction/views/templates/hook/rb-cart.tpl -->
                                            <div class="product-add-to-cart-rb">

                                                <div class="product-quantity">
                                                    <div class="add">
                                                        <button class="btn rb-btn-product add-to-cart"
                                                            title="Add to cart" data-button-action="add-to-cart"
                                                            type="submit">
                                                            <i class="icon-Ico_Cart"></i>
                                                            <span class="icon-title">Add To
                                                                Cart</span>
                                                        </button>


                                                        <span class="product-availability hidden">
                                                        </span>

                                                    </div>
                                                </div>



                                                <p class="product-minimal-quantity hidden">
                                                </p>

                                            </div>
                                            <!-- end /var/www/html/demo/rb_evo_demo/themes/rb_evo/modules/rbthemefunction/views/templates/hook/rb-cart.tpl -->
                                        </form>
                                    </div>


                                    <div class="rb-wishlist">
                                        <a class="rb-wishlist-link rb-btn-product " href="#" data-id-wishlist=""
                                            data-id-product="1" data-id-product-attribute="1"
                                            data-id_wishlist_product="0" title="Add to Wishlist">
                                            <i class="icon-btn-product icon-wishlist icon-Icon_Wishlist"></i>
                                            <span class="icon-title">Add to Wishlist</span>
                                        </a>
                                    </div>



                                    <div class="product-quickview hidden-sm-down">
                                        <a class="rb-quick-view rb-btn-product" href="#" data-link-action="quickview">
                                            <i class="icon-Icon_Quick-view"></i>
                                            <span class="icon-title">Quick view</span>
                                        </a>
                                    </div>

                                    <div class="product-quick-view" style="display:none;">
                                        <a class="quick-view rb-btn-product" href="#" data-link-action="quickview">
                                            <i class="icon-Icon_Quick-view search"></i>
                                            <span class="icon-title">Quick view</span>
                                        </a>
                                    </div>


                                </div>




                            </div>


                            <div class="product-meta">
                                <div class="meta-top">

                                    <h3 class="h3 product-brand" itemprop="brand">
                                        <span>Brand: </span>
                                        <a href="https://rubiktheme.com/demo/rb_evo_demo/en/brand/1-studio-design"
                                            tabindex="0">Studio Design</a>
                                    </h3>



                                    <div class="star_content clearfix" itemprop="reviewRating" itemscope
                                        itemtype="https://schema.org/Rating">
                                        <div class="star star_on"></div>
                                        <div class="star star_on"></div>
                                        <div class="star star_on"></div>
                                        <div class="star star_on"></div>
                                        <div class="star star_on"></div>
                                        <meta itemprop="worstRating" content="0" />
                                        <meta itemprop="ratingValue" content="5" />
                                        <meta itemprop="bestRating" content="5" />
                                    </div>






                                </div>


                                <h2 class="h3 product-title" itemprop="name"><a
                                        href="https://rubiktheme.com/demo/rb_evo_demo/en/polo-shirts/1-1-hummingbird-printed-t-shirt.html#/1-size-s/8-color-white"
                                        itemprop="url"
                                        content="https://rubiktheme.com/demo/rb_evo_demo/en/polo-shirts/1-1-hummingbird-printed-t-shirt.html#/1-size-s/8-color-white">Harman
                                        Blue Sneakers</a></h2>



                                <div class="product-price-and-shipping">


                                    <span class="regular-price" aria-label="Regular price">$23.90</span>
                                    <span class="discount-percentage discount-product">-20%</span>



                                    <span class="price" aria-label="Price">$19.12</span>
                                    <div itemprop="offers" itemscope itemtype="http://schema.org/Offer"
                                        class="invisible">
                                        <meta itemprop="priceCurrency" content="USD" />
                                        <meta itemprop="price" content="19.12" />
                                    </div>




                                </div>

                            </div>



                        </div>
                    </article>
                </div>
            </div>
        </section>
        <!-- end /var/www/html/demo/rb_evo_demo/themes/rb_evo/modules/ps_viewedproduct/views/templates/hook/ps_viewedproduct.tpl -->



        <div class="modal fade js-product-images-modal" id="product-modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <figure>
                            <img class="js-modal-product-cover product-cover-modal" width="840"
                                src="https://rubiktheme.com/demo/rb_evo_demo/110-large_default/the-best-is-yet-to-come-framed-poster.jpg"
                                alt="" title="" itemprop="image">
                            <figcaption class="image-caption">

                                <div id="product-description-short" itemprop="description">
                                    <p>Donec fringilla sapien sed elit luctus, eget mattis dolor
                                        efficitur. Ut id libero nulla. Morbi aliquam tortor massa,
                                        in aliquet eros molestie in. Quisque eleifend diam leo, a
                                        bibendum mi eleifend eget.</p>
                                </div>

                            </figcaption>
                        </figure>
                        <aside id="thumbnails" class="thumbnails js-thumbnails text-sm-center">

                            <div class="js-modal-mask mask  nomargin ">
                                <ul class="product-images js-modal-product-images">
                                    <li class="thumb-container">
                                        <img data-image-large-src="https://rubiktheme.com/demo/rb_evo_demo/110-large_default/the-best-is-yet-to-come-framed-poster.jpg"
                                            class="thumb js-modal-thumb"
                                            src="https://rubiktheme.com/demo/rb_evo_demo/110-home_default/the-best-is-yet-to-come-framed-poster.jpg"
                                            alt="" title="" width="600" itemprop="image">
                                    </li>
                                    <li class="thumb-container">
                                        <img data-image-large-src="https://rubiktheme.com/demo/rb_evo_demo/111-large_default/the-best-is-yet-to-come-framed-poster.jpg"
                                            class="thumb js-modal-thumb"
                                            src="https://rubiktheme.com/demo/rb_evo_demo/111-home_default/the-best-is-yet-to-come-framed-poster.jpg"
                                            alt="" title="" width="600" itemprop="image">
                                    </li>
                                    <li class="thumb-container">
                                        <img data-image-large-src="https://rubiktheme.com/demo/rb_evo_demo/112-large_default/the-best-is-yet-to-come-framed-poster.jpg"
                                            class="thumb js-modal-thumb"
                                            src="https://rubiktheme.com/demo/rb_evo_demo/112-home_default/the-best-is-yet-to-come-framed-poster.jpg"
                                            alt="" title="" width="600" itemprop="image">
                                    </li>
                                    <li class="thumb-container">
                                        <img data-image-large-src="https://rubiktheme.com/demo/rb_evo_demo/113-large_default/the-best-is-yet-to-come-framed-poster.jpg"
                                            class="thumb js-modal-thumb"
                                            src="https://rubiktheme.com/demo/rb_evo_demo/113-home_default/the-best-is-yet-to-come-framed-poster.jpg"
                                            alt="" title="" width="600" itemprop="image">
                                    </li>
                                </ul>
                            </div>

                        </aside>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->



        <footer class="page-footer">



        </footer>

        <div class="page-loading-overlay main-product-details-loading"></div>
</section>



</div>



</div>

</div>

</section>

<footer id="footer">

    <div class="footer-container footer-v1">

        <div id="rb-product-cart" class="rb-hidden hidden-md-down">
            <form action="" method='post' id="add-to-cart-all-items">
                <input type="hidden" name='prod_id' value="<?= $ProductDetails['id'] ?>">
                <input type="hidden" name='user_id' value="<?= $user['id'] ?>">
                <input type="hidden" name='prod_price' value="<?= $ProductDetails['product_price'] ?>">
                <div class="container">
                    <div class="rb-product-thumb">
                        <div class="product-cover-img">
                            <?php
                            $ProductImageById = ProductImageById($ProductDetails['id'],"limit 1");
                            array_unshift($ProductImageById,"");
                            unset($ProductImageById[0]);

                        ?>
                            <img class="js-qv-product-cover img img-thumb"
                                src="<?= FRONT_SITE_IMAGE_PRODUCT.$ProductImageById[1]['product_img'] ?>" alt=""
                                title="" itemprop="image">
                        </div>

                        <div class="rb-description-sticky">

                            <h1 class="h1 product-detail-name" itemprop="name">
                                <?= $ProductDetails['product_name'] ?>
                            </h1>



                            <div class="product-prices">
                                <div class="product-price h5 " itemprop="offers" itemscope="">
                                    <link itemprop="availability" href="https://schema.org/InStock">
                                    <meta itemprop="priceCurrency" content="INR">

                                    <div class="current-price">
                                        <span itemprop="price" content="<?= $ProductDetails['product_price'] ?>">₹
                                            <?= $ProductDetails['product_price'] ?></span>

                                    </div>



                                </div>

                                <div class="tax-shipping-delivery-label">

                                </div>


                                <div id="product-availability">
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="product-actions">

                        <div class="product-variants">
                            <div class="clearfix product-variants-item">
                                <span class="control-label">Size</span>
                                <ul id="group_3">
                                    <?php
                                     $ProductSizes = $ProductDetails['product_size'];
                                     
                                     $sizeExtract = explode(',', $ProductSizes);
                                     if (empty($ProductSizes)) {
                                         
                                     }else{
                                        foreach ($sizeExtract as $key => $value) {
                                            if ($key == 0) {
                                                $checked = "checked='checked'";
                                            }else {
                                                $checked = '';
                                            }
                                            ?>
                                    <li class="input-container float-xs-left instock">
                                        <label>
                                            <input class="input-radio" type="radio" data-product-attribute="4"
                                                name="check_size" value="<?= $value ?>" title="<?= $value ?>" required
                                                <?= $checked.' '.$disabled ?>>
                                            <span class="radio-label"><?= $value ?></span>
                                        </label>
                                    </li>
                                    <?php
                                        }
                                    }
                                ?>
                                </ul>
                            </div>
                        </div>



                        <div class="rb-product-add-to-cart">
                            <span class="control-label">Quantity</span>

                            <div class="rb-product-quantity clearfix">
                                <div class="qty">
                                    <div class="input-group bootstrap-touchspin">
                                        <input type="number" name="qty" id="quantity_wanted" value="1"
                                            class="input-group form-control" min="1" aria-label="Quantity"
                                            <?= $disabled ?>>

                                        <span class="input-group-btn-vertical">
                                            <button class="btn btn-touchspin js-touchspin bootstrap-touchspin-up"
                                                type="button">
                                                <i class="material-icons touchspin-up"></i>
                                            </button>
                                            <button class="btn btn-touchspin js-touchspin bootstrap-touchspin-down"
                                                type="button">
                                                <i class="material-icons touchspin-down"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>

                                <div class="add">
                                    <?php
                                         if(RemainingStock($ProductDetails['id']) != '<span style="color:red">Out of Stock</span>')   {
                                              ?>
                                    <button type='submit' class="btn btn-primary add-to-cart">
                                        <i class="material-icons shopping-cart"></i>
                                        Add to cart
                                    </button>
                                </div>
                            </div>
                        </div>



                        <section class="product-discounts">
                        </section>

                    </div>
                </div>
            </form>
            <?php
                                         }else{
                                             ?>

            <button class="btn btn-danger ">
                <i class="material-icons shopping-cart"></i>
                Notify Me
            </button>
            <?php
                                         }
                                    ?>

        </div>
    </div>

</footer>

</main>

<?php
    require 'includes/footer.php';
?>