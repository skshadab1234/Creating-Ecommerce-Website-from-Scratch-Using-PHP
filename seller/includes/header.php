<?php
    require 'includes/session.php';
    $active = '';
    $active1 = '';
    $title ='Seller Dashboard';
    $page_url =  'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
    if ($page_url == SELLER_FRONT_SITE.'ProductListing.php') {
      $active_menu = 'active';
      
      if(isset(($_GET['action'])) && $_GET['action'] == 'viewListing'){
        $title ='View Product List';
        $active = 'active';
      } 
      else if(isset(($_GET['action'])) && $_GET['action'] == 'addNewListing'){
        $title ='Add new Listing';
        $active1 = 'active';
      }else{
        $title = 'Listing in Progress';
        $active_lip = 'active';
      }
    }elseif ($page_url == SELLER_FRONT_SITE.'ApplyforBrand.php') {
        $track_approval_req = 'active';
        $active_menu = 'active';
        $title = 'Track Approval Requests';
        if(isset($_GET['brandid']) && $_GET['brandid'] != '') {
            $title = 'Applying for Brand Approval';
        }
    }elseif ($page_url == SELLER_FRONT_SITE.'brands.php') {
        $active_menu_brand = 'active';
      
        if(isset(($_GET['action'])) && $_GET['action'] == 'viewBrandListing'){
          $title ='View Brand List';
          $active_brand = 'active';
        }else if(isset(($_GET['action'])) && $_GET['action'] == 'addNewBrandListing'){
            $title ='Add new Brand';
            $add_new_brand_active = 'active';
        } 
        else{
          $title = 'Approve Requested Brand';
          $active_brand_arb = 'active';
        }
    }
    else if ($page_url == SELLER_FRONT_SITE.'profile.php') {
        $title = $sell_row['seller_fullname'].'- Profile';
    }

    if (!isset($_SESSION['SELLER_ID'])) redirect(SELLER_FRONT_SITE.'logoutfromseller');
    $base_url = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 'https' : 'http' ) . '://' .  $_SERVER['HTTP_HOST'];
    $url = $base_url . $_SERVER["REQUEST_URI"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?></title>
    <link rel="shortcut icon" href="<?= FRONT_SITE_PATH.'logo.png' ?>" type="image/x-icon">
    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bank_cheeque.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css'>

    <!-- Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

    <!-- DataTables -->
    <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/datatables.mark.js/2.0.0/datatables.mark.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/plug-ins/1.10.13/features/mark.js/datatables.mark.min.css">    
    <link rel="stylesheet" href="https://cdn.datatables.net/searchbuilder/1.3.0/css/searchBuilder.dataTables.min.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    
    <!-- For Dropzone Csss  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.css" />
    
    <!-- Dropzone JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.js"></script>

    <!-- summernote -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.css" integrity="sha512-ngQ4IGzHQ3s/Hh8kMyG4FC74wzitukRMIcTOoKT3EyzFZCILOPF0twiXOQn75eDINUfKBYmzYn2AA8DkAk8veQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .select2-container--default .select2-selection--single, .select2-container--default .select2-selection--single .select2-selection__arrow{
            height: 40px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered{
            line-height: 40px;
        }

        .note-editor.note-airframe .note-editing-area .note-editable, .note-editor.note-frame .note-editing-area .note-editable{
            background: #fff;
        }
        .note-toolbar{
            background: #ddd;
        }
    </style>
</head>

<body style="background:#eee">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="<?= SELLER_FRONT_SITE ?>"><?= SITE_NAME ?><sup>seller</sup></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav  mr-auto">
                <!-- <li class="nav-item">
                    <a class="nav-link" href="#">Fee Structure</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Resources</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">FAQs</a>
                </li> -->
                <li class="nav-item dropdown <?= $active_menu ?>">
                    <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="navbarDropdownMenuLink" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        Listing
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        
                        <a class="dropdown-item <?= $active ?>" href="<?= SELLER_FRONT_SITE.'ProductListing?action=viewListing' ?>">My Listing</a>
                        <a class="dropdown-item <?= $active1 ?>" href="<?= SELLER_FRONT_SITE.'ProductListing?action=addNewListing' ?>">Add new Listing</a>
                        <a class="dropdown-item <?= $track_approval_req ?>" href="<?= SELLER_FRONT_SITE.'ApplyforBrand' ?>">Track Approval Requests</a>
                        <a class="dropdown-item <?= $active_lip ?>" href="<?= SELLER_FRONT_SITE.'ProductListing' ?>">QC Check Products</a>
                    </div>
                </li>

                <li class="nav-item dropdown <?= $active_menu_brand ?>">
                    <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="navbarDropdownMenuLink" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        Brands
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item <?= $active_brand ?>" href="<?= SELLER_FRONT_SITE.'brands?action=viewBrandListing' ?>">My Brands</a>
                        <a class="dropdown-item <?= $add_new_brand_active ?>" href="<?= SELLER_FRONT_SITE.'brands?action=addNewBrandListing' ?>">Add New Brands</a>
                        <a class="dropdown-item <?= $active_brand_arb ?>" href="<?= SELLER_FRONT_SITE.'brands' ?>">Approve Requested Brands</a>
                    </div>
                </li>   
            </ul>
            <ul class='navbar-nav'>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <?= $sell_row['seller_email'] ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="<?= SELLER_FRONT_SITE.'logoutfromseller' ?>">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>