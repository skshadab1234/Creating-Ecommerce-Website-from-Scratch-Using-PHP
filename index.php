<?php
    require 'includes/header.php';
    // prx($user);
    $date = date('Y-m-d');
    $ProductDetails =  ProductDetails('where product_added_on = "'.$date.'"');
    
?>

<div class="">
    <div class="row">
        <div id="content-wrapper" class="col-lg-12 col-xs-12">  
            <section id="main">
                <section id="content" class="page-content card card-block">
                    <div id="rb" class="rb">
                        <div id="rb" class="rb">
                            <div id="rb-inner">
                                <div id="rb-section-wrap">
                                    
                                    <div class="column-5 rb-section rb-element rb-element-qd5ri7o rb-top-section rb-section-boxed rb-section-height-default rb-section-height-default"
                                        data-element_type="section">
                                        <div class="container container-large rb-container rb-column-gap-default">
                                            <div class="row">
                                                <div class="rb-column rb-element rb-element-s8wjbj1 col-md-12 rb-top-column"
                                                    data-element_type="column">
                                                    <div class="rb-column-wraprb-element-populated">
                                                        <div class="rb-widget-wrap">
                                                            <div class="rb-widget rb-element rb-element-n1go0g5 rb-widget-prestashop-widget-ProductsList"
                                                                data-element_type="prestashop-widget-ProductsList">
                                                                <div class="rb-widget-container">
                                                                    <section id="products"
                                                                        class="rb-products rb-products-list ">
                                                                        <h4 class="title_block">New Arrivals</h4>

                                                                        <p class="sub_title_block">Find a
                                                                            bright ideal to suit your taste
                                                                            with our great selection of
                                                                            suspension.</p>

                                                                        <div class="products row products-list">

                                                                            <div class="rb-animation">

                                                                                <div class="product-style4">
                                                                                    <?php
                                                                                        foreach($ProductDetails as $productdata){
                                                                                            $ProductImageById = ProductImageById($productdata['id'], 'limit 2');
                                                                                            array_unshift($ProductImageById,"");
                                                                                            unset($ProductImageById[0]);
                                                                                            ?>
                                                                                    <article
                                                                                        class="product-miniature js-product-miniature col-xl-2-4 col-lg-3 col-md-4 col-sm-6 col-xs-6 col-sp-12"
                                                                                        data-id-product="1"
                                                                                        data-id-product-attribute="1"
                                                                                        itemscope
                                                                                        itemtype="http://schema.org/Product">
                                                                                        <div
                                                                                            class="thumbnail-container">
                                                                                            <div class="product-image">

                                                                                                <a href="<?= FRONT_SITE_PATH.'product-details?productname='.urlencode($productdata['product_name']) ?>"
                                                                                                    class="thumbnail product-thumbnail">

                                                                                                    <img class="img-fluid rb-cover"
                                                                                                        src="<?= FRONT_SITE_IMAGE_PRODUCT.$ProductImageById[1]['product_img'] ?>"
                                                                                                        alt="<?= $productdata['product_name'] ?>"
                                                                                                        data-full-size-image-url="<?= FRONT_SITE_IMAGE_PRODUCT.$ProductImageById[1]['product_img'] ?>">
                                                                                                    <div
                                                                                                        class="product-hover">
                                                                                                        <img class="img-fluid rb-image image-hover"
                                                                                                            src="<?= FRONT_SITE_IMAGE_PRODUCT.$ProductImageById[2]['product_img'] ?>"
                                                                                                            title="<?= $productdata['product_name'] ?>"
                                                                                                            width="600"
                                                                                                            height="686">
                                                                                                    </div>
                                                                                                </a>

                                                                                                <ul
                                                                                                    class="product-flags">
                                                                                                    <li
                                                                                                        class="product-flag discount">
                                                                                                        -20%
                                                                                                    </li>
                                                                                                </ul>


                                                                                                <div
                                                                                                    class="rb-ajax-loading">
                                                                                                    <div
                                                                                                        class="cssload-container">
                                                                                                        <div
                                                                                                            class="cssload-speeding-wheel">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>

                                                                                                <div
                                                                                                    class="rb-wishlist">
                                                                                                    <a class="rb-wishlist-link rb-btn-product "
                                                                                                        href="#"
                                                                                                        data-id-wishlist=""
                                                                                                        data-id-product="1"
                                                                                                        data-id-product-attribute="1"
                                                                                                        data-id_wishlist_product="0"
                                                                                                        title="Add to Wishlist">
                                                                                                        <i
                                                                                                            class="icon-btn-product icon-wishlist icon-Icon_Wishlist"></i>
                                                                                                        <span
                                                                                                            class="icon-title">Add
                                                                                                            to
                                                                                                            Wishlist</span>
                                                                                                    </a>
                                                                                                </div>



                                                                                            </div>


                                                                                            <div class="product-meta">
                                                                                                <h2 class="h3 product-title"
                                                                                                    itemprop="name">
                                                                                                    <a href="https://rubiktheme.com/demo/rb_evo_demo/en/polo-shirts/1-1-hummingbird-printed-t-shirt.html#/1-size-s/8-color-white"
                                                                                                        itemprop="url"
                                                                                                        content="https://rubiktheme.com/demo/rb_evo_demo/en/polo-shirts/1-1-hummingbird-printed-t-shirt.html#/1-size-s/8-color-white">
                                                                                                        <?= $productdata['product_name'] ?></a>
                                                                                                </h2>

                                                                                                <div
                                                                                                    class="product-price-and-shipping">
                                                                                                    <span
                                                                                                        class="regular-price"
                                                                                                        aria-label="Regular price">₹ <?= $productdata['product_oldPrice'] ?></span>

                                                                                                    <span class="price"
                                                                                                        aria-label="Price">₹ <?= $productdata['product_price'] ?></span>
                                                                                                    <div itemprop="offers"
                                                                                                        itemscope
                                                                                                        itemtype="http://schema.org/Offer"
                                                                                                        class="invisible">
                                                                                                        <meta
                                                                                                            itemprop="priceCurrency"
                                                                                                            content="USD" />
                                                                                                        <meta
                                                                                                            itemprop="price"
                                                                                                            content="19.12" />
                                                                                                    </div>




                                                                                                </div>

                                                                                            </div>

                                                                                        </div>
                                                                                    </article>

                                                                                    <?php
                                                                                        }        
                                                                                    ?>
                                                                                </div>

                                                                            </div>

                                                                        </div>


                                                                    </section>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

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