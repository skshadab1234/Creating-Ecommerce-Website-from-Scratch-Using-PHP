<!-- Home/address/cart/identity/o-confirm/o-history id="module-rbthemedream-live" -->
<!-- Product id="product" -->
<!-- Chckout id="checkout" -->

<?php

require 'session.php';

$getCartTotal = getCartTotal();

$page_url =  'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

$body_name = 'product';

$visibility_ele = 'displat:block';
$bs4_css_link = '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">';

if ($page_url == FRONT_SITE_PATH || $page_url == FRONT_SITE_PATH.'index.php') {
    $title = 'PS Fashon Store';
    $body_name = 'index';
}elseif ($page_url == FRONT_SITE_PATH.'identity.php') {
    if (isset($_SESSION['UID'])) {
        $title = $user['firstname'].' '.$user['lastname'].' - Profile';
    }else{
        redirect(FRONT_SITE_PATH);
    }
}elseif ($page_url == FRONT_SITE_PATH.'product-details.php') {
    $title = get_safe_value($_GET['productname']);
    $bs4_css_link = '';
}elseif ($page_url == FRONT_SITE_PATH.'cart.php') {
    if (isset($_SESSION['UID'])) {
        $title = $user['firstname'].' '.$user['lastname'].' - Profile';
    }else{
        $title = 'Not Login';
    }
}elseif ($page_url == FRONT_SITE_PATH.'checkout.php') {
    $body_name = 'checkout';
    if (isset($_SESSION['UID'])) {
        $title = $user['firstname'].' '.$user['lastname'].' - Checkout';
    }else{
        redirect(FRONT_SITE_PATH.'cart');
    }
}elseif ($page_url == FRONT_SITE_PATH.'addresses.php') {
    $title = $user['firstname'].' '.$user['lastname'].' - Addresses';
    $body_name = 'addresses';
}elseif ($page_url == FRONT_SITE_PATH.'order-confirmation.php') {
    if (isset($_SESSION['UID'])) {
        $title = $user['firstname'].' '.$user['lastname'].' - Order Confirmation';
    }else{
        redirect(FRONT_SITE_PATH);
    }
}elseif ($page_url == FRONT_SITE_PATH.'order-history.php') {
    if (isset($_SESSION['UID'])) {
        if(isset($_GET['orderDetails'])){
            $title = 'Order Details - '.$_GET['orderDetails'];  
        }else{
            $title = $user['firstname'].' '.$user['lastname'].' - Order Hstory';
        }
    }else{
        redirect(FRONT_SITE_PATH);
    }
    
}elseif ($page_url == FRONT_SITE_PATH.'wishlist.php') {
    if (isset($_SESSION['UID'])) {
        $title = $user['firstname'].' '.$user['lastname'].' - Wishlist';
    }else{
        redirect(FRONT_SITE_PATH);
    }

}elseif ($page_url == FRONT_SITE_PATH.'password_recovery.php') {
    if (isset($_SESSION['UID'])) {
        redirect(FRONT_SITE_PATH);
    }else{
        $title = 'Recover Password';
    }
}elseif ($page_url == FRONT_SITE_PATH.'update_password.php') {
    if (isset($_SESSION['UID'])) {
        $title = $user['firstname'].' '.$user['lastname'].' - Update Password';
    }else{
        $title = 'Update Password';
    }
}
elseif ($page_url == FRONT_SITE_PATH.'product.php') {
    $title = 'Shop';
}
elseif ($page_url == FRONT_SITE_PATH.'trackmyorder.php') {
    if (isset($_SESSION['UID'])) {
        $title = $user['firstname'].' '.$user['lastname'].' - Track Order';
    }else{
        redirect(FRONT_SITE_PATH);
    }
}
elseif ($page_url == FRONT_SITE_PATH.'shoutnearn.php') {
    $visibility_ele = 'display:none';
    if (isset($_SESSION['UID'])) {
        $title = $user['firstname'].' '.$user['lastname'].' - Refer and Earn';
    }else{
        redirect(FRONT_SITE_PATH);
    }
}

elseif ($page_url == FRONT_SITE_PATH.'register.php') {
    $visibility_ele = 'display:none';
    if (isset($_SESSION['UID'])) {
        redirect(FRONT_SITE_PATH);
    }else{
        $title = 'Create a Account';
    }
}
elseif ($page_url == FRONT_SITE_PATH.'login.php') {
    $visibility_ele = 'display:none';
    if (isset($_SESSION['UID'])) {
        redirect(FRONT_SITE_PATH);
    }else{
        $title = 'Login';
    }
}
elseif ($page_url == FRONT_SITE_PATH.'wallet.php') {
    if (isset($_SESSION['UID'])) {
        $title = $user['firstname'].' '.$user['lastname'].' - Wallet';
    }else{
        redirect(FRONT_SITE_PATH);
    }
}

$base_url = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 'https' : 'http' ) . '://' .  $_SERVER['HTTP_HOST'];
$url = $base_url . $_SERVER["REQUEST_URI"];

?>

<!doctype html>
<html lang="en" id='ls-global'> 

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?= $title ?></title>
    <meta name="description"
        content="Lorem ipsum dolor sit amet consectetur adipisicing elit. Exercitationem, inventore eveniet dolores eaque beatae omnis ratione non nemo fugit ipsam dolorem.">

    <meta name="keywords" content="">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/vnd.microsoft.icon" href="<?= FRONT_SITE_PATH ?>logo.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?= FRONT_SITE_PATH ?>logo.png">
    
    <?= $bs4_css_link ?>

    <link rel="stylesheet" href="https://rubiktheme.com/demo/rb_evo_demo/themes/rb_evo/assets/cache/theme-8e39f839.css" type="text/css" media="all">

    <link rel="stylesheet" href="<?= FRONT_SITE_PATH ?>style/HomePage.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>


<script type="text/javascript">
    var active = "1";
    var cancel_rating_txt = "Cancel Rating";
    var collections = [
        "<a href='https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/women\/5-today-is-a-good-day-framed-poster.html' class='sale-popup-img'><img src='https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/118-home_default\/today-is-a-good-day-framed-poster.jpg' alt='Suede Trainers'\/><\/a><div class='sale-popup-content'><h3><a href='https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/women\/5-today-is-a-good-day-framed-poster.html' title='Suede Trainers'>Suede Trainers<\/a><\/h3><span class='sale-popup-timeago'><\/span><\/div><span class='button-close'><i class='material-icons'>close<\/i><\/span>",
        "<a href='https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/accessories\/9-mountain-fox-cushion.html' class='sale-popup-img'><img src='https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/136-home_default\/mountain-fox-cushion.jpg' alt='Ottoto Arezzo'\/><\/a><div class='sale-popup-content'><h3><a href='https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/accessories\/9-mountain-fox-cushion.html' title='Ottoto Arezzo'>Ottoto Arezzo<\/a><\/h3><span class='sale-popup-timeago'><\/span><\/div><span class='button-close'><i class='material-icons'>close<\/i><\/span>",
        "<a href='https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/clothing\/16-mountain-fox-notebook.html' class='sale-popup-img'><img src='https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/159-home_default\/mountain-fox-notebook.jpg' alt='Elegant Oxford Blazer'\/><\/a><div class='sale-popup-content'><h3><a href='https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/clothing\/16-mountain-fox-notebook.html' title='Elegant Oxford Blazer'>Elegant Oxford Blazer<\/a><\/h3><span class='sale-popup-timeago'><\/span><\/div><span class='button-close'><i class='material-icons'>close<\/i><\/span>",
        "<a href='https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/leather-goods\/14-hummingbird-vector-graphics.html' class='sale-popup-img'><img src='https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/152-home_default\/hummingbird-vector-graphics.jpg' alt='Tactical Crossbody Bag'\/><\/a><div class='sale-popup-content'><h3><a href='https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/leather-goods\/14-hummingbird-vector-graphics.html' title='Tactical Crossbody Bag'>Tactical Crossbody Bag<\/a><\/h3><span class='sale-popup-timeago'><\/span><\/div><span class='button-close'><i class='material-icons'>close<\/i><\/span>",
        "<a href='https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/clothing\/8-mug-today-is-a-good-day.html' class='sale-popup-img'><img src='https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/132-home_default\/mug-today-is-a-good-day.jpg' alt='Cream Square Shirt'\/><\/a><div class='sale-popup-content'><h3><a href='https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/clothing\/8-mug-today-is-a-good-day.html' title='Cream Square Shirt'>Cream Square Shirt<\/a><\/h3><span class='sale-popup-timeago'><\/span><\/div><span class='button-close'><i class='material-icons'>close<\/i><\/span>",
        "<a href='https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/leather-goods\/24-hummingbird-cushion.html' class='sale-popup-img'><img src='https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/213-home_default\/hummingbird-cushion.jpg' alt='Tactical Crossbody Bag'\/><\/a><div class='sale-popup-content'><h3><a href='https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/leather-goods\/24-hummingbird-cushion.html' title='Tactical Crossbody Bag'>Tactical Crossbody Bag<\/a><\/h3><span class='sale-popup-timeago'><\/span><\/div><span class='button-close'><i class='material-icons'>close<\/i><\/span>",
        "<a href='https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/clothing\/19-customizable-mug.html' class='sale-popup-img'><img src='https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/172-home_default\/customizable-mug.jpg' alt='Flared Skirts'\/><\/a><div class='sale-popup-content'><h3><a href='https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/clothing\/19-customizable-mug.html' title='Flared Skirts'>Flared Skirts<\/a><\/h3><span class='sale-popup-timeago'><\/span><\/div><span class='button-close'><i class='material-icons'>close<\/i><\/span>",
        "<a href='https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/shoes\/15-pack-mug-framed-poster.html' class='sale-popup-img'><img src='https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/155-home_default\/pack-mug-framed-poster.jpg' alt='Jones New York J751'\/><\/a><div class='sale-popup-content'><h3><a href='https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/shoes\/15-pack-mug-framed-poster.html' title='Jones New York J751'>Jones New York J751<\/a><\/h3><span class='sale-popup-timeago'><\/span><\/div><span class='button-close'><i class='material-icons'>close<\/i><\/span>",
        "<a href='https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/women\/4-the-adventure-begins-framed-poster.html' class='sale-popup-img'><img src='https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/114-home_default\/the-adventure-begins-framed-poster.jpg' alt='Cotton Patch Pocket Short'\/><\/a><div class='sale-popup-content'><h3><a href='https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/women\/4-the-adventure-begins-framed-poster.html' title='Cotton Patch Pocket Short'>Cotton Patch Pocket Short<\/a><\/h3><span class='sale-popup-timeago'><\/span><\/div><span class='button-close'><i class='material-icons'>close<\/i><\/span>",
        "<a href='https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/leather-goods\/11-hummingbird-cushion.html' class='sale-popup-img'><img src='https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/141-home_default\/hummingbird-cushion.jpg' alt='Minimal Square Tote'\/><\/a><div class='sale-popup-content'><h3><a href='https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/leather-goods\/11-hummingbird-cushion.html' title='Minimal Square Tote'>Minimal Square Tote<\/a><\/h3><span class='sale-popup-timeago'><\/span><\/div><span class='button-close'><i class='material-icons'>close<\/i><\/span>"
    ];
    var isLogged = true;
    var popup =
        "<!-- begin \/var\/www\/html\/demo\/rb_evo_demo\/modules\/rbthemefunction\/views\/templates\/rb-popup.tpl --><div\n\tclass=\"rb-popup-container\"\n\tstyle=\"width:770px;\n\theight:460px;\tbackground-image: url('\/demo\/rb_evo_demo\/modules\/rbthemefunction\/\/views\/img\/imgbg_1.jpg');\tbackground-position: center\"\n>\n\t<div class=\"rb-popup-flex\">\n\t\t<div id=\"rb_newsletter_popup\" class=\"rb-block\">\n\t\t\t<div class=\"rb-block-content\">\n\t\t\t\t<form action=\"\" method=\"POST\">\n\t\t\t\t\t<div class=\"rb-popup-text\">\n    \t\t\t\t\t<h2>Be the first to know<\/h2>\n<p>Subscribe for the latest news &amp; get 15% off your first order.<\/p>\n                    <\/div>\n\n                    \t                    <div class=\"rb-relative-input relative\">\n\t                    \t<input class=\"inputNew\" id=\"rb-newsletter-popup\" type=\"email\" name=\"email\" required=\"\" value=\"\" placeholder=\"your@email.com\" \/>\n\t                    \t<button class=\"rb-send-email\">\n\t                    \t\t<i class=\"material-icons\">trending_flat<\/i>\n\t                    \t<\/button>\n\t                    <\/div>\n\n\t                    <div class=\"rb-email-alert\">\n\t                    \t<!-- begin \/var\/www\/html\/demo\/rb_evo_demo\/modules\/rbthemefunction\/views\/templates\/rb-ajax-loading.tpl --><div class=\"cssload-container rb-ajax-loading\">\n\t<div class=\"cssload-double-torus\"><\/div>\n<\/div><!-- end \/var\/www\/html\/demo\/rb_evo_demo\/modules\/rbthemefunction\/views\/templates\/rb-ajax-loading.tpl -->\t                    \t<p class=\"rb-email rb-email-success alert alert-success\"><\/p>\n\t                    \t<p class=\"rb-email rb-email-error alert alert-danger\"><\/p>\n\t                    <\/div>\n                    \t\t\t\t<\/form>\n\t\t\t<\/div>\n\t\t<\/div>\n\t<\/div>\n<\/div><!-- end \/var\/www\/html\/demo\/rb_evo_demo\/modules\/rbthemefunction\/views\/templates\/rb-popup.tpl -->";
    var prestashop = {
        "cart": {
            "products": [{
                "add_to_cart_url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/cart?add=1&id_product=3&id_product_attribute=13&token=9e645ea2b011b9302f90d49f848c7122",
                "id": "3",
                "attributes": {
                    "Dimension": "40x60cm"
                },
                "show_price": true,
                "weight_unit": "kg",
                "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/women\/3-13-the-best-is-yet-to-come-framed-poster.html#\/19-dimension-40x60cm",
                "canonical_url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/women\/3-the-best-is-yet-to-come-framed-poster.html",
                "condition": false,
                "embedded_attributes": {
                    "id_product_attribute": "13",
                    "id_product": "3",
                    "id_customization": null,
                    "name": "Cashmere Tank",
                    "description_short": "<p>Donec fringilla sapien sed elit luctus, eget mattis dolor efficitur. Ut id libero nulla. Morbi aliquam tortor massa, in aliquet eros molestie in. Quisque eleifend diam leo, a bibendum mi eleifend eget.<\/p>",
                    "available_now": null,
                    "available_later": null,
                    "id_manufacturer": "2",
                    "on_sale": "0",
                    "ecotax": "0.000000",
                    "price": "$29.00",
                    "quantity": 1,
                    "link_rewrite": "the-best-is-yet-to-come-framed-poster",
                    "category": "women",
                    "reference": "demo_6",
                    "minimal_quantity": "1",
                    "id_image": "3-110",
                    "reduction": 0,
                    "price_without_reduction": 29,
                    "specific_prices": [],
                    "features": [{
                        "id_feature": "1",
                        "id_product": "3",
                        "id_feature_value": "6"
                    }],
                    "attributes": {
                        "Dimension": "40x60cm"
                    },
                    "rate": 0,
                    "tax_name": "",
                    "ecotax_rate": "",
                    "customizable": "",
                    "online_only": "",
                    "new": "",
                    "condition": "",
                    "pack": "",
                    "price_amount": "$29.00",
                    "quantity_wanted": "1"
                },
                "quantity_discounts": [],
                "reference_to_display": "demo_6",
                "seo_availability": "https:\/\/schema.org\/InStock",
                "labels": {
                    "tax_short": "(tax excl.)",
                    "tax_long": "Tax excluded"
                },
                "ecotax": {
                    "value": "$0.00",
                    "amount": "0.000000",
                    "rate": ""
                },
                "flags": [],
                "main_variants": [],
                "id_product_attribute": "13",
                "id_product": "3",
                "cart_quantity": "1",
                "id_customization": null,
                "name": "Cashmere Tank",
                "description_short": "<p>Donec fringilla sapien sed elit luctus, eget mattis dolor efficitur. Ut id libero nulla. Morbi aliquam tortor massa, in aliquet eros molestie in. Quisque eleifend diam leo, a bibendum mi eleifend eget.<\/p>",
                "available_now": null,
                "available_later": null,
                "id_manufacturer": "2",
                "manufacturer_name": "Graphic Corner",
                "on_sale": "0",
                "price": "$29.00",
                "quantity": 1,
                "link_rewrite": "the-best-is-yet-to-come-framed-poster",
                "category": "women",
                "price_attribute": "0.000000",
                "ecotax_attr": "0.000000",
                "reference": "demo_6",
                "ean13": null,
                "isbn": null,
                "upc": null,
                "minimal_quantity": "1",
                "id_image": "3-110",
                "legend": null,
                "reduction": 0,
                "price_without_reduction": 29,
                "specific_prices": [],
                "stock_quantity": 900,
                "price_with_reduction": 29,
                "price_with_reduction_without_tax": 29,
                "total": "$29.00",
                "total_wt": 29,
                "price_wt": 29,
                "allow_oosp": 0,
                "attributes_small": "40x60cm",
                "rate": 0,
                "tax_name": "",
                "remove_from_cart_url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/cart?delete=1&id_product=3&id_product_attribute=13&token=9e645ea2b011b9302f90d49f848c7122",
                "up_quantity_url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/cart?update=1&id_product=3&id_product_attribute=13&token=9e645ea2b011b9302f90d49f848c7122&op=up",
                "down_quantity_url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/cart?update=1&id_product=3&id_product_attribute=13&token=9e645ea2b011b9302f90d49f848c7122&op=down",
                "update_quantity_url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/cart?update=1&id_product=3&id_product_attribute=13&token=9e645ea2b011b9302f90d49f848c7122",
                "ecotax_rate": "",
                "customizable": "",
                "online_only": "",
                "new": "",
                "pack": "",
                "price_amount": "$29.00",
                "quantity_wanted": "1",
                "images": [{
                    "bySize": {
                        "cart_default": {
                            "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/110-cart_default\/the-best-is-yet-to-come-framed-poster.jpg",
                            "width": 200,
                            "height": 229
                        },
                        "small_default": {
                            "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/110-small_default\/the-best-is-yet-to-come-framed-poster.jpg",
                            "width": 200,
                            "height": 229
                        },
                        "medium_default": {
                            "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/110-medium_default\/the-best-is-yet-to-come-framed-poster.jpg",
                            "width": 452,
                            "height": 517
                        },
                        "home_default": {
                            "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/110-home_default\/the-best-is-yet-to-come-framed-poster.jpg",
                            "width": 600,
                            "height": 686
                        },
                        "thickbox_default": {
                            "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/110-thickbox_default\/the-best-is-yet-to-come-framed-poster.jpg",
                            "width": 600,
                            "height": 686
                        },
                        "large_default": {
                            "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/110-large_default\/the-best-is-yet-to-come-framed-poster.jpg",
                            "width": 840,
                            "height": 960
                        }
                    },
                    "small": {
                        "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/110-cart_default\/the-best-is-yet-to-come-framed-poster.jpg",
                        "width": 200,
                        "height": 229
                    },
                    "medium": {
                        "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/110-home_default\/the-best-is-yet-to-come-framed-poster.jpg",
                        "width": 600,
                        "height": 686
                    },
                    "large": {
                        "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/110-large_default\/the-best-is-yet-to-come-framed-poster.jpg",
                        "width": 840,
                        "height": 960
                    },
                    "legend": null,
                    "id_image": "110",
                    "cover": "1",
                    "position": "1",
                    "associatedVariants": []
                }, {
                    "bySize": {
                        "cart_default": {
                            "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/111-cart_default\/the-best-is-yet-to-come-framed-poster.jpg",
                            "width": 200,
                            "height": 229
                        },
                        "small_default": {
                            "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/111-small_default\/the-best-is-yet-to-come-framed-poster.jpg",
                            "width": 200,
                            "height": 229
                        },
                        "medium_default": {
                            "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/111-medium_default\/the-best-is-yet-to-come-framed-poster.jpg",
                            "width": 452,
                            "height": 517
                        },
                        "home_default": {
                            "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/111-home_default\/the-best-is-yet-to-come-framed-poster.jpg",
                            "width": 600,
                            "height": 686
                        },
                        "thickbox_default": {
                            "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/111-thickbox_default\/the-best-is-yet-to-come-framed-poster.jpg",
                            "width": 600,
                            "height": 686
                        },
                        "large_default": {
                            "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/111-large_default\/the-best-is-yet-to-come-framed-poster.jpg",
                            "width": 840,
                            "height": 960
                        }
                    },
                    "small": {
                        "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/111-cart_default\/the-best-is-yet-to-come-framed-poster.jpg",
                        "width": 200,
                        "height": 229
                    },
                    "medium": {
                        "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/111-home_default\/the-best-is-yet-to-come-framed-poster.jpg",
                        "width": 600,
                        "height": 686
                    },
                    "large": {
                        "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/111-large_default\/the-best-is-yet-to-come-framed-poster.jpg",
                        "width": 840,
                        "height": 960
                    },
                    "legend": null,
                    "id_image": "111",
                    "cover": null,
                    "position": "2",
                    "associatedVariants": []
                }, {
                    "bySize": {
                        "cart_default": {
                            "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/112-cart_default\/the-best-is-yet-to-come-framed-poster.jpg",
                            "width": 200,
                            "height": 229
                        },
                        "small_default": {
                            "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/112-small_default\/the-best-is-yet-to-come-framed-poster.jpg",
                            "width": 200,
                            "height": 229
                        },
                        "medium_default": {
                            "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/112-medium_default\/the-best-is-yet-to-come-framed-poster.jpg",
                            "width": 452,
                            "height": 517
                        },
                        "home_default": {
                            "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/112-home_default\/the-best-is-yet-to-come-framed-poster.jpg",
                            "width": 600,
                            "height": 686
                        },
                        "thickbox_default": {
                            "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/112-thickbox_default\/the-best-is-yet-to-come-framed-poster.jpg",
                            "width": 600,
                            "height": 686
                        },
                        "large_default": {
                            "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/112-large_default\/the-best-is-yet-to-come-framed-poster.jpg",
                            "width": 840,
                            "height": 960
                        }
                    },
                    "small": {
                        "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/112-cart_default\/the-best-is-yet-to-come-framed-poster.jpg",
                        "width": 200,
                        "height": 229
                    },
                    "medium": {
                        "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/112-home_default\/the-best-is-yet-to-come-framed-poster.jpg",
                        "width": 600,
                        "height": 686
                    },
                    "large": {
                        "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/112-large_default\/the-best-is-yet-to-come-framed-poster.jpg",
                        "width": 840,
                        "height": 960
                    },
                    "legend": null,
                    "id_image": "112",
                    "cover": null,
                    "position": "3",
                    "associatedVariants": []
                }, {
                    "bySize": {
                        "cart_default": {
                            "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/113-cart_default\/the-best-is-yet-to-come-framed-poster.jpg",
                            "width": 200,
                            "height": 229
                        },
                        "small_default": {
                            "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/113-small_default\/the-best-is-yet-to-come-framed-poster.jpg",
                            "width": 200,
                            "height": 229
                        },
                        "medium_default": {
                            "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/113-medium_default\/the-best-is-yet-to-come-framed-poster.jpg",
                            "width": 452,
                            "height": 517
                        },
                        "home_default": {
                            "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/113-home_default\/the-best-is-yet-to-come-framed-poster.jpg",
                            "width": 600,
                            "height": 686
                        },
                        "thickbox_default": {
                            "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/113-thickbox_default\/the-best-is-yet-to-come-framed-poster.jpg",
                            "width": 600,
                            "height": 686
                        },
                        "large_default": {
                            "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/113-large_default\/the-best-is-yet-to-come-framed-poster.jpg",
                            "width": 840,
                            "height": 960
                        }
                    },
                    "small": {
                        "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/113-cart_default\/the-best-is-yet-to-come-framed-poster.jpg",
                        "width": 200,
                        "height": 229
                    },
                    "medium": {
                        "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/113-home_default\/the-best-is-yet-to-come-framed-poster.jpg",
                        "width": 600,
                        "height": 686
                    },
                    "large": {
                        "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/113-large_default\/the-best-is-yet-to-come-framed-poster.jpg",
                        "width": 840,
                        "height": 960
                    },
                    "legend": null,
                    "id_image": "113",
                    "cover": null,
                    "position": "4",
                    "associatedVariants": []
                }],
                "cover": {
                    "bySize": {
                        "cart_default": {
                            "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/110-cart_default\/the-best-is-yet-to-come-framed-poster.jpg",
                            "width": 200,
                            "height": 229
                        },
                        "small_default": {
                            "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/110-small_default\/the-best-is-yet-to-come-framed-poster.jpg",
                            "width": 200,
                            "height": 229
                        },
                        "medium_default": {
                            "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/110-medium_default\/the-best-is-yet-to-come-framed-poster.jpg",
                            "width": 452,
                            "height": 517
                        },
                        "home_default": {
                            "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/110-home_default\/the-best-is-yet-to-come-framed-poster.jpg",
                            "width": 600,
                            "height": 686
                        },
                        "thickbox_default": {
                            "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/110-thickbox_default\/the-best-is-yet-to-come-framed-poster.jpg",
                            "width": 600,
                            "height": 686
                        },
                        "large_default": {
                            "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/110-large_default\/the-best-is-yet-to-come-framed-poster.jpg",
                            "width": 840,
                            "height": 960
                        }
                    },
                    "small": {
                        "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/110-cart_default\/the-best-is-yet-to-come-framed-poster.jpg",
                        "width": 200,
                        "height": 229
                    },
                    "medium": {
                        "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/110-home_default\/the-best-is-yet-to-come-framed-poster.jpg",
                        "width": 600,
                        "height": 686
                    },
                    "large": {
                        "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/110-large_default\/the-best-is-yet-to-come-framed-poster.jpg",
                        "width": 840,
                        "height": 960
                    },
                    "legend": null,
                    "id_image": "110",
                    "cover": "1",
                    "position": "1",
                    "associatedVariants": []
                },
                "has_discount": false,
                "discount_type": null,
                "discount_percentage": null,
                "discount_percentage_absolute": null,
                "discount_amount": null,
                "regular_price_amount": "$29.00",
                "regular_price": "$29.00",
                "discount_to_display": null,
                "unit_price_full": "",
                "unit_price": "",
                "show_availability": true,
                "availability_date": null,
                "availability_message": "",
                "availability": "available",
                "customizations": []
            }],
            "totals": {
                "total": {
                    "type": "total",
                    "label": "Total",
                    "amount": 36,
                    "value": "$36.00"
                },
                "total_including_tax": {
                    "type": "total",
                    "label": "Total (tax incl.)",
                    "amount": 36,
                    "value": "$36.00"
                },
                "total_excluding_tax": {
                    "type": "total",
                    "label": "Total (tax excl.)",
                    "amount": 36,
                    "value": "$36.00"
                }
            },
            "subtotals": {
                "products": {
                    "type": "products",
                    "label": "Subtotal",
                    "amount": 29,
                    "value": "$29.00"
                },
                "discounts": null,
                "shipping": {
                    "type": "shipping",
                    "label": "Shipping",
                    "amount": 7,
                    "value": "$7.00"
                },
                "tax": {
                    "type": "tax",
                    "label": "Taxes",
                    "amount": 0,
                    "value": "$0.00"
                }
            },
            "products_count": 1,
            "summary_string": "1 item",
            "vouchers": {
                "allowed": 1,
                "added": []
            },
            "discounts": [],
            "minimalPurchase": 0,
            "minimalPurchaseRequired": ""
        },
        "currency": {
            "name": "US Dollar",
            "iso_code": "USD",
            "iso_code_num": "840",
            "sign": "$"
        },
        "customer": {
            "lastname": "hadab",
            "firstname": "Khan",
            "email": "ks@gmail.com",
            "birthday": "2000-04-30",
            "newsletter": "1",
            "newsletter_date_add": "2021-10-09 01:39:44",
            "optin": "1",
            "website": null,
            "company": null,
            "siret": null,
            "ape": null,
            "is_logged": true,
            "gender": {
                "type": "0",
                "name": {
                    "1": "Mr.",
                    "2": "M",
                    "3": "Herr",
                    "4": "Sig.",
                    "5": "Sr.",
                    "6": "Pan"
                }
            },
            "addresses": {
                "12": {
                    "id": "12",
                    "alias": "asas",
                    "firstname": "Khan",
                    "lastname": "hadab",
                    "company": "asasa",
                    "address1": "asasassa",
                    "address2": "asasa",
                    "postcode": "40025",
                    "city": "saasa",
                    "id_state": "1",
                    "state": "AA",
                    "state_iso": "AA",
                    "id_country": "21",
                    "country": "United States",
                    "country_iso": "US",
                    "other": "",
                    "phone": "74848498498",
                    "phone_mobile": "",
                    "vat_number": "",
                    "dni": "",
                    "formatted": "Khan hadab<br>asasa<br>asasassa asasa<br>saasa, AA 40025<br>United States<br>74848498498"
                }
            }
        },
        "language": {
            "name": "English (English)",
            "iso_code": "en",
            "locale": "en-US",
            "language_code": "en-us",
            "is_rtl": "0",
            "date_format_lite": "m\/d\/Y",
            "date_format_full": "m\/d\/Y H:i:s",
            "id": 1
        },
        "page": {
            "title": "",
            "canonical": null,
            "meta": {
                "title": "Cashmere Tank",
                "description": "Donec fringilla sapien sed elit luctus, eget mattis dolor efficitur. Ut id libero nulla. Morbi aliquam tortor massa, in aliquet eros molestie in. Quisque eleifend diam leo, a bibendum mi eleifend eget.",
                "keywords": null,
                "robots": "index"
            },
            "page_name": "product",
            "body_classes": {
                "lang-en": true,
                "lang-rtl": false,
                "country-US": true,
                "currency-USD": true,
                "layout-full-width": true,
                "page-product": true,
                "tax-display-disabled": true,
                "product-id-3": true,
                "product-Cashmere Tank": true,
                "product-id-category-6": true,
                "product-id-manufacturer-2": true,
                "product-id-supplier-0": true,
                "product-available-for-order": true
            },
            "admin_notifications": []
        },
        "shop": {
            "name": "Evo Fashion Store",
            "logo": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/img\/evos-fashion-store-logo-1624453651.jpg",
            "stores_icon": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/img\/logo_stores.png",
            "favicon": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/img\/favicon.ico"
        },
        "urls": {
            "base_url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/",
            "current_url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/women\/3-13-the-best-is-yet-to-come-framed-poster.html",
            "shop_domain_url": "https:\/\/rubiktheme.com",
            "img_ps_url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/img\/",
            "img_cat_url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/img\/c\/",
            "img_lang_url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/img\/l\/",
            "img_prod_url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/img\/p\/",
            "img_manu_url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/img\/m\/",
            "img_sup_url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/img\/su\/",
            "img_ship_url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/img\/s\/",
            "img_store_url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/img\/st\/",
            "img_col_url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/img\/co\/",
            "img_url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/themes\/rb_evo\/assets\/img\/",
            "css_url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/themes\/rb_evo\/assets\/css\/",
            "js_url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/themes\/rb_evo\/assets\/js\/",
            "pic_url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/upload\/",
            "pages": {
                "address": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/address",
                "addresses": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/addresses",
                "authentication": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/login",
                "cart": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/cart",
                "category": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/index.php?controller=category",
                "cms": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/index.php?controller=cms",
                "contact": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/contact-us",
                "discount": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/discount",
                "guest_tracking": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/guest-tracking",
                "history": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/order-history",
                "identity": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/identity",
                "index": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/",
                "my_account": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/my-account",
                "order_confirmation": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/order-confirmation",
                "order_detail": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/index.php?controller=order-detail",
                "order_follow": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/order-follow",
                "order": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/order",
                "order_return": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/index.php?controller=order-return",
                "order_slip": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/credit-slip",
                "pagenotfound": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/page-not-found",
                "password": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/password-recovery",
                "pdf_invoice": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/index.php?controller=pdf-invoice",
                "pdf_order_return": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/index.php?controller=pdf-order-return",
                "pdf_order_slip": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/index.php?controller=pdf-order-slip",
                "prices_drop": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/prices-drop",
                "product": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/index.php?controller=product",
                "search": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/search",
                "sitemap": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/sitemap",
                "stores": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/stores",
                "supplier": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/supplier",
                "register": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/login?create_account=1",
                "order_login": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/order?login=1"
            },
            "alternative_langs": {
                "en-us": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/women\/3-the-best-is-yet-to-come-framed-poster.html",
                "fr-fr": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/fr\/women\/3-the-best-is-yet-to-come-framed-poster.html",
                "de-de": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/de\/women\/3-the-best-is-yet-to-come-framed-poster.html",
                "it-it": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/it\/women\/3-the-best-is-yet-to-come-framed-poster.html",
                "es-es": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/es\/women\/3-the-best-is-yet-to-come-framed-poster.html",
                "pl-pl": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/pl\/women\/3-the-best-is-yet-to-come-framed-poster.html"
            },
            "theme_assets": "\/demo\/rb_evo_demo\/themes\/rb_evo\/assets\/",
            "actions": {
                "logout": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/?mylogout="
            },
            "no_picture_image": {
                "bySize": {
                    "cart_default": {
                        "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/img\/p\/en-default-cart_default.jpg",
                        "width": 200,
                        "height": 229
                    },
                    "small_default": {
                        "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/img\/p\/en-default-small_default.jpg",
                        "width": 200,
                        "height": 229
                    },
                    "medium_default": {
                        "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/img\/p\/en-default-medium_default.jpg",
                        "width": 452,
                        "height": 517
                    },
                    "home_default": {
                        "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/img\/p\/en-default-home_default.jpg",
                        "width": 600,
                        "height": 686
                    },
                    "thickbox_default": {
                        "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/img\/p\/en-default-thickbox_default.jpg",
                        "width": 600,
                        "height": 686
                    },
                    "large_default": {
                        "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/img\/p\/en-default-large_default.jpg",
                        "width": 840,
                        "height": 960
                    }
                },
                "small": {
                    "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/img\/p\/en-default-cart_default.jpg",
                    "width": 200,
                    "height": 229
                },
                "medium": {
                    "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/img\/p\/en-default-home_default.jpg",
                    "width": 600,
                    "height": 686
                },
                "large": {
                    "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/img\/p\/en-default-large_default.jpg",
                    "width": 840,
                    "height": 960
                },
                "legend": ""
            }
        },
        "configuration": {
            "display_taxes_label": false,
            "display_prices_tax_incl": false,
            "is_catalog": false,
            "show_prices": true,
            "opt_in": {
                "partner": true
            },
            "quantity_discount": {
                "type": "discount",
                "label": "Unit discount"
            },
            "voucher_enabled": 1,
            "return_enabled": 0
        },
        "field_required": [],
        "breadcrumb": {
            "links": [{
                "title": "Home",
                "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/"
            }, {
                "title": "Women",
                "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/6-women"
            }, {
                "title": "Cashmere Tank",
                "url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/women\/3-13-the-best-is-yet-to-come-framed-poster.html#\/dimension-40x60cm"
            }],
            "count": 3
        },
        "link": {
            "protocol_link": "https:\/\/",
            "protocol_content": "https:\/\/"
        },
        "time": 1633769955,
        "static_token": "9e645ea2b011b9302f90d49f848c7122",
        "token": "ba4a8df23d52bcd1aff620475b47138d",
        "debug": true
    };
    var psemailsubscription_subscription =
        "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/module\/ps_emailsubscription\/subscription";
    var psr_icon_color = "#F19D76";
    var rbFrontendConfig = {
        "isEditMode": "",
        "stretchedSectionContainer": "",
        "is_rtl": "",
        "rb_day": "Days"
    };
    var rb_days = "Days";
    var rb_facebook = {
        "general_appid": "1671479023110588",
        "general_pageid": "2005509456220113",
        "chat_state": "0",
        "chat_color": "",
        "chat_delay": "12",
        "login_state": "0",
        "login_redirect": "authentication_page",
        "comments_state": "1",
        "comments_tab": "1",
        "comments_width": "100%",
        "comments_number": "",
        "comments_admins": "",
        "product_page_url": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/women\/3-13-the-best-is-yet-to-come-framed-poster.html",
        "login_destination": "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/my-account",
        "phrases": {
            "login": "Log in"
        }
    };
    var rb_height = "460";
    var rb_hours = "Hours";
    var rb_minutes = "Minutes";
    var rb_modal =
        "<!-- begin \/var\/www\/html\/demo\/rb_evo_demo\/modules\/rbthemefunction\/views\/templates\/rb-modal.tpl --><div class=\"modal-content\">\n\t<div class=\"modal-header\">\n\t\t<h5 class=\"modal-title text-xs-center\">\n\t\t\tDelete selected item ?\n\t\t<\/h5>\n\t<\/div>\n\n\t<div class=\"modal-footer\">\n\t\t<button type=\"button\" class=\"rb-modal-no rb-modal-accept btn btn-primary\" data-dismiss=\"modal\">\n\t\t\tCancel\n\t\t<\/button>\n\n\t\t<button type=\"button\" class=\"rb-modal-yes rb-modal-accept btn btn-primary\">\n\t\t\tOK\n\t\t<\/button>\n\t<\/div>\n<\/div><!-- end \/var\/www\/html\/demo\/rb_evo_demo\/modules\/rbthemefunction\/views\/templates\/rb-modal.tpl -->";
    var rb_seconds = "Seconds";
    var rb_slick = {
        "active": "1",
        "slideshow": "4",
        "slidesToScroll": "1",
        "autoplay": "0",
        "autospeed": ""
    };
    var rb_text = "You must be logged. <a href=\"https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/login\">Sign in<\/a>";
    var rb_view = "1";
    var rb_width = "770";
    var rb_zoom = {
        "active": "1",
        "type": "2",
        "scroll": "1"
    };
    </script>




    <meta property="og:type" content="product">
    <meta property="og:url"
        content="https://rubiktheme.com/demo/rb_evo_demo/en/women/3-13-the-best-is-yet-to-come-framed-poster.html">
    <meta property="og:title" content="Cashmere Tank">
    <meta property="og:site_name" content="Evo Fashion Store">
    <meta property="og:description"
        content="Donec fringilla sapien sed elit luctus, eget mattis dolor efficitur. Ut id libero nulla. Morbi aliquam tortor massa, in aliquet eros molestie in. Quisque eleifend diam leo, a bibendum mi eleifend eget.">
    <meta property="og:image"
        content="https://rubiktheme.com/demo/rb_evo_demo/110-large_default/the-best-is-yet-to-come-framed-poster.jpg">
    <meta property="product:pretax_price:amount" content="29">
    <meta property="product:pretax_price:currency" content="USD">
    <meta property="product:price:amount" content="29">
    <meta property="product:price:currency" content="USD">
    <meta property="product:weight:value" content="0.300000">
    <meta property="product:weight:units" content="kg">

</head>

<body id="<?= $body_name ?>"
    class="lang-en country-us currency-usd layout-full-width page-product tax-display-disabled product-id-3 product-cashmere-tank product-id-category-6 product-id-manufacturer-2 product-id-supplier-0 product-available-for-order home-1">
    <div class="mfp-bg mfp-zoom-in mfp-ready" id="wish_error" style="display:none"></div>
    <div class="mfp-wrap mfp-close-btn-in mfp-auto-cursor mfp-zoom-in mfp-ready" tabindex="-1"  style="display:none">
    <div class="mfp-container mfp-s-ready mfp-inline-holder">
        <div class="mfp-content" style="display: flex;justify-content: center;align-items: center;height: 100vh;position:absolute;left:0;top:0">
            <div class="rb-popup-content rb-small-popup text-center">You must be logged. <a href="javascript:void(0)" id="add_wishlist_no_login">Sign in</a>
            <button title="Close (Esc)" type="button" class="mfp-close">×</button>
        </div>
    </div>
    <div class="mfp-preloader">Loading...</div></div></div>

        <!-- <div class="rb-loading" style="background: #f1f1f1;z-index: 1;">
            <div id="loadFacebookG">
                <img class="logo img-fluid" src="logo.png">
                <div id="blockG_1" class="facebook_blockG"></div>
                <div id="blockG_2" class="facebook_blockG"></div>
                <div id="blockG_3" class="facebook_blockG"></div>
            </div>
        </div> -->


    <main>


        <header id="header" class="rb-float-header">
            <div class="rb-header header-v5">
                <div class="header-desktop hidden-md-down">
                    <div class="header-wrapper" data-sticky_header="0">
                        <div class="container container-large">
                            <div class="row header-flex">
                                <div class="col-xl-1 col-lg-2 col-md-6 col-sm-6 col-xs-6 header-left">
                                    <div class="rbLogo">
                                        <a href="<?= FRONT_SITE_PATH ?>index">
                                            <img class="logo img-fluid" src="logo.png" alt="PS Fashion Store">
                                        </a>
                                    </div>
                                </div>
                                <div class="col-xl-8 col-lg-7 col-md-6 col-sm-6 col-xs-6 megamenu header-center">
                                    <div class="rb_megamenu layout_layout1 show_icon_in_mobile transition_fade transition_floating rb-dir-ltr hook-default  single_layout  disable_sticky_mobile"
                                        data-bggray="bg_gray">
                                        <div class="rb_megamenu_content">
                                            <div class="container">
                                                <div class="rb_megamenu_content_content">
                                                    <div class="ybc-menu-toggle ybc-menu-btn closed">
                                                        <span class="ybc-menu-button-toggle_icon">
                                                            <i class="icon-bar"></i>
                                                            <i class="icon-bar"></i>
                                                            <i class="icon-bar"></i>
                                                        </span>
                                                        Menu
                                                    </div>
                                                    <ul class="rb_menus_ul  ">
                                                        <li class="close_menu">
                                                            <div class="pull-left">
                                                                <span class="rb_menus_back">
                                                                    <i class="icon-bar"></i>
                                                                    <i class="icon-bar"></i>
                                                                    <i class="icon-bar"></i>
                                                                </span>
                                                                Menu
                                                            </div>
                                                            <div class="pull-right">
                                                                <span class="rb_menus_back_icon"></span>
                                                                Back
                                                            </div>
                                                        </li>
                                                        <!-- <li class="rb_menus_li rb_sub_align_full rb_has_sub">
                                                             <a href="<?= FRONT_SITE_PATH.'shop' ?>" style="font-size:16px;">
                                                                <span class="rb_menu_content_title">
                                                                    Shop
                                                                <span class="rb_arrow"></span> </span>
                                                            </a>
                                                            <span class="arrow closed"></span>
                                                            <ul class="rb_columns_ul" style="width:100%; font-size:14px;">
                                                                <li class="rb_columns_li column_size_4  rb_has_sub">
                                                                    <ul class="rb_blocks_ul">
                                                                        <li data-id-block="4" class="rb_blocks_li">
                                                                            <div class="rb_block rb_block_type_product ">
                                                                                <h4>Popular products</h4>
                                                                                <div class="rb_block_content">
                                                                                    <article
                                                                                        class="product-miniature js-product-miniature"
                                                                                        data-id-product="2"
                                                                                        data-id-product-attribute="9"
                                                                                        itemscope
                                                                                        itemtype="http://schema.org/Product">
                                                                                        <div
                                                                                            class="thumbnail-container">

                                                                                            <a href="https://rubiktheme.com/demo/rb_evo_demo/en/shoes/2-9-brown-bear-printed-sweater.html#/1-size-s"
                                                                                                class="thumbnail product-thumbnail">
                                                                                                <img src="https://rubiktheme.com/demo/rb_evo_demo/105-home_default/brown-bear-printed-sweater.jpg"
                                                                                                    alt="Abstract Print Cotton Blouse"
                                                                                                    data-full-size-image-url="https://rubiktheme.com/demo/rb_evo_demo/105-home_default/brown-bear-printed-sweater.jpg" />
                                                                                            </a>

                                                                                            <div
                                                                                                class="rb-product-description">

                                                                                                <h4 class="h3 product-title"
                                                                                                    itemprop="name">
                                                                                                    <a
                                                                                                        href="https://rubiktheme.com/demo/rb_evo_demo/en/shoes/2-9-brown-bear-printed-sweater.html#/1-size-s">
                                                                                                        Abstract Print
                                                                                                        Cotton Blouse
                                                                                                    </a>
                                                                                                    <span
                                                                                                        class="product_combination">
                                                                                                        Size-S</span>
                                                                                                </h4>



                                                                                                <div
                                                                                                    class="product-price-and-shipping">

                                                                                                    <span
                                                                                                        itemprop="price"
                                                                                                        class="price">$15.90</span>


                                                                                                    <span
                                                                                                        class="regular-price">$35.90</span>



                                                                                                </div>

                                                                                            </div>

                                                                                            <ul class="product-flags">
                                                                                                <li class="discount">
                                                                                                    -$20.00</li>
                                                                                            </ul>

                                                                                            <div
                                                                                                class="highlighted-informations no-variants hidden-sm-down">
                                                                                                <a href="#"
                                                                                                    class="quick-view"
                                                                                                    data-link-action="quickview">
                                                                                                    <i
                                                                                                        class="material-icons search">&#xE8B6;</i>
                                                                                                    Quick view
                                                                                                </a>



                                                                                            </div>


                                                                                        </div>
                                                                                    </article>
                                                                                </div>
                                                                            </div>
                                                                            <div class="clearfix"></div>

                                                                        </li>
                                                                    </ul>
                                                                </li>
                                                                <li class="rb_columns_li column_size_4  rb_has_sub">
                                                                    <ul class="rb_blocks_ul">
                                                                        <li data-id-block="5" class="rb_blocks_li">

                                                                            <div
                                                                                class="rb_block rb_block_type_product ">
                                                                                <h4>Special products</h4>
                                                                                <div class="rb_block_content">

                                                                                    <article
                                                                                        class="product-miniature js-product-miniature">
                                                                                        <div
                                                                                            class="thumbnail-container">

                                                                                            <a href=""
                                                                                                class="thumbnail product-thumbnail">
                                                                                                <img src="https://rubiktheme.com/demo/rb_evo_demo/101-home_default/hummingbird-printed-t-shirt.jpg"
                                                                                                    alt="Harman Blue Sneakers"
                                                                                                    data-full-size-image-url="https://rubiktheme.com/demo/rb_evo_demo/101-home_default/hummingbird-printed-t-shirt.jpg" />
                                                                                            </a>

                                                                                            <div
                                                                                                class="rb-product-description">

                                                                                                <h4 class="h3 product-title"
                                                                                                    itemprop="name">
                                                                                                    <a href="">
                                                                                                        Harman Blue
                                                                                                        Sneakers
                                                                                                    </a>
                                                                                                    <span
                                                                                                        class="product_combination">
                                                                                                        Size-S,
                                                                                                        Color-White</span>
                                                                                                </h4>



                                                                                                <div
                                                                                                    class="product-price-and-shipping">

                                                                                                    <span
                                                                                                        itemprop="price"
                                                                                                        class="price">$19.12</span>


                                                                                                    <span
                                                                                                        class="regular-price">$23.90</span>
                                                                                                    <span
                                                                                                        class="discount-percentage">-20%</span>



                                                                                                </div>

                                                                                            </div>

                                                                                            <ul class="product-flags">
                                                                                                <li class="discount">
                                                                                                    -20%</li>
                                                                                            </ul>

                                                                                            <div
                                                                                                class="highlighted-informations no-variants hidden-sm-down">
                                                                                                <a href="#"
                                                                                                    class="quick-view"
                                                                                                    data-link-action="quickview">
                                                                                                    <i
                                                                                                        class="material-icons search">&#xE8B6;</i>
                                                                                                    Quick view
                                                                                                </a>



                                                                                            </div>


                                                                                        </div>
                                                                                    </article>
                                                                                    <article
                                                                                        class="product-miniature js-product-miniature">
                                                                                        <div
                                                                                            class="thumbnail-container">

                                                                                            <a href=""
                                                                                                class="thumbnail product-thumbnail">
                                                                                                <img src="https://rubiktheme.com/demo/rb_evo_demo/105-home_default/brown-bear-printed-sweater.jpg"
                                                                                                    alt="Abstract Print Cotton Blouse"
                                                                                                    data-full-size-image-url="https://rubiktheme.com/demo/rb_evo_demo/105-home_default/brown-bear-printed-sweater.jpg" />
                                                                                            </a>

                                                                                            <div
                                                                                                class="rb-product-description">

                                                                                                <h4 class="h3 product-title"
                                                                                                    itemprop="name">
                                                                                                    <a href="">
                                                                                                        Abstract Print
                                                                                                        Cotton Blouse
                                                                                                    </a>
                                                                                                    <span
                                                                                                        class="product_combination">
                                                                                                        Size-S</span>
                                                                                                </h4>



                                                                                                <div
                                                                                                    class="product-price-and-shipping">

                                                                                                    <span
                                                                                                        itemprop="price"
                                                                                                        class="price">$15.90</span>


                                                                                                    <span
                                                                                                        class="regular-price">$35.90</span>



                                                                                                </div>

                                                                                            </div>

                                                                                            <ul class="product-flags">
                                                                                                <li class="discount">
                                                                                                    -$20.00</li>
                                                                                            </ul>

                                                                                            <div
                                                                                                class="highlighted-informations no-variants hidden-sm-down">
                                                                                                <a href="#"
                                                                                                    class="quick-view"
                                                                                                    data-link-action="quickview">
                                                                                                    <i
                                                                                                        class="material-icons search">&#xE8B6;</i>
                                                                                                    Quick view
                                                                                                </a>



                                                                                            </div>


                                                                                        </div>
                                                                                    </article>
                                                                                </div>
                                                                            </div>
                                                                            <div class="clearfix"></div>

                                                                        </li>
                                                                    </ul>
                                                                </li>

                                                                <li class="rb_columns_li column_size_4  rb_has_sub">
                                                                    <ul class="rb_blocks_ul">
                                                                        <li data-id-block="5" class="rb_blocks_li">

                                                                            <div
                                                                                class="rb_block rb_block_type_product ">
                                                                                <h4>Special products</h4>
                                                                                <div class="rb_block_content">

                                                                                    <article
                                                                                        class="product-miniature js-product-miniature">
                                                                                        <div
                                                                                            class="thumbnail-container">

                                                                                            <a href=""
                                                                                                class="thumbnail product-thumbnail">
                                                                                                <img src="https://rubiktheme.com/demo/rb_evo_demo/101-home_default/hummingbird-printed-t-shirt.jpg"
                                                                                                    alt="Harman Blue Sneakers"
                                                                                                    data-full-size-image-url="https://rubiktheme.com/demo/rb_evo_demo/101-home_default/hummingbird-printed-t-shirt.jpg" />
                                                                                            </a>

                                                                                            <div
                                                                                                class="rb-product-description">

                                                                                                <h4 class="h3 product-title"
                                                                                                    itemprop="name">
                                                                                                    <a href="">
                                                                                                        Harman Blue
                                                                                                        Sneakers
                                                                                                    </a>
                                                                                                    <span
                                                                                                        class="product_combination">
                                                                                                        Size-S,
                                                                                                        Color-White</span>
                                                                                                </h4>



                                                                                                <div
                                                                                                    class="product-price-and-shipping">

                                                                                                    <span
                                                                                                        itemprop="price"
                                                                                                        class="price">$19.12</span>


                                                                                                    <span
                                                                                                        class="regular-price">$23.90</span>
                                                                                                    <span
                                                                                                        class="discount-percentage">-20%</span>



                                                                                                </div>

                                                                                            </div>

                                                                                            <ul class="product-flags">
                                                                                                <li class="discount">
                                                                                                    -20%</li>
                                                                                            </ul>

                                                                                            <div
                                                                                                class="highlighted-informations no-variants hidden-sm-down">
                                                                                                <a href="#"
                                                                                                    class="quick-view"
                                                                                                    data-link-action="quickview">
                                                                                                    <i
                                                                                                        class="material-icons search">&#xE8B6;</i>
                                                                                                    Quick view
                                                                                                </a>



                                                                                            </div>


                                                                                        </div>
                                                                                    </article>

                                                                                </div>
                                                                            </div>
                                                                            <div class="clearfix"></div>

                                                                        </li>
                                                                    </ul>
                                                                </li>
                                                            </ul>

                                                        </li>
                                                        -->
                                                        <!-- <li class="rb_menus_li rb_sub_align_left rb_has_sub">
                                                            <a href="" style="font-size:16px;">
                                                                <span class="rb_menu_content_title">
                                                                    Page
                                                                    <span class="rb_arrow"></span> </span>
                                                            </a>
                                                            <span class="arrow closed"></span>
                                                            <ul class="rb_columns_ul"
                                                                style=" width:230px; font-size:14px;">
                                                                <li class="rb_columns_li column_size_12  rb_has_sub">
                                                                    <ul class="rb_blocks_ul">
                                                                        <li data-id-block="2" class="rb_blocks_li">

                                                                            <div
                                                                                class="rb_block rb_block_type_cms rb_hide_title">
                                                                                <h4>Page</h4>
                                                                                <div class="rb_block_content">
                                                                                    <ul>
                                                                                        <li><a href="">About
                                                                                                us</a></li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                            <div class="clearfix"></div>

                                                                        </li>
                                                                    </ul>
                                                                </li>
                                                            </ul>

                                                        </li> -->
                                                        <!-- <li class="rb_menus_li rb_sub_align_full">
                                                            <a href="" style="font-size:16px;">
                                                                <span class="rb_menu_content_title">
                                                                    Contact
                                                                </span>
                                                            </a>
                                                        </li> -->
                                                    </ul>



                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-6 header-right">
                                    <div id="search-widget" class="search-widget popup-over">
                                        <a id="click_show_search" href="javascript:void(0)" data-toggle="dropdown"
                                            class="float-xs-right popup-title">
                                            <i class="icon-Ico_Search"></i>
                                        </a>
                                        <div class="rb-search-name popup-content">
                                            <div class="container">
                                                <div class="search-top">
                                                    <h2>what are you looking for?</h2>
                                                    <div class="close-search">close<i class="icon_close"></i></div>
                                                </div>
                                                <div class="search-box">
                                                    <div class="rb-search-widget">
                                                        <form method="get" action="">
                                                            <input type="text" id="Search_Product_For_Desktop" placeholder="Search"
                                                                class="rb-search" autocomplete="off">
                                                            <button class="rb-search-btn" type="submit">
                                                                <i class="icon_search"></i>
                                                                <span class="hidden-xl-down">Search</span>
                                                            </button>
                                                            <div class="cssload-container rb-ajax-loading">
                                                                <div class="cssload-double-torus"></div>
                                                            </div>
                                                        </form>
                                                    </div>

                                                    <div class="resuilt-search">
                                                        <div class="rb-resuilt" id="Product_Getted_From_DB_Desktop"></div>
                                                    </div>
                                                    <p class="rb-resuilt-error" id="notfound_Product_Desktop"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- TPL LOGIN -->
                                    <div id="rb-login" class="rb-login popup-over">
                                        <a href="javascript:void(0)" title="Login"
                                            class="align-items-center popup-title">
                                            <?php
                                            if(isset($_SESSION['UID']) && $_SESSION['UID'] > 0){
                                                if ($user['user_img'] != '') {
                                                    $user_img = USER_PROFILE.$user['user_img'];
                                                }else {
                                                    $user_img = 'https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png';
                                                }
                                                ?>
                                            <img id="header_preview_img_desktop" src="<?= $user_img ?>" class="img-fluid"
                                                style='width:70px;border-radius:50%' alt="">
                                            <?php
                                            }else{
                                                ?>
                                            <i class="icon-Ico_User"></i>
                                            <span class="rb-login-title">Login or Register</span>
                                            <?php
                                            }
                                                
                                            ?>
                                        </a>

                                        <div class="bg-over-lay"></div>
                                        <div
                                            class="rb-dropdown rb-login-form rb-form-container dd-container dd-products dd-view popup-content">
                                            <!-- <div class="close-popup"><i class="icon_close"></i></div> -->
                                            <div class="close-menubar">
                                                <span id="click_off"></span>
                                            </div>

                                            <?php

                                                if(isset($_SESSION['UID']) && $_SESSION['UID'] > 0){
                                                    ?>
                                            <!-- When User Login  -->
                                            <div class="indent rb-indent">
                                                <div class="my-info">
                                                    <a class="rb-icon-account" href="" title="View My Account"
                                                        rel="nofollow">
                                                        <img id="header_preview_img" src="<?= $user_img ?>"
                                                            class='img-fluid'
                                                            style="width: 100px;height: 100px;border-radius: 50%;">
                                                    </a>
                                                    <a class="rb-account" href="" title="View My Account"
                                                        rel="nofollow">
                                                        <span>Hi <?= $user['firstname'].' '.$user['lastname'] ?></span>
                                                    </a>
                                                    <a class="rb-logout" href="<?= FRONT_SITE_PATH.'logout' ?>"
                                                        rel="nofollow">
                                                        <span>Sign out</span>
                                                    </a>
                                                </div>
                                                <a id="identity-link" href="<?= FRONT_SITE_PATH.'identity' ?>">
                                                    <span class="link-item">
                                                        <i class="fa fa-user"></i>
                                                        Information
                                                    </span>
                                                </a>
                                                <a id="identity-link" href="<?= FRONT_SITE_PATH.'wallet' ?>">
                                                    <span class="link-item">
                                                        <i class="fa fa-briefcase"></i>
                                                        <?= CASH_LABEL_NAME ?>
                                                    </span>
                                                    <span class="float-right">
                                                        <?php
                                                            $FetchUserWalletAmt = FetchUserWalletAmt($user['id']);
                                                            echo "₹".$FetchUserWalletAmt['Total_WalletAmt'];
                                                        ?>
                                                    </span>
                                                </a>
                                                <a id="addresses-link" href="<?= FRONT_SITE_PATH.'addresses' ?>">
                                                    <span class="link-item">
                                                        <i class="fa fa-map-marker"></i>
                                                        Addresses
                                                    </span>
                                                </a>
                                                <a id="history-link" href="<?= FRONT_SITE_PATH.'order-history' ?>">
                                                    <span class="link-item">
                                                        <i class="fa fa-calendar"></i>
                                                        Order history and details
                                                    </span>
                                                </a>
                                                <a id="identity-link" href="<?= FRONT_SITE_PATH.'shoutnearn' ?>">
                                                    <span class="link-item">
                                                        <i class="fa fa-user"></i>
                                                        Invite & Earn upto ₹ <?= GETSIGNEDUPBONUS ?>
                                                    </span>
                                                </a>
                                                <a id="history-link" href="<?= SELLER_FRONT_SITE ?>">
                                                    <span class="link-item">
                                                        <img src="media/sell_5097.png" width="20px" alt="">
                                                        Sell on <?= SITE_NAME ?>
                                                    </span>
                                                </a>
                                                <!-- TPL LOGIN -->
                                                <!-- End -->

                                                <!-- TPL wishlist -->
                                                <div class="rb-id-wishlist">
                                                    <a href="<?= FRONT_SITE_PATH."wishlist" ?>">
                                                        <span class="rb-header-item">
                                                            <i class="fa fa-heart"></i>
                                                            <span class="title">Wishlist</span>
                                                            <span class="rb-wishlist-quantity rb-amount-inline"><?= count(WishlistData($user['id'])) ?></span>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                            <?php
                                                }else{
                                                    ?>
                                            <div class="indent rb-indent">
                                                <div class="title-wrap flex-container">
                                                    <h4 class="customer-form-tab login-tab active">
                                                        <span>Sign In</span>
                                                    </h4>

                                                    <h4 class="customer-form-tab register-tab">
                                                        <span>Register</span>
                                                    </h4>
                                                </div>

                                                <div class="form-wrap">
                                                    <form class="rb-customer-form active rb-form-login" action=""
                                                        method="post" id="SignSubmit_Desktop">
                                                        

                                                        <div class="relative form-group">
                                                            <div class="icon-true">
                                                                <input class="form-control" name="email" type="email"
                                                                     placeholder="Email" required="">
                                                                <i class="material-icons">email</i>
                                                            </div>
                                                        </div>
                                                        <div class="relative form-group">
                                                            <div class="input-group-dis js-parent-focus">
                                                                <div class="icon-true relative">
                                                                    <input
                                                                        class="form-control js-child-focus js-visible-password"
                                                                        name="password" type="password"
                                                                        placeholder="Password" required="">
                                                                    <i class="material-icons">vpn_key</i>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="login-submit">
                                                            <input type="hidden" name="submitLogin" value="1">
                                                            <button class="btn btn-primary login-button"
                                                                data-link-action="sign-in" type="submit">
                                                                Sign In
                                                            </button>

                                                        </div>

                                                        <a href="<?= FRONT_SITE_PATH.'password_recovery' ?>" rel="nofollow">
                                                            Forgot your password?
                                                        </a>
                                                    </form>

                                                    <form action="" class="rb-customer-form rb-form-register"
                                                        method="POST" id="Signup_Desktop">
                                                        <input type="hidden" value='<?= $url ?>' name="page_url">

                                                        <div class="form-group relative">
                                                            <label class="radio-inline">
                                                                <span class="custom-radio">
                                                                    <input name="id_gender" type="radio" value="Mr"
                                                                        required=''>
                                                                    <span></span>
                                                                </span>
                                                                Mr</label>


                                                            <label class="radio-inline">
                                                                <span class="custom-radio">
                                                                    <input name="id_gender" type="radio" value="Mrs"
                                                                        required=''>
                                                                    <span></span>
                                                                </span>
                                                                Mrs</label>
                                                        </div>

                                                        <div class="form-group relative">
                                                            <div class="icon-true">
                                                                <input class="form-control" name="email_signup"
                                                                    type="email" value="" placeholder="Email"
                                                                    required="">
                                                                <i class="material-icons">email</i>
                                                            </div>
                                                        </div>

                                                        <div class="form-group relative">
                                                            <div class="input-group-dis js-parent-focus">
                                                                <div class="icon-true relative">
                                                                    <input class="form-control" name="password_signup"
                                                                        placeholder="Password" type="password" value=""
                                                                        required="" pattern=".{5,}">
                                                                    <i class="material-icons">vpn_key</i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group relative">
                                                            <div class="icon-true">
                                                                <input class="form-control" name="firstname" type="text"
                                                                    value="" placeholder="First Name" required="">
                                                                <i class="material-icons">&#xE7FF;</i>
                                                            </div>
                                                        </div>
                                                        <div class="form-group relative">
                                                            <div class="icon-true">
                                                                <input class="form-control" name="lastname" type="text"
                                                                    value="" placeholder="Last Name" required="">
                                                                <span class="focus-border"><i></i></span>
                                                                <svg class="svgic input-icon">
                                                                    <use xlink:href="#si-account"></use>
                                                                </svg>
                                                            </div>
                                                        </div>

                                                        <div class="form-group relative">
                                                            <div class="icon-true">
                                                                <?php 
                                                                    if (isset($_GET['referCode']) && $_GET['referCode'] != '' && isset($_GET['UserId']) && $_GET['UserId'] > 0) {
                                                                        $referralCodeIs = get_safe_value($_GET['referCode']);
                                                                        $referralCodeUserId = get_safe_value($_GET['UserId']);
                                                                    }else{
                                                                        $referralCodeIs = '';
                                                                        $referralCodeUserId = '';
                                                                    }

                                                                ?>
                                                                <input class="form-control" name="referral_code" type="text"
                                                                    value="<?= $referralCodeIs ?>" placeholder="Enter Referral Code">
                                                                <input type="hidden" name="UserId" value="<?= $referralCodeUserId ?>">
                                                                <span class="focus-border"><i></i></span>
                                                                <svg class="svgic input-icon">
                                                                    <use xlink:href="#si-account"></use>
                                                                </svg>
                                                            </div>
                                                        </div>

                                                        <div class="relative form-group rb-check-box">
                                                            <input class="form-control" name="newsletter"
                                                                id="newsletter" type="checkbox" value="1">
                                                            <label for="newsletter">
                                                                Sign up for our newsletter
                                                            </label>
                                                        </div>
                                                        <button
                                                            class="btn btn-primary form-control-submit register-button"
                                                            type="submit">
                                                            Register
                                                        </button>
                                                    </form>
                                                    <div class="error_place_register">
                                                    </div>
                                                </div>

                                                <div class="error_place">

                                                </div>
                                                <a id="history-link" target="_blank" href="<?= SELLER_FRONT_SITE ?>">
                                                    <span class="link-item">
                                                        <img src="media/sell_5097.png" width="20px" alt=""> 
                                                        Sell on <?= SITE_NAME ?>
                                                    </span>
                                                </a>
                                                <!-- TPL LOGIN -->

                                                <!-- <div id="language_selector" class="d-inline-block">
                                                    <div class="language-selector dropdown js-dropdown">
                                                        <a href="javascript:void(0)" class="expand-more"
                                                            data-toggle="dropdown" data-iso-code="en">
                                                            <img src="https://rubiktheme.com/demo/rb_evo_demo/img/l/1.jpg"
                                                                alt="English" class="img-fluid lang-flag" />
                                                            English <i class="fa fa-angle-down" aria-hidden="true"></i>
                                                        </a>
                                                        <div class="dropdown-menu">
                                                            <ul>
                                                                <li class="current">
                                                                    <a href="https://rubiktheme.com/demo/rb_evo_demo/en/home-6.html"
                                                                        rel="alternate" hreflang="en"
                                                                        class="dropdown-item">
                                                                        <img src="https://rubiktheme.com/demo/rb_evo_demo/img/l/1.jpg"
                                                                            alt="English" class="img-fluid lang-flag"
                                                                            data-iso-code="en" />
                                                                        <span class="lang-name">English</span>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="https://rubiktheme.com/demo/rb_evo_demo/fr/home-6.html"
                                                                        rel="alternate" hreflang="fr"
                                                                        class="dropdown-item">
                                                                        <img src="https://rubiktheme.com/demo/rb_evo_demo/img/l/2.jpg"
                                                                            alt="Français" class="img-fluid lang-flag"
                                                                            data-iso-code="fr" />
                                                                        <span class="lang-name">Français</span>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="https://rubiktheme.com/demo/rb_evo_demo/de/home-6.html"
                                                                        rel="alternate" hreflang="de"
                                                                        class="dropdown-item">
                                                                        <img src="https://rubiktheme.com/demo/rb_evo_demo/img/l/3.jpg"
                                                                            alt="Deutsch" class="img-fluid lang-flag"
                                                                            data-iso-code="de" />
                                                                        <span class="lang-name">Deutsch</span>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="https://rubiktheme.com/demo/rb_evo_demo/it/home-6.html"
                                                                        rel="alternate" hreflang="it"
                                                                        class="dropdown-item">
                                                                        <img src="https://rubiktheme.com/demo/rb_evo_demo/img/l/4.jpg"
                                                                            alt="Italiano" class="img-fluid lang-flag"
                                                                            data-iso-code="it" />
                                                                        <span class="lang-name">Italiano</span>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="https://rubiktheme.com/demo/rb_evo_demo/es/home-6.html"
                                                                        rel="alternate" hreflang="es"
                                                                        class="dropdown-item">
                                                                        <img src="https://rubiktheme.com/demo/rb_evo_demo/img/l/5.jpg"
                                                                            alt="Español" class="img-fluid lang-flag"
                                                                            data-iso-code="es" />
                                                                        <span class="lang-name">Español</span>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="https://rubiktheme.com/demo/rb_evo_demo/pl/home-6.html"
                                                                        rel="alternate" hreflang="pl"
                                                                        class="dropdown-item">
                                                                        <img src="https://rubiktheme.com/demo/rb_evo_demo/img/l/6.jpg"
                                                                            alt="Polski" class="img-fluid lang-flag"
                                                                            data-iso-code="pl" />
                                                                        <span class="lang-name">Polski</span>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div> -->
                                                <!-- end /var/www/html/demo/rb_evo_demo/themes/rb_evo/modules/ps_languageselector/ps_languageselector.tpl -->
                                                <!-- begin /var/www/html/demo/rb_evo_demo/themes/rb_evo/modules/ps_currencyselector/ps_currencyselector.tpl -->
                                                <!-- <div id="currency_selector" class="d-inline-block">
                                                    <div class="currency-selector dropdown js-dropdown d-inline-block">
                                                        <a href="javascript:void(0)" class="expand-more"
                                                            data-toggle="dropdown">
                                                            <i class="fa fa-money"></i>
                                                            USD $
                                                            <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                                                        <div class="dropdown-menu">
                                                            <ul>
                                                                <li>
                                                                    <a title="Euro" rel="nofollow"
                                                                        href="https://rubiktheme.com/demo/rb_evo_demo/en/home-6.html?SubmitCurrency=1&amp;id_currency=2"
                                                                        class="dropdown-item">
                                                                        EUR €
                                                                    </a>
                                                                </li>
                                                                <li class="current">
                                                                    <a title="US Dollar" rel="nofollow"
                                                                        href="https://rubiktheme.com/demo/rb_evo_demo/en/home-6.html?SubmitCurrency=1&amp;id_currency=1"
                                                                        class="dropdown-item">
                                                                        USD $
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div> -->
                                                <!-- end /var/www/html/demo/rb_evo_demo/themes/rb_evo/modules/ps_currencyselector/ps_currencyselector.tpl -->
                                            </div>
                                            <?php
                                                }

                                            ?>
                                            <!-- End -->
                                        </div>
                                    </div>
                                    <!-- End -->
                                    <div id="blockcart" class="blockcart cart-preview">
                                        <a id="cart-toogle" class="cart-toogle header-btn header-cart-btn"
                                            href="javascript:void(0)" data-toggle="dropdown" data-display="static">
                                            <i class="icon-Ico_Cart" aria-hidden="true"><span
                                                    class="cart-products-count-btn"><?= $getCartTotal ?></span></i>
                                            <span class="info-wrapper">
                                                <span class="title">Cart</span>
                                                <span class="cart-toggle-details">
                                                    <span class="text-faded cart-separator"> / </span>
                                                    Empty
                                                </span>
                                            </span>
                                        </a>
                                        <div id="_desktop_blockcart-content" class="dropdown-menu-custom dropdown-menu">
                                            <div id="blockcart-content" class="blockcart-content">
                                                <div class="cart-title">
                                                    <button type="button" id="js-cart-close" class="close">
                                                        <span>×</span>
                                                    </button>
                                                    <span class="modal-title">Your cart</span>
                                                </div>
                                                <!-- When No itms in Cart  -->
                                                <span class="no-items" ></span>

                                                <!-- When Cart is not Empty  -->
                                                <ul class="cart-products">
                                                    
                                                </ul>

                                                <div class="cart-subtotals">
                                                    <p class="cart-products-count"></p>
                                                    <div class="products clearfix">
                                                        <span class="label">Subtotal</span>
                                                        <span class="price-total value float-right"></span>
                                                    </div>
                                                </div>
                                                <div class="cart-buttons text-center">
                                                    <a rel="nofollow" class="btn btn-secondary btn-block"
                                                        href="<?= FRONT_SITE_PATH.'cart' ?>">Cart</a>
                                                   
                                                    <?php
                                                        if (isset($_SESSION['UID'])) {
                                                            ?>
                                                                <a href="<?= FRONT_SITE_PATH.'checkout' ?>" class="btn btn-primary btn-block btn-lg">Checkout</a>   
                                                            <?php
                                                        }else{
                                                            ?>
                                                                 <a href="javascript:void(0)" id="login_to_CHECKOUT" class="btn btn-primary btn-block btn-lg">Login to Checkout</a>
                                                            <?php
                                                        }
                                                    ?>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-over-lay"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="header-mobile navbar-head hidden-lg-up">
                    <div class="container">
                        <div class="row header-flex">
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-3 col-xs-3 megamenu header-left">
                                <div class="rb_megamenu  layout_layout1  show_icon_in_mobile transition_fade transition_floating rb-dir-ltr hook-default single_layout disable_sticky_mobile"
                                    data-bggray="bg_gray">
                                    <div class="rb_megamenu_content">
                                        <div class="container">
                                            <div class="rb_megamenu_content_content">
                                                <div class="ybc-menu-toggle ybc-menu-btn closed">
                                                    <span class="ybc-menu-button-toggle_icon">
                                                        <i class="icon-bar"></i>
                                                        <i class="icon-bar"></i>
                                                        <i class="icon-bar"></i>
                                                    </span>
                                                    Menu
                                                </div>
                                                <ul class="rb_menus_ul  ">
                                                    <li class="close_menu">
                                                        <div class="pull-left">
                                                            <span class="rb_menus_back">
                                                                <i class="icon-bar"></i>
                                                                <i class="icon-bar"></i>
                                                                <i class="icon-bar"></i>
                                                            </span>
                                                            Menu
                                                        </div>
                                                        <div class="pull-right">
                                                            <span class="rb_menus_back_icon"></span>
                                                            Back
                                                        </div>
                                                    </li>

                                                    <!-- <li class="rb_menus_li rb_sub_align_full rb_has_sub">
                                                        <a href="" style="font-size:16px;">
                                                            <span class="rb_menu_content_title">
                                                                Product
                                                                <span class="rb_arrow"></span> </span>
                                                        </a>
                                                        <span class="arrow closed"></span>
                                                        <ul class="rb_columns_ul" style=" width:100%; font-size:14px;">
                                                            <li class="rb_columns_li column_size_4  rb_has_sub">
                                                                <ul class="rb_blocks_ul">
                                                                    <li data-id-block="4" class="rb_blocks_li">

                                                                        <div class="rb_block rb_block_type_product ">
                                                                            <h4>Popular products</h4>
                                                                            <div class="rb_block_content">

                                                                                <article
                                                                                    class="product-miniature js-product-miniature">
                                                                                    <div class="thumbnail-container">

                                                                                        <a href=""
                                                                                            class="thumbnail product-thumbnail">
                                                                                            <img src="https://rubiktheme.com/demo/rb_evo_demo/101-home_default/hummingbird-printed-t-shirt.jpg"
                                                                                                alt="Harman Blue Sneakers"
                                                                                                data-full-size-image-url="https://rubiktheme.com/demo/rb_evo_demo/101-home_default/hummingbird-printed-t-shirt.jpg" />
                                                                                        </a>

                                                                                        <div
                                                                                            class="rb-product-description">

                                                                                            <h4 class="h3 product-title"
                                                                                                itemprop="name">
                                                                                                <a href="">
                                                                                                    Harman Blue Sneakers
                                                                                                </a>
                                                                                                <span
                                                                                                    class="product_combination">
                                                                                                    Size-S,
                                                                                                    Color-White</span>
                                                                                            </h4>



                                                                                            <div
                                                                                                class="product-price-and-shipping">

                                                                                                <span itemprop="price"
                                                                                                    class="price">$19.12</span>


                                                                                                <span
                                                                                                    class="regular-price">$23.90</span>
                                                                                                <span
                                                                                                    class="discount-percentage">-20%</span>



                                                                                            </div>

                                                                                        </div>

                                                                                        <ul class="product-flags">
                                                                                            <li class="discount">-20%
                                                                                            </li>
                                                                                        </ul>

                                                                                        <div
                                                                                            class="highlighted-informations no-variants hidden-sm-down">
                                                                                            <a href="#"
                                                                                                class="quick-view"
                                                                                                data-link-action="quickview">
                                                                                                <i
                                                                                                    class="material-icons search">&#xE8B6;</i>
                                                                                                Quick view
                                                                                            </a>



                                                                                        </div>


                                                                                    </div>
                                                                                </article>
                                                                            </div>
                                                                        </div>
                                                                        <div class="clearfix"></div>

                                                                    </li>
                                                                </ul>
                                                            </li>
                                                            <li class="rb_columns_li column_size_4  rb_has_sub">
                                                                <ul class="rb_blocks_ul">
                                                                    <li data-id-block="5" class="rb_blocks_li">

                                                                        <div class="rb_block rb_block_type_product ">
                                                                            <h4>Special products</h4>
                                                                            <div class="rb_block_content">

                                                                                <article
                                                                                    class="product-miniature js-product-miniature">
                                                                                    <div class="thumbnail-container">

                                                                                        <a href=""
                                                                                            class="thumbnail product-thumbnail">
                                                                                            <img src="https://rubiktheme.com/demo/rb_evo_demo/101-home_default/hummingbird-printed-t-shirt.jpg"
                                                                                                alt="Harman Blue Sneakers"
                                                                                                data-full-size-image-url="https://rubiktheme.com/demo/rb_evo_demo/101-home_default/hummingbird-printed-t-shirt.jpg" />
                                                                                        </a>

                                                                                        <div
                                                                                            class="rb-product-description">

                                                                                            <h4 class="h3 product-title"
                                                                                                itemprop="name">
                                                                                                <a href="">
                                                                                                    Harman Blue Sneakers
                                                                                                </a>
                                                                                                <span
                                                                                                    class="product_combination">
                                                                                                    Size-S,
                                                                                                    Color-White</span>
                                                                                            </h4>



                                                                                            <div
                                                                                                class="product-price-and-shipping">

                                                                                                <span itemprop="price"
                                                                                                    class="price">$19.12</span>


                                                                                                <span
                                                                                                    class="regular-price">$23.90</span>
                                                                                                <span
                                                                                                    class="discount-percentage">-20%</span>



                                                                                            </div>

                                                                                        </div>

                                                                                        <ul class="product-flags">
                                                                                            <li class="discount">-20%
                                                                                            </li>
                                                                                        </ul>

                                                                                        <div
                                                                                            class="highlighted-informations no-variants hidden-sm-down">
                                                                                            <a href="#"
                                                                                                class="quick-view"
                                                                                                data-link-action="quickview">
                                                                                                <i
                                                                                                    class="material-icons search">&#xE8B6;</i>
                                                                                                Quick view
                                                                                            </a>



                                                                                        </div>


                                                                                    </div>
                                                                                </article>

                                                                            </div>
                                                                        </div>
                                                                        <div class="clearfix"></div>

                                                                    </li>
                                                                </ul>
                                                            </li>

                                                            <li class="rb_columns_li column_size_4  rb_has_sub">
                                                                <ul class="rb_blocks_ul">
                                                                    <li data-id-block="5" class="rb_blocks_li">

                                                                        <div class="rb_block rb_block_type_product ">
                                                                            <h4>Special products</h4>
                                                                            <div class="rb_block_content">

                                                                                <article
                                                                                    class="product-miniature js-product-miniature">
                                                                                    <div class="thumbnail-container">

                                                                                        <a href=""
                                                                                            class="thumbnail product-thumbnail">
                                                                                            <img src="https://rubiktheme.com/demo/rb_evo_demo/101-home_default/hummingbird-printed-t-shirt.jpg"
                                                                                                alt="Harman Blue Sneakers"
                                                                                                data-full-size-image-url="https://rubiktheme.com/demo/rb_evo_demo/101-home_default/hummingbird-printed-t-shirt.jpg" />
                                                                                        </a>

                                                                                        <div
                                                                                            class="rb-product-description">

                                                                                            <h4 class="h3 product-title"
                                                                                                itemprop="name">
                                                                                                <a href="">
                                                                                                    Harman Blue
                                                                                                    Sneakers
                                                                                                </a>
                                                                                                <span
                                                                                                    class="product_combination">
                                                                                                    Size-S,
                                                                                                    Color-White</span>
                                                                                            </h4>



                                                                                            <div
                                                                                                class="product-price-and-shipping">

                                                                                                <span itemprop="price"
                                                                                                    class="price">$19.12</span>


                                                                                                <span
                                                                                                    class="regular-price">$23.90</span>
                                                                                                <span
                                                                                                    class="discount-percentage">-20%</span>



                                                                                            </div>

                                                                                        </div>

                                                                                        <ul class="product-flags">
                                                                                            <li class="discount">
                                                                                                -20%</li>
                                                                                        </ul>

                                                                                        <div
                                                                                            class="highlighted-informations no-variants hidden-sm-down">
                                                                                            <a href="#"
                                                                                                class="quick-view"
                                                                                                data-link-action="quickview">
                                                                                                <i
                                                                                                    class="material-icons search">&#xE8B6;</i>
                                                                                                Quick view
                                                                                            </a>



                                                                                        </div>


                                                                                    </div>
                                                                                </article>

                                                                            </div>
                                                                        </div>
                                                                        <div class="clearfix"></div>

                                                                    </li>
                                                                </ul>
                                                            </li>

                                                        </ul>

                                                    </li> -->
                            <!--                                                     
                        <li class="rb_menus_li rb_sub_align_left rb_has_sub">
                            <a href="" style="font-size:16px;">
                                <span class="rb_menu_content_title">
                                    Page
                                    <span class="rb_arrow"></span> </span>
                            </a>
                            <span class="arrow closed"></span>
                            <ul class="rb_columns_ul" style=" width:230px; font-size:14px;">
                                <li class="rb_columns_li column_size_12  rb_has_sub">
                                    <ul class="rb_blocks_ul">
                                        <li data-id-block="2" class="rb_blocks_li">

                                            <div
                                                class="rb_block rb_block_type_cms rb_hide_title">
                                                <h4>Page</h4>
                                                <div class="rb_block_content">
                                                    <ul>
                                                        <li><a href="">About
                                                                us</a></li>

                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>

                                        </li>
                                    </ul>
                                </li>
                            </ul>

                        </li>
                        <li class="rb_menus_li rb_sub_align_full">
                            <a href="" style="font-size:16px;">
                                <span class="rb_menu_content_title">
                                    Contact
                                </span>
                            </a>

                        </li> -->
                                                </ul>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-6 header-center ">
                                <div class="rbLogo">
                                    <a href="<?= FRONT_SITE_PATH ?>index">
                                        <img class="logo img-fluid" src="logo.png" alt="PS Fashion Store">
                                    </a>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-3 col-xs-3 header-right">
                                <div id="search-widget" class="search-widget popup-over">
                                    <a id="click_show_search" href="javascript:void(0)" data-toggle="dropdown"
                                        class="float-xs-right popup-title">
                                        <i class="icon-Ico_Search"></i>
                                    </a>
                                    <div class="rb-search-name popup-content">
                                        <div class="container">
                                            <div class="search-top">
                                                <h2>what are you looking for?</h2>
                                                <div class="close-search">close<i class="icon_close"></i></div>
                                            </div>
                                            <div class="search-box">
                                                <div class="rb-search-widget">
                                                    <form method="post" action="">
                                                        <input type="text" name="Search_Product_mb" placeholder="Search"
                                                            class="rb-search" autocomplete="off" id="Search_Product_mb">
                                                        <button class="rb-search-btn" type="submit">
                                                            <i class="icon_search"></i>
                                                            <span class="hidden-xl-down">Search</span>
                                                        </button>
                                                        <div class="cssload-container rb-ajax-loading">
                                                            <div class="cssload-double-torus"></div>
                                                        </div>
                                                    </form>
                                                </div>

                                                <div class="resuilt-search">
                                                    <div class="rb-resuilt" id="Product_Getted_From_DB"></div>
                                                </div>
                                                <p class="rb-resuilt-error" id="notfoundproducterror" style="position: absolute;top: 181px;z-index: 99999;"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="header-mobile-fixed">
                        <div class="shop-page">
                            <a href="<?= FRONT_SITE_PATH.'shop' ?>">
                                <i class="icon-store"></i>
                            </a>
                        </div>
                        <div class="my-account">
                            <!-- TPL LOGIN -->
                            <div id="rb-login" class="rb-login popup-over">
                                <a href="javascript:void(0)" title="Login" class="align-items-center popup-title">
                                    <?php
                                    if(isset($_SESSION['UID']) && $_SESSION['UID'] > 0){
                                        if ($user['user_img'] != '') {
                                            $user_img = USER_PROFILE.$user['user_img'];
                                        }else {
                                            $user_img = 'https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png';
                                        }
                                        ?>
                                    <img  id="header_bottom_mobile_image" src="<?= $user_img ?>" class="img-fluid"
                                        style='width:40px;border-radius:50%' alt="">
                                    <?php
                                    }else{
                                        ?>
                                    <i class="icon-Ico_User"></i>
                                    <span class="rb-login-title">Login or Register</span>
                                    <?php
                                    }
                                        
                                            ?>
                                </a>

                                <div class="bg-over-lay"></div>
                                <div
                                    class="rb-dropdown rb-login-form rb-form-container dd-container dd-products dd-view popup-content">
                                    <!-- <div class="close-popup"><i class="icon_close"></i></div> -->
                                    <div class="close-menubar">
                                        <span id="click_off"></span>
                                    </div>

                                    <!-- When User Not Login  -->

                                    <?php

                                                if(isset($_SESSION['UID']) && $_SESSION['UID'] > 0){
                                                    if ($user['user_img'] != '') {
                                                        $user_img = USER_PROFILE.$user['user_img'];
                                                    }else {
                                                        $user_img = 'https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png';
                                                    }
                                                    ?>
                                    <!-- When User Login  -->
                                    <div class="indent rb-indent">
                                        <div class="my-info">
                                            <a class="rb-icon-account" href="" title="View My Account" rel="nofollow">
                                                <img src="<?= $user_img ?>" class='img-fluid'
                                                    style="width: 100px;height: 100px;border-radius: 50%;">
                                            </a>
                                            <a class="rb-account" href="" title="View My Account" rel="nofollow">
                                                <span>Hi <?= $user['firstname'].' '.$user['lastname'] ?></span>
                                            </a>
                                            <a class="rb-logout" href="<?= FRONT_SITE_PATH.'logout' ?>" rel="nofollow">
                                                <span>Sign out</span>
                                            </a>
                                        </div>
                                        <a id="identity-link" href="<?= FRONT_SITE_PATH.'identity' ?>">
                                            <span class="link-item">
                                                <i class="fa fa-user"></i>
                                                Information
                                            </span>
                                        </a>
                                        <a id="identity-link" href="<?= FRONT_SITE_PATH.'wallet' ?>">
                                            <span class="link-item">
                                                <i class="fa fa-briefcase"></i>
                                                <?= CASH_LABEL_NAME ?>
                                            </span>
                                            <span class="float-right">
                                                <?php
                                                    $FetchUserWalletAmt = FetchUserWalletAmt($user['id']);
                                                    echo "₹".$FetchUserWalletAmt['Total_WalletAmt'];
                                                ?>
                                            </span>
                                        </a>
                                        <a id="addresses-link" href="<?= FRONT_SITE_PATH.'addresses' ?>">
                                            <span class="link-item">
                                                <i class="fa fa-map-marker"></i>
                                                Addresses
                                            </span>
                                        </a>
                                        <a id="history-link" href="<?= FRONT_SITE_PATH.'order-history' ?>">
                                            <span class="link-item">
                                                <i class="fa fa-calendar"></i>
                                                Order history and details
                                            </span>
                                        </a>
                                        <a id="identity-link" href="<?= FRONT_SITE_PATH.'shoutnearn' ?>">
                                            <span class="link-item">
                                                <i class="fa fa-user"></i>
                                                Invite & Earn upto ₹ <?= GETSIGNEDUPBONUS ?>
                                            </span>
                                        </a>
                                        <!-- TPL LOGIN -->
                                        <!-- End -->

                                        <!-- TPL wishlist -->
                                        <div class="rb-id-wishlist">
                                            <a href="<?= FRONT_SITE_PATH.'wishlist'?>">
                                                <span class="rb-header-item">
                                                    <i class="fa fa-heart"></i>
                                                    <span class="title">Wishlist</span>
                                                    <span class="rb-wishlist-quantity rb-amount-inline"><?= count(WishlistData($user['id'])) ?></span>
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                    <?php } else {
                                                ?>
                                    <div class="indent rb-indent">
                                        <div class="title-wrap flex-container">
                                            <h4 class="customer-form-tab login-tab active">
                                                <span>Sign In</span>
                                            </h4>

                                            <h4 class="customer-form-tab register-tab">
                                                <span>Register</span>
                                            </h4>
                                        </div>

                                        <div class="form-wrap">
                                            <form class="rb-customer-form active rb-form-login" action=""
                                                id="SignSubmit_Phone" method="post">
                                                <div class="relative form-group">
                                                    <div class="icon-true">
                                                        <input class="form-control" name="email" type="email" value=""
                                                            placeholder="Email" required="">
                                                        <i class="material-icons">email</i>
                                                    </div>
                                                </div>
                                                <div class="relative form-group">
                                                    <div class="input-group-dis js-parent-focus">
                                                        <div class="icon-true relative">
                                                            <input
                                                                class="form-control js-child-focus js-visible-password"
                                                                name="password" type="password" value=""
                                                                placeholder="Password" required="">
                                                            <i class="material-icons">vpn_key</i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="login-submit">
                                                    <input type="hidden" name="submitLogin" value="1">
                                                    <button class="btn btn-primary login-button"
                                                        data-link-action="sign-in" type="submit">
                                                        Sign In
                                                    </button>

                                                </div>

                                                <a href="<?= FRONT_SITE_PATH.'password_recovery' ?>" rel="nofollow">
                                                    Forgot your password?
                                                </a>

                                                <div class="error_place"></div>
                                            </form>

                                            <form action="" id="SignUp_Phone" class="rb-customer-form rb-form-register"
                                                method="POST">

                                                <input type="hidden" value='<?= $url ?>' name="page_url">
                                                <div class="form-group relative">
                                                    <label class="radio-inline">
                                                        <span class="custom-radio">
                                                            <input name="id_gender" type="radio" value="Mr" required=''>
                                                            <span></span>
                                                        </span>
                                                        Mr</label>


                                                    <label class="radio-inline">
                                                        <span class="custom-radio">
                                                            <input name="id_gender" type="radio" value="Mrs"
                                                                required=''>
                                                            <span></span>
                                                        </span>
                                                        Mrs</label>
                                                </div>

                                                <div class="form-group relative">
                                                    <div class="icon-true">
                                                        <input class="form-control" name="email_signup" type="email"
                                                            value="" placeholder="Email" required="">
                                                        <i class="material-icons">email</i>
                                                    </div>
                                                </div>

                                                <div class="form-group relative">
                                                    <div class="input-group-dis js-parent-focus">
                                                        <div class="icon-true relative">
                                                            <input class="form-control" name="password_signup"
                                                                placeholder="Password" type="password" value=""
                                                                required="" pattern=".{5,}">
                                                            <i class="material-icons">vpn_key</i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group relative">
                                                    <div class="icon-true">
                                                        <input class="form-control" name="firstname" type="text"
                                                            value="" placeholder="First Name" required="">
                                                        <i class="material-icons">&#xE7FF;</i>
                                                    </div>
                                                </div>
                                                <div class="form-group relative">
                                                    <div class="icon-true">
                                                        <input class="form-control" name="lastname" type="text" value=""
                                                            placeholder="Last Name" required="">
                                                        <span class="focus-border"><i></i></span>
                                                        <svg class="svgic input-icon">
                                                            <use xlink:href="#si-account"></use>
                                                        </svg>
                                                    </div>
                                                </div>

                                                <div class="form-group relative">
                                                    <div class="icon-true">
                                                        <?php 
                                                            if (isset($_GET['referCode']) && $_GET['referCode'] != '' && isset($_GET['UserId']) && $_GET['UserId'] > 0) {
                                                                $referralCodeIs = get_safe_value($_GET['referCode']);
                                                                $referralCodeUserId = get_safe_value($_GET['UserId']);
                                                            }else{
                                                                $referralCodeIs = '';
                                                                $referralCodeUserId = '';
                                                            }

                                                        ?>
                                                        <input class="form-control" name="referral_code" type="text"
                                                            value="<?= $referralCodeIs ?>" placeholder="Enter Referral Code" >
                                                        <input type="hidden" name="UserId" value="<?= $referralCodeUserId ?>">
                                                        <span class="focus-border"><i></i></span>
                                                        <svg class="svgic input-icon">
                                                            <use xlink:href="#si-account"></use>
                                                        </svg>
                                                    </div>
                                                </div>
                                                
                                                <div class="relative form-group rb-check-box">
                                                    <input class="form-control" name="newsletter" id="newsletter1"
                                                        type="checkbox" value="1">
                                                    <label for="newsletter1">
                                                        Sign up for our newsletter
                                                    </label>
                                                </div>
                                                <button class="btn btn-primary form-control-submit register-button"
                                                    type="submit">
                                                    Register
                                                </button>

                                                <div class="error_place_register">
                                                </div>
                                            </form>
                                        </div>
                                        <!-- TPL LOGIN -->

                                        <!-- TPL wishlist -->

                                        <!-- TPL LOGIN -->
                                        <!-- End -->

                                        <!-- End -->

                                        <!-- TPL wishlist -->
                                        <div class="rb-id-wishlist">
                                            <a href="<?= FRONT_SITE_PATH.'wishlist'?>">
                                                <span class="rb-header-item">
                                                    <i class="fa fa-heart"></i>
                                                    <span class="title">Wishlist</span>
                                                    <span class="rb-wishlist-quantity rb-amount-inline"><?= count(WishlistData($user['id'])) ?></span>
                                                </span>
                                            </a>
                                        </div>

                                    </div>
                                    <?php
                                            } ?>



                                </div>
                            </div>
                            <!-- End -->

                            <!-- End -->

                            <!-- TPL wishlist -->

                        </div>
                        <div class="home-index">
                            <a href="<?= FRONT_SITE_PATH ?>">
                                <i class="icon-house"></i>
                            </a>
                        </div>
                        <div class="wishlist-box">
                            <!-- TPL wishlist -->
                            <div class="rb-id-wishlist">
                                <a href="<?= FRONT_SITE_PATH.'wishlist'?>">
                                    <span class="rb-header-item">
                                        <i class="fa fa-heart"></i>
                                        <span class="title">Wishlist</span>
                                        <span class="rb-wishlist-quantity rb-amount-inline"><?= count(WishlistData($user['id'])) ?></span>
                                    </span>
                                </a>
                            </div>

                        </div>
                        <div class="my-cart">
                            <div id="blockcart" class="blockcart cart-preview">
                                <a id="cart-toogle" class="cart-toogle header-btn header-cart-btn"
                                    href="javascript:void(0)" data-toggle="dropdown" data-display="static">
                                    <i class="icon-Ico_Cart" aria-hidden="true"><span
                                            class="cart-products-count-btn"><?= $getCartTotal ?></span></i>
                                    <span class="info-wrapper">
                                        <span class="title">Cart</span>
                                        <span class="cart-toggle-details">
                                            <span class="text-faded cart-separator"> / </span>
                                            Empty
                                        </span>
                                    </span>
                                </a>
                                <div id="_desktop_blockcart-content" class="dropdown-menu-custom dropdown-menu">
                                    <div id="blockcart-content" class="blockcart-content">
                                        <div class="cart-title">
                                            <button type="button" id="js-cart-close" class="close">
                                                <span>×</span>
                                            </button>
                                            <span class="modal-title">Your cart</span>
                                        </div>
                                        <!-- When No itms in Cart  -->
                                        <span class="no-items" style="display: none;">There are no more items in your
                                            cart</span>

                                        <!-- When Cart is not Empty  -->
                                        <ul class="cart-products">
                                            
                                        </ul>

                                        <div class="cart-subtotals">
                                            <p class="cart-products-count"></p>
                                            <div class="products clearfix">
                                                <span class="label">Subtotal</span>
                                                <span class="price-total value float-right"></span>
                                            </div>
                                        </div>
                                        <div class="cart-buttons text-center">
                                            <a rel="nofollow" class="btn btn-secondary btn-block" href="<?= FRONT_SITE_PATH.'cart' ?>">Cart</a>
                                            <a href="<?= FRONT_SITE_PATH.'checkout' ?>" class="btn btn-primary btn-block btn-lg">Checkout</a>

                                        </div>

                                    </div>
                                </div>
                                <div class="bg-over-lay"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </header>


        <!-- <aside id="notifications">
            <div class="alert alert-primary" style="<?= $visibility_ele ?>;color: #004085;background-color: #cce5ff;text-align:center">
                <div class="row d-lg-flex justify-content-lg-center align-items-lg-center">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-2 p-0 text-lg-right text-center-sm">
                        <img width="80px" src="data:image/png;base64,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" alt="">             
                    </div>  
                    <div class="col-sm-4 d-flex align-items-center text-center-sm">
                        <h4 class="font-weight-bold text-muted" style="font-size:calc(0.8rem + 0.2vw)">
                            Invite friends to <?= SITE_NAME ?> & get up to ₹150 <?= CASH_LABEL_NAME ?> for every person who visits
                        </h4>
                    </div>
                    <div class="col-sm-2 d-flex justify-content-center align-items-center" >
                        <?php
                            if (isset($_SESSION['UID'])) {
                                $invite_now_link = FRONT_SITE_PATH.'shoutnearn';
                                $invite_nowID = '';
                            }else{
                                $invite_now_link = 'javascript:void(0)';
                                $invite_nowID = 'InviteNowNoLogin';
                            }
                        ?>
                        <a href="<?= $invite_now_link ?>" id = "<?= $invite_nowID ?>" style="font-size:calc(0.8rem + 0.2vw)">
                        <button class="btn btn-outline-danger text-lg-left text-center-sm">Invite Now <i class="fa fa-angle-right"></i></button>
                        </a>
                    </div>
                    <div class="col-sm-3"></div>
                </div>
            </div>
        </aside> -->

    