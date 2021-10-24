<?php
    require 'includes/header.php';
    if (isset($_GET['viewList']) && $_GET['viewList'] != '') {
        $wishlist_id_get = get_safe_value($_GET['viewList']);

        $CHECKIDEXIST_SQL = mysqli_query($con , "SELECT * FROM wishlist WHERE id = '$wishlist_id_get'");

        if (mysqli_num_rows($CHECKIDEXIST_SQL) > 0) {
            $row = mysqli_fetch_assoc($CHECKIDEXIST_SQL);
        }else {
            redirect(FRONT_SITE_PATH);
        }

        // Getting Other Wishlst LIst for this Usser Created By this except this one which was viewing
        $EXCEPTONESQL = mysqli_query($con, "SELECT * FROM `wishlist` WHERE user_id = '".$user['id']."' && wishlist_name != '".$row['wishlist_name']."'");

        if (mysqli_num_rows($EXCEPTONESQL) >= 1) {
            $data = array();
            while ($rows = mysqli_fetch_assoc($EXCEPTONESQL)) {
                $data[] = $rows;
            }
            

            $otherlist = '';

            foreach($data as $key => $val) {
                $otherlist .= '<a href="'.FRONT_SITE_PATH.'wishlist?viewList='.$val['id'].'"
                title="shadab" rel="nofollow">
                '.$val['wishlist_name'].'</a> /';
            }
            
            $otherlist =  substr($otherlist,0,-1);
        }else {
            $rows = mysqli_fetch_assoc($EXCEPTONESQL);
            $otherlist = $rows['wishlist_name'];
            $otherlist = '<a href="'.FRONT_SITE_PATH.'wishlist?viewList='.$rows['id'].'"
            title="shadab" rel="nofollow">
            '.$rows['wishlist_name'].'</a>';
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
                    <span><?= SITE_NAME ?></span>
                </li>

            </ol>
        </div>
    </nav>


    <div class="container">
        <div class="row">
            <div id="content-wrapper" class="col-lg-12 col-xs-12">
                <section id="main">
                    <div id="rb-view-wishlist">
                        <h2>Wishlist "<?= $row['wishlist_name'] ?>"</h2>
                        <p>
                            Other wishlists of <?= $user['firstname'].' '.$user['lastname'] ?> :
                            <?= $otherlist ?>

                        </p>

                        <section id="products">
                            <div class="rb-wishlist-product products row">
                                <?php
                                    $products_ids = explode(",", $row['wishlist_prod_id']);
                                    
                                    if(empty($products_ids['0'])){
                                        ?>
                                           <div class="alert alert-warning col-xl-12">No products</div> 

                                        <?php
                                    }else{
                                        foreach($products_ids as $key => $val) {
                                            $ProductDetails =  ProductDetails('where id = '.$val.'');
                                            $ProductDetails = $ProductDetails[0];

                                            $ProductImageById = ProductImageById($ProductDetails['id'], 'limit 2');
                                            array_unshift($ProductImageById,"");
                                            unset($ProductImageById[0]);

                                            $ProductSizes = $ProductDetails['product_size'];
                                            $sizes = explode(",", $ProductSizes);
                                            ?>
                                                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-xs-12 product-miniature js-product-miniature rb-wishlistproduct-item rb-wishlistproduct-item-6 product-4"
                                                    data-id-product="4" data-id-product-attribute="16" itemscope=""
                                                    itemtype="http://schema.org/Product">
                                                    <div class="thumbnail-container clearfix">
                                                        <div class="product-image">

                                                            <a href="<?= FRONT_SITE_PATH.'product-details?productname='.urlencode($ProductDetails['product_name']) ?>"
                                                                target="_blank" class="thumbnail product-thumbnail">
                                                                <img class="img-fluid"
                                                                    src="<?= FRONT_SITE_IMAGE_PRODUCT.$ProductImageById[1]['product_img'] ?>"
                                                                    alt="<?= $ProductDetails['product_name'] ?>"
                                                                    data-full-size-image-url="<?= FRONT_SITE_IMAGE_PRODUCT.$ProductImageById[1]['product_img'] ?>">
                                                            </a>



                                                            <ul class="product-flags">
                                                            </ul>

                                                            <div class="product-price-and-shipping">
                                                                <span itemprop="price" class="price"><?= $ProductDetails['product_price'] ?></span>

                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="product-description">
                                                            <!-- begin /var/www/html/demo/rb_evo_demo/themes/rb_evo/modules/rbthemefunction/views/templates/hook/rb-cart.tpl -->
                                                            <div class="product-add-to-cart-rb">
                                                                <div class="product-quantity">
                                                                    <div class="add">
                                                                        <button class="btn rb-btn-product add-to-cart"
                                                                            title="Add to cart" data-button-action="add-to-cart"
                                                                            onclick="addtoCart('<?= $ProductDetails['id'] ?>', '<?= $user['id'] ?>', '1',  '<?= $ProductDetails['product_price'] ?>', '<?= $sizes['0'] ?>')"
                                                                            type="submit">
                                                                            <i class="icon-Ico_Cart"></i>
                                                                            <span class="icon-title">Add To Cart</span>
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

                                                        <h1 class="h3 product-title" itemprop="name">
                                                            <a href="<?= FRONT_SITE_PATH.'product-details?productname='.urlencode($ProductDetails['product_name']) ?>"
                                                                target="_blank"><?= $ProductDetails['product_name'] ?></a>
                                                        </h1>

                                                    </div>
                                                </div>
                                        <?php
                                        }
                                    }    
                                    ?>

                            </div>
                        </section>
                    </div>
                </section>


            </div>



        </div>

    </div>

</section>
<?php
    }else{
        ?>
<section id="wrapper">

    <nav data-depth="1" class="breadcrumb">
        <div class="container">
            <ol itemscope itemtype="http://schema.org/BreadcrumbList" class="p-a-0">

                <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    <a itemprop="item" href="<?= FRONT_SITE_PATH ?>">
                        <span itemprop="name">Home</span>
                    </a>
                    <meta itemprop="position" content="1">
                </li>

                <li>
                    <span><?= SITE_NAME ?></span>
                </li>

            </ol>
        </div>
    </nav>


    <div class="container">
        <div class="row">
            <div id="content-wrapper" class="col-lg-12 col-xs-12">
                <section id="main">
                    <section id="content" class="page-content card card-block">
                        <section id="main">
                            <div id="rb-wishlist">
                                <h2>New Wishlist</h2>

                                <div class="rb-new-wishlist">
                                    <form class="rb-add-new-wishlist" method="POST" action="" id="new_wishlist">
                                        <div class="form-group">
                                            <label for="rb_wishlist_name">Name</label>
                                            <input type="text" name="wishlist_name_new" required="" class="form-control"
                                                placeholder="Enter name of new wishlist">
                                        </div>
                                        <div class="form-group has-success">
                                            <div class="form-control-feedback" id="success_wishlist"></div>
                                        </div>
                                        <div class="form-group has-danger">
                                            <div class="form-control-feedback" id="error_wishlist"></div>
                                        </div>
                                        <button type="submit" class="btn btn-primary rb-save-wishlist"
                                            name="ps_add_wishlist">
                                            <span class="rb-save-wishlist-name">
                                                Save
                                            </span>
                                        </button>
                                    </form>
                                </div>

                                <!-- All the Wishlist data  -->
                                <div class="show_all_wishlist">

                                </div>

                                <div class="send-wishlist">
                                    <!-- begin /var/www/html/demo/rb_evo_demo/modules/rbthemefunction/views/templates/rb-ajax-loading.tpl -->
                                    <div class="cssload-container rb-ajax-loading">
                                        <div class="cssload-double-torus"></div>
                                    </div>
                                    <!-- end /var/www/html/demo/rb_evo_demo/modules/rbthemefunction/views/templates/rb-ajax-loading.tpl -->
                                    <form class="form-send-wishlist" action="#" method="POST">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input class="form-control" required="" type="email" name="email"
                                                    id="email_3" value="" size="40" placeholder="Email address">

                                                <span class="input-group-btn">
                                                    <i class="material-icons">email</i>
                                                </span>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary rb-send-wishlist">
                                            <i class="material-icons">&#xE163;</i>
                                            Send My Wishlist
                                        </button>
                                    </form>
                                </div>
                                <section id="products">
                                    <div class="rb-wishlist-product products row">

                                    </div>
                                </section>

                                <ul class="footer_links">
                                    <li class="pull-xs-left">
                                        <a class="btn btn-outline" href="<?= FRONT_SITE_PATH."identity" ?>">
                                            <i class="material-icons">&#xE317;</i>
                                            Back to Your Account
                                        </a>
                                    </li>

                                    <li class="pull-xs-right">
                                        <a class="btn btn-outline" href="<?= FRONT_SITE_PATH ?>">
                                            <i class="material-icons">&#xE88A;</i>
                                            Home
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </section>

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
    }
?>



<?php
            require 'includes/footer.php';
      ?>