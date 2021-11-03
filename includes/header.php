<!-- Home/address/cart/identity/o-confirm/o-history id="module-rbthemedream-live" -->
<!-- Product id="product" -->
<!-- Chckout id="checkout" -->

<?php

require 'session.php';

$getCartTotal = getCartTotal();


if (isset($_SESSION['UID'])) {
    # code...
}else{
    
}
$page_url =  'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

$body_name = 'product';

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
            $title = 'Detals';  
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

    <link rel="stylesheet" href="https://rubiktheme.com/demo/rb_evo_demo/themes/rb_evo/assets/cache/theme-3b594a31.css"
        type="text/css" media="all">

    <link rel="stylesheet" href="<?= FRONT_SITE_PATH ?>style/HomePage.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


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
    var text1 = "No Product";
    var text2 = "You Can Not Delete Default Wishlist";
    var token = "9e645ea2b011b9302f90d49f848c7122";
    var url_ajax = "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/module\/rbthemefunction\/ajax";
    var url_compare = "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/compare";
    var url_wishlist = "https:\/\/rubiktheme.com\/demo\/rb_evo_demo\/en\/wishlist";
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
                                                        <li class="rb_menus_li rb_sub_align_full rb_has_sub">
                                                            <a href="" style="font-size:16px;">
                                                                <span class="rb_menu_content_title">
                                                                    Product
                                                                    <span class="rb_arrow"></span> </span>
                                                            </a>
                                                            <span class="arrow closed"></span>
                                                            <ul class="rb_columns_ul"
                                                                style=" width:100%; font-size:14px;">
                                                                <li class="rb_columns_li column_size_4  rb_has_sub">
                                                                    <ul class="rb_blocks_ul">
                                                                        <li data-id-block="4" class="rb_blocks_li">

                                                                            <div
                                                                                class="rb_block rb_block_type_product ">
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
                                                        <li class="rb_menus_li rb_sub_align_full">
                                                            <a href="" style="font-size:16px;">
                                                                <span class="rb_menu_content_title">
                                                                    Blog
                                                                </span>
                                                            </a>

                                                        </li>
                                                        <li class="rb_menus_li rb_sub_align_left rb_has_sub">
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

                                                        </li>
                                                        <li class="rb_menus_li rb_sub_align_full">
                                                            <a href="" style="font-size:16px;">
                                                                <span class="rb_menu_content_title">
                                                                    Contact
                                                                </span>
                                                            </a>

                                                        </li>
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
                                                            <input type="text" name="s" placeholder="Search"
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
                                                        <div class="rb-resuilt"></div>
                                                    </div>
                                                    <p class="rb-resuilt-error"></p>
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
                                            <img src="<?= $user_img ?>" class="img-fluid"
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
                                                    if ($user['user_img'] != '') {
                                                        $user_img = USER_PROFILE.$user['user_img'];
                                                    }else {
                                                        $user_img = 'https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png';
                                                    }
                                                    ?>
                                            <!-- When User Login  -->
                                            <div class="indent rb-indent">
                                                <div class="my-info">
                                                    <a class="rb-icon-account" href="" title="View My Account"
                                                        rel="nofollow">
                                                        <img src="<?= $user_img ?>"
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
                                <div class="rb_megamenu 
      layout_layout1 
       show_icon_in_mobile 
        
      transition_fade   
      transition_floating 
               
      rb-dir-ltr        hook-default        single_layout         disable_sticky_mobile         "
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

                                                    <li class="rb_menus_li rb_sub_align_full rb_has_sub">
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

                                                    </li>
                                                    <li class="rb_menus_li rb_sub_align_full">
                                                        <a href="" style="font-size:16px;">
                                                            <span class="rb_menu_content_title">
                                                                Blog
                                                            </span>
                                                        </a>

                                                    </li>
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

                                                    </li>
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
                                                    <form method="get" action="">
                                                        <input type="text" name="s" placeholder="Search"
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
                                                    <div class="rb-resuilt"></div>
                                                </div>
                                                <p class="rb-resuilt-error"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="header-mobile-fixed">
                        <div class="shop-page">
                            <a href="/">
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
                                    <img src="<?= $user_img ?>" class="img-fluid"
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

                                        <!-- TPL LOGIN -->
                                        <!-- End -->

                                        <!-- TPL wishlist -->
                                        <div class="rb-id-wishlist">
                                            <a href="">
                                                <span class="rb-header-item">
                                                    <i class="fa fa-heart"></i>
                                                    <span class="title">Wishlist</span>
                                                    <span class="rb-wishlist-quantity rb-amount-inline">0</span>
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
                                            <a href="">
                                                <span class="rb-header-item">
                                                    <i class="fa fa-heart"></i>
                                                    <span class="title">Wishlist</span>
                                                    <span class="rb-wishlist-quantity rb-amount-inline">0</span>
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
                            <a href="">
                                <i class="icon-house"></i>
                            </a>
                        </div>
                        <div class="wishlist-box">
                            <!-- TPL wishlist -->
                            <div class="rb-id-wishlist">
                                <a href="">
                                    <span class="rb-header-item">
                                        <i class="fa fa-heart"></i>
                                        <span class="title">Wishlist</span>
                                        <span class="rb-wishlist-quantity rb-amount-inline">0</span>
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


        <aside id="notifications">
            <div class="container">



            </div>
        </aside>