<?php
    require 'session.php';
    
    $menu_open= '';
    $active = '';

    $page_url =  'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
    if ($page_url == ADMIN_FRONT_SITE || $page_url == ADMIN_FRONT_SITE.'index.php') {
      $title = SITE_NAME.' - Dashboard';
      $active = 'active';

    }
    else if ($page_url == ADMIN_FRONT_SITE.'products.php') {
        $title = SITE_NAME.' - Prodcts';
        $catalog_active = 'active';
        $product_active = 'active';
        $menu_open = 'menu-open';
    }
    else if ($page_url == ADMIN_FRONT_SITE.'brand.php') {
        $title = SITE_NAME.' - Brand';
        $brand_active = 'active';
        $catalog_active = 'active';
        $menu_open = 'menu-open';
    }
    else if ($page_url == ADMIN_FRONT_SITE.'category.php') {
        $title = SITE_NAME.' - Category';
        $catalog_active = 'active';
        $category_active = 'active';
        $menu_open = 'menu-open';
    }
    else if ($page_url == ADMIN_FRONT_SITE.'subcategory.php') {
        $title = SITE_NAME.' - Sub Category';
        $catalog_active = 'active';
        $subcategory_active = 'active';
        $menu_open = 'menu-open';
    }
    else if ($page_url == ADMIN_FRONT_SITE.'users.php' || $page_url = ADMIN_FRONT_SITE.'cart.php') {
        $title = SITE_NAME.' - Users';
        $catalog_active = 'active';
        $users_active = 'active';
        $menu_open = 'menu-open';
    }

    else if ($page_url == ADMIN_FRONT_SITE.'orders.php') {
        $title = SITE_NAME.' - Orders';
        $order_active = 'active';
    }

    if(!isset($_SESSION['ADMIN_ID'])) redirect(ADMIN_FRONT_SITE.'login');
    $base_url = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 'https' : 'http' ) . '://' .  $_SERVER['HTTP_HOST'];
    $url = $base_url . $_SERVER["REQUEST_URI"];
    
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <link rel="shortcut icon" href="<?= FRONT_SITE_PATH.'logo.png' ?>" type="image/x-icon">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://adminlte.io/themes/v3/dist/css/adminlte.min.css">]
    <!-- ion icon CDN  -->
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- summernote -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.css" integrity="sha512-ngQ4IGzHQ3s/Hh8kMyG4FC74wzitukRMIcTOoKT3EyzFZCILOPF0twiXOQn75eDINUfKBYmzYn2AA8DkAk8veQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- DataTables -->
  <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/icheck-bootstrap/icheck-bootstrap.min.css">

  <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

  <link rel="stylesheet" href="https://www.jqueryscript.net/demo/Bootstrap-4-Tag-Input-Plugin-jQuery/tagsinput.css">

  <!-- For Dropzone Csss  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.css" />
<!-- Dropzone JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.js"></script>

    
    <!-- custom internal css includes  -->
    <style>
        .dark-mode .navbar-dark{
            background-color: #283046;
            border-color: #283046;
        }
        body.dark-mode, .dark-mode .content-wrapper{
            background-color : #161d31!important;
        }
        .layout-navbar-fixed .wrapper .sidebar-dark-primary .brand-link:not([class*=navbar]){
            background-color: #283046;
            border-bottom  : 1px solid #161d31;
        }

        [class*=sidebar-dark] .user-panel{
            border-bottom  : 1px solid #161d31;
            
        }

        .layout-fixed .main-sidebar, .dark-mode .btn-app, .dark-mode .btn-default{
            background:#283046  
        }
        
        [class*=sidebar-dark] .btn-sidebar, [class*=sidebar-dark] .form-control-sidebar, .dark-mode .list-group-item {
            background-color: #161d31;
        }
        [class*=sidebar-dark] .btn-sidebar:hover, .note-editor.note-airframe .note-editing-area, .note-editor.note-frame .note-editing-area, .note-editor.note-airframe .note-editing-area .note-codable, .note-editor.note-frame .note-editing-area .note-codable{
            background-color: #161d31;
        }
        .dark-mode .main-footer{
            background-color: #161d31;
            border-color: #283046
        }

        .card_box{
            background:#283046;
        }
        .dark-mode .custom-control-label::before, .dark-mode .custom-file-label, .dark-mode .custom-file-label::after, .dark-mode .custom-select, .dark-mode .form-control:not(.form-control-navbar):not(.form-control-sidebar), .dark-mode .input-group-text{
            background:#283046;
            border:none
        }

        .dark-mode .btn-secondary {
            background-color: #161d31 !important;
            border: none;
        }
       

        .dark-mode .dropdown-menu,

        .dark-mode .page-item:not(.active) .page-link,
        .dark-mode .dropdown-item:hover,
        .dark-mode .page-item.disabled .page-link,
        .dark-mode .page-item.disabled a,
        .select2-container--default .select2-selection--multiple,
        .select2-container--default .select2-results>.select2-results__options,
        .bootstrap-tagsinput,
        .dropzone {
            background-color: #161d31 !important;
            border: none;
        }

        .bootstrap-tagsinput {
            line-height : 27px;
        }

        .bootstrap-tagsinput .badge{
            margin-top: 10px;
        }
        
        .dark-mode a:not(.btn):hover,
        .bootstrap-tagsinput input {
            color: #fff;
        }

        .dark-mode .dropdown-item:focus,
        .dropdown-item.active,
        .select2-container--default .select2-selection--multiple .select2-selection__choice,
        .dark-mode .select2-results__option[aria-selected=true] {
            background-color: #283046;
        }

        .form-control,
        .dark-mode .select2-dropdown {
            background-color: #161d31 !important;
        }

        .select2-container--default .select2-selection--single {
            height: 36px;
            border: none;
            background-color: #161d31;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #fff;
        }

        .bootstrap-tagsinput .badge {
            background-color: #283046;
            border: 1px solid #283046;
        }

        .dropzone .dz-preview.dz-image-preview {
            background: none;
        }
    </style>
</head>

<body class="dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="javascript:void(0)" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= ADMIN_FRONT_SITE.'logout.php' ?>">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="<?= ADMIN_FRONT_SITE ?>" class="brand-link">
                <img src="<?= FRONT_SITE_PATH.'logo.png' ?>" alt="<?= SITE_NAME ?>"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light"><?= SITE_NAME ?></span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?= $adminImg ?>" class="img-circle elevation-2"
                            alt="<?= $adminData['admin_full_name'] ?>">
                    </div>
                    <div class="info">
                        <a href="javacript:void(0)" class="d-block"><?= $adminData['admin_full_name'] ?></a>
                    </div>
                </div>

                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-4">
                    <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-flat" data-widget="treeview"
                        role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                        <li class="nav-item">
                            <a href="index" class="nav-link <?= $active ?>">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>

                         <li class="nav-item <?= $menu_open ?>">
                            <a href="javascript:void(0)" class="nav-link <?= $catalog_active ?>">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Catalog
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= urldecode('brand') ?>" class="nav-link <?=  $brand_active ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Brands</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= urldecode('category') ?>" class="nav-link <?=  $category_active ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Category</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= urldecode('subcategory') ?>" class="nav-link <?=  $subcategory_active ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Sub Category</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= urldecode('products') ?>" class="nav-link <?= $product_active ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Products</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= urldecode('users') ?>" class="nav-link <?= $users_active ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Users</p>
                                    </a>
                                </li>
                            </ul>
                        </li> 

                        <li class="nav-item">
                            <a href="orders" class="nav-link <?= $order_active ?>">
                                <i class="nav-icon fab fa-first-order"></i>
                                <p>
                                    Orders
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>