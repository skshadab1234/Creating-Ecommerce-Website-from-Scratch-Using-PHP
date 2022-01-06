<?php
    include 'includes/header.php';
    if (isset($_GET['action']) && $_GET['action'] == 'viewListing') {
        ?>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SELLER_FRONT_SITE ?>">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">View Listing</li>
            </ol>
        </nav>

        <div class="container-fluid mt-3 c">
            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4 card p-2">
                <div class="row">
                    <div class="col-sm-12">

                        <table id="example1"
                            class="table table-bordered table-striped dataTable dtr-inline"
                            role="grid" aria-describedby="example1_info">
                            <thead>
                                <tr role="row">
                                    <th>IMAGE</th>
                                    <th>NAME</th>
                                    <th>SELLING PRICE</th>
                                    <th>UNIT PRICE</th>
                                    <th>PRODUCT BRAND</th>
                                    <th>Instock</th>
                                    <th>PRODUCT SIZE</th>
                                    <th>CATEGORIES</th>
                                    <th>STATUS</th>
                                    <th>ADDED ON</th>

                                </tr>
                            </thead>
                            <tbody id="product_listing_td">
                                <?php
                                    $ProductDetails = ProductDetails('left join shop_category on product_details.product_categories =  shop_category.cat_id left join brands on product_details.product_brand = brands.bid where selling_by='.$_SESSION['SELLER_ID'].'');
                                    foreach($ProductDetails as $key => $val) {
                                        $qc_status = explode(",",$val['qc_status']);
                                        $end_qc_status = end($qc_status);
                                        if($end_qc_status == 1) {
                                            $ProductImageById = ProductImageById($val['id'], 'limit 1');
                                            array_unshift($ProductImageById,"");
                                            unset($ProductImageById[0]);
                                            if ($val['total_stock'] -  $val['total_sold'] < 100) {
                                                $color = 'red';
                                                $total_stock_msg = 'Out of Stock';
                                            }else{
                                                $color = 'green';
                                                $total_stock_msg = "In Stock:- ".($val['total_stock'] -  $val['total_sold']);
                                            }

                                            if ($val['product_status'] == 0) {
                                                $text = 'Blocked';
                                                $bgColor = 'bg-danger';
                                            }else if ($val['product_status'] == 2) {
                                                $text = 'Draft';
                                                $bgColor = 'bg-warning';
                                            }else{
                                                $text = 'Active';
                                                $bgColor = 'bg-success text-white';
                                            }

                                            if ($val['product_subCat_Values'] != '') {
                                                $product_subCat_Values = ' - '.urldecode($val['product_subCat_Values']);
                                            }else{
                                                $product_subCat_Values = '';
                                            }
                                            ?>
                                            <tr class="odd" id="delete_box_<?= $val['id'] ?>">
                                                <td style=""><img class="img-reponsive img-fluid"
                                                        width="80px" height="80px"
                                                        style="border-radius:20%;width:60px;height:80px"
                                                        src="<?= FRONT_SITE_IMAGE_PRODUCT.$ProductImageById['1']['product_img'] ?>"
                                                        alt=""></td>
                                                <td style=""><a
                                                        href="<?= SELLER_FRONT_SITE.'ProductListing?action=addNewListing&id='.$val['id'].'' ?>"><?= $val['product_name'] ?></a>
                                                        <br>
                                                        SKU Id : <?= $val['sku_id'] ?>
                                                </td>
                                                <td>
                                                    <h5>₹ <?= $val['product_price'] ?></h5>
                                                </td>
                                                <td>
                                                    <h5>₹ <?= $val['product_oldPrice'] ?></h5>
                                                </td>
                                                <td><?= $val['brand_name'] ?></td>
                                                <td style="color: <?= $color ?>">
                                                    <?= $total_stock_msg ?></td>
                                                <td><?= $val['product_size'] ?></td>
                                                <td><?= $val['category_name'].' - '.urldecode($val['product_subCategories']).''.$product_subCat_Values ?>
                                                </td>
                                                <td><span class="btn <?= $bgColor ?>"><?= $text ?></span>
                                                </td>
                                                <td><?= date("d M,Y", strtotime($val['product_added_on'])) ?>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                    }
                                ?>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th>By Name</th>
                                    <th>By Selling Price</th>
                                    <th>By Unit Price</th>
                                    <th>By Brand</th>
                                    <th>By Stock</th>
                                    <th>By Size</th>
                                    <th>By Categories</th>
                                    <th>By Status</th>
                                    <th>By Added Date</th>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>
            </div>
        </div>
        
        <?php
    }else if(isset($_GET['action']) && $_GET['action'] == 'addNewListing') {
        $Category_data = ExecutedQuery("SELECT * FROM shop_category WHERE status = 1");
        $BRAND_DATA = ExecutedQuery("SELECT * FROM brands WHERE brand_status = 1");
        $ProductDetails = ProductDetails();
        $id = end($ProductDetails)['id'] + 1;
        $head_title = 'Add New Product';
        $product_name = '';
        $category = '';
        $product_subCategories = '';
        $product_brand = '';
        $total_stock = '';
        $product_size = '';
        $product_weight = '';
        $short_description = '';
        $long_decription = '';
        $product_price = '';
        $product_oldPrice = '';
        $product_waist = '';
        $product_hips = '';
        $product_tags = '';
        $prodid = '';
        $product_added_on ='';
        $product_status = '';
        $product_subCat_Values = '';
        $selling_by = $_SESSION['SELLER_ID'];
        $sku_id = '';

        $type = 'add';

        if(isset($_GET['id']) && $_GET['id'] > 0) {
            $id= get_safe_value($_GET['id']);
            $head_title = 'Edit Product';
            $ProductDetails = ProductDetails("where id = ".$id." && selling_by='".$_SESSION['SELLER_ID']."'");
            $type = 'update';
            if (empty($ProductDetails)) {
                redirect(SELLER_FRONT_SITE.'ProductListing?action=addNewListing');
            }else{
                $ProductDetails = $ProductDetails[0];
                $product_name = $ProductDetails['product_name'];
                $category = $ProductDetails['product_categories'];
                $product_subCategories = $ProductDetails['product_subCategories'];
                $product_subCat_Values = $ProductDetails['product_subCat_Values'];
                $product_brand = $ProductDetails['product_brand'];
                $total_stock = $ProductDetails['total_stock'];
                $product_size = $ProductDetails['product_size'];
                $product_weight = $ProductDetails['product_weight'];
                $short_description = $ProductDetails['product_desc_short'];
                $long_decription = $ProductDetails['product_desc_long'];
                $product_price = $ProductDetails['product_price'];
                $product_oldPrice = $ProductDetails['product_oldPrice'];
                $product_waist = $ProductDetails['product_waist'];
                $product_hips = $ProductDetails['product_hips'];
                $product_tags = $ProductDetails['product_tags'];
                $product_added_on = $ProductDetails['product_added_on'];
                $prodid = $ProductDetails['id'];
                $product_status = $ProductDetails['product_status'];
                $selling_by = $ProductDetails['selling_by'];
                $sku_id = $ProductDetails['sku_id'];
            }

        }
        ?>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bs-stepper/dist/css/bs-stepper.min.css">
            <!-- Tags Mask Input  -->
            <link rel="stylesheet" href="https://www.jqueryscript.net/demo/Bootstrap-4-Tag-Input-Plugin-jQuery/tagsinput.css">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= SELLER_FRONT_SITE ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $head_title ?></li>
                </ol>
            </nav>

            <div class="container-fluid">
                <h3><?= $head_title ?></h3>
                <hr>
                <div id="stepper1" class="bs-stepper card">
                    <div class="bs-stepper-header row" role="tablist">
                        <div class="step col-4 col-md-3" data-target="#test-l-1">
                            <button type="button" class="step-trigger" role="tab" id="stepper1trigger1" aria-controls="test-l-1">
                                <span class="bs-stepper-circle">1</span>
                                <span class="bs-stepper-label">Select Category</span>
                                <span class="bs-stepper-label" id="category_selected_bySeller"></span>
                            </button>
                        </div>
                        <div class="bs-stepper-line"></div>
                        <div class="step col-4 col-md-3" data-target="#test-l-2">
                            <button type="button" class="step-trigger" role="tab" id="stepper1trigger2" aria-controls="test-l-2">
                                <span class="bs-stepper-circle">2</span>
                                <span class="bs-stepper-label">Select Brand</span>
                                <span class="bs-stepper-label" id="brand_selected_bySeller"></span>
                            </button>
                        </div>
                        <div class="bs-stepper-line"></div>
                        <div class="step col-4 col-md-3" data-target="#test-l-3">
                            <button type="button" class="step-trigger" role="tab" id="stepper1trigger3" aria-controls="test-l-3">
                                <span class="bs-stepper-circle">3</span>
                                <span class="bs-stepper-label">Add Product Info</span>
                            </button>
                        </div>
                    </div>
                    <div class="bs-stepper-content">
                        <div id="test-l-1" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger1">
                            <div class="row p-2">
                                <div class="form-group col-md-6">
                                    <label>Category</label>
                                    <select id="category_select2" class="form-control" onchange="product_category_Change()">
                                        <option value="" disabled selected='selected'> Select a Category</option>
                                        <?php
                                            foreach($Category_data as $key => $val) {
                                                if ($category == '') {
                                                    $selected = '';
                                                }else{
                                                    if($val['cat_id'] == $category){
                                                        $selected = 'selected';
                                                    }else{
                                                        $selected = '';
                                                    }
                                                }
                                                
                                                ?>
                                        <option <?= $selected ?> value="<?= $val['cat_id'] ?>"><?= $val['category_name'] ?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Sub Category</label>
                                    <select id="subcategory_select2" class="form-control" onchange="product_subcategory_Change()">
                                        <option value=""  selected='' disabled> Select a Subcategory</option>
                                    </select>
                                    <input type="hidden" id="sub_cat_recive_from_Db" value="<?= $product_subCategories ?>">
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Sub Category Value</label>
                                    <select id="subcategoryvalues_select2" class="form-control" onchange="show_NextButton()">
                                        <option value=""  selected='selected' disabled> Select a Subcategory Value</option>
                                    </select>
                                    <input type="hidden" id="sub_catValue_recive_from_Db" value="<?= $product_subCat_Values ?>">
                                </div>

                            </div>
                            <div class="proceed_next ml-2">
                                <button class="btn btn-primary" onclick="stepper1.next()" id="select_brand_btn" disabled>Select Brand</button>
                            </div>        
                        </div>
                        <div id="test-l-2" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger2">
                            <div class="row">
                                <div class="col-12 col-md-6 border-right">
                                    <div class="p-2 mt-4">
                                        <h2 class="h5">Check for the Brand yow want to sell</h2>

                                        <div class="row mt-5">
                                            <div class="form-group col-md-12">
                                                <select id="brand_selection" class="form-control" style="width:100%" onchange="brandSelection()">
                                                    <option value="" disabled selected='selected'> Select a Brand</option>
                                                    <?php
                                                        foreach($BRAND_DATA as $key => $brand_val) {
                                                            if ($brand_val['bid'] == $product_brand) {
                                                                $check_brand = 'selected';
                                                            }else{
                                                                $check_brand = '';
                                                            }
                                                            ?>
                                                            <option <?= $check_brand ?> value="<?= $brand_val['brand_name'] ?>"><?= $brand_val['brand_name'] ?></option>
                                                            <?php
                                                        }
                                                    ?>
                                                </select>

                                                <a href="javascript:void(0)" onclick="stepper1.previous()">Change Category</a>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-12 col-md-6">
                                    <div class="text-center mt-5" id="response_for_brand_approval" style="height:200px">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="test-l-3" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger3">
                            <form action="" id="product_data_form">
                                <input type="hidden" name='product_opt' value="<?= $type ?>">
                                <input type="hidden" name='prodid' value="<?= $prodid ?>">
                                <input type="hidden" name='brand_data' id="brand_data" value="<?= $product_brand ?>">
                                <input type="hidden" name='brand_name' id="brand_name">
                                <input type="hidden" name='category' id="category" value="<?= $category ?>">
                                <input type="hidden" name='sub_category_data' id="sub_category_data" value="<?= $product_subCategories ?>">
                                <input type="hidden" name='sub_category_value' id="sub_category_value" value="<?= $product_subCat_Values ?>">
                                <input type="hidden" name='selling_by' id="selling_by" value="<?= $selling_by ?>">
                                <div class="card ">
                                    <div class="card-header row w-100">
                                        <h3 class="card-title h5 col-md-9">Add Basic information </h3>
                                        <div class="col-md-3">
                                            <button type="button" onclick="stepper1.previous()" class="btn btn-primary">Previous</button>
                                            <button type="submit" id="submit_data" class=" btn btn-primary float-right">Next</button>
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="product_name">Product Name</label>
                                                <input type="text" class="form-control" id="product_name" name="product_name"
                                                    placeholder="Enter Product Name" value="<?= $product_name ?>">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="product_size">Product Size</label>
                                                <input type="text" class="form-control" data-role="tagsinput"
                                                    value="<?= $product_size ?>" name="product_size">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="product_size">SKU ID</label>
                                                <input type="text" class="form-control"  value="<?= $sku_id ?>" name="sku_id" placeholder="Enter Unique SKU ID">
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label for="short_description">Short Description</label>
                                                <textarea id="summernote" name="short_description"
                                                    class="form-control"><?= $short_description ?></textarea>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label for="long_description">Long Description</label>
                                                <textarea id="long_decription" rows="10" name="long_description"
                                                    class="form-control"><?= $long_decription ?></textarea>
                                            </div>
                                        </div>

                                        <!-- /.row -->
                                    </div>
                                </div>

                                <div class="card_box card-default mt-3">
                                    <div class="card-header">
                                        <h3 class="card-title">Pricing</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="product_price">Product Price</label>
                                                <input type="text" class="form-control" name="product_price"
                                                    value="<?= $product_price ?>" placeholder="Enter Product Price">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="product_oldPrice">Product Old Price</label>
                                                <input type="text" class="form-control" name="product_oldPrice"
                                                    value="<?= $product_oldPrice ?>" placeholder="Enter Product Old Price">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="total_stock">Total Stock</label>
                                                <input type="text" class="form-control" name="total_stock" value="<?= $total_stock ?>"
                                                    placeholder="Enter Total Stock">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="product_weight">Product Weight</label>
                                                <input type="text" class="form-control" name="product_weight"
                                                    value="<?= $product_weight ?>" placeholder="Enter Product Weight">
                                            </div>
                                        </div>

                                        <!-- /.row -->
                                    </div>
                                </div>

                                <div class="card_box card-default mt-3">
                                    <div class="card-header">
                                        <h3 class="card-title">Product Data Sheet</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="row" id="cloneNodeDataSheet">
                                            <?php
                                                $ProductDataSheetById = ProductDataSheetById($id);
                                                if (empty($ProductDataSheetById)) {
                                                    $data_sheet_name = '';
                                                    $data_sheet_desc = '';
                                                }else{
                                                    $lastid = array();
                                                    foreach ($ProductDataSheetById as $key => $value) {
                                                        $data_sheet_name = $value['data_sheet_name'];
                                                        $data_sheet_desc = $value['data_sheet_desc'];
                                                        $lastid[] = $value['id'];
                                                    ?>
                                            <div class="row" style="width:100%;margin: 2px 0;"
                                                id="removeDataSheetFromDB_<?= $value['id'] ?>">
                                                <div class="form-group col-md-6">
                                                    <label for="data_sheet_name">Product Data Sheet Name</label>
                                                    <input type="text" class="form-control" name="data_sheet_name[]"
                                                        value="<?= $data_sheet_name ?>" placeholder="Enter Product Price">
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for="data_sheet_desc">Product Data Sheet Description</label>
                                                    <input type="text" class="form-control" name="data_sheet_desc[]"
                                                        value="<?= $data_sheet_desc ?>" placeholder="Enter Product Old Price">
                                                </div>

                                                <div class="col-md-2"
                                                    style="display: flex;width: 100%;height: 85px;justify-content: center;align-items: center;">
                                                    <a class="btn btn-danger"
                                                        onclick="removeDataSheetFromDB(<?= $value['id'] ?>)">Remove</a>
                                                </div>
                                            </div>
                                            <?php
                                                    }
                                                }
                                            ?>
                                            <input type="hidden" id="getLastElementDataSheet" value="<?= end($lastid) ?>">
                                        </div>
                                        <div class="card-footer">
                                            <button type="button" class="btn btn-primary float-right"
                                                id="add_more_product_data_sheeet_field"><i class="fa fa-plus"></i> Add More</button>
                                        </div>
                                        <!-- /.row -->
                                    </div>
                                </div>

                                <div class="card_box card-default mt-3 mb-5">
                                    <div class="card-header">
                                        <h3 class="card-title">Optional</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="product_waist">Product Waist</label>
                                                <input type="text" class="form-control" name="product_waist"
                                                    value="<?= $product_waist ?>" placeholder="Enter Product Waist">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="product_hips">Product Hips</label>
                                                <input type="text" class="form-control" name="product_hips" value="<?= $product_hips ?>"
                                                    placeholder="Enter Product Hips">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="product_tags">Tags</label>
                                                <input type="text" name="product_tags" class="form-control" data-role="tagsinput"
                                                    value="<?= $product_tags ?>">
                                            </div>

                                        </div>
                                        <!-- /.row -->
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <button type="submit" id="submit_data" class="btn btn-primary float-right">Next</button>
                                    </div>
                                </div>

                            </form>

                            <div id="product_images">
                                <div class="card_box card-default mt-3 mb-5" id="product_images">
                                    <div class="card-header">
                                        <h3 class="card-title">Product Images</h3>
                                    </div>
                                    <div class="card-body">
                                        <form action="<?= ADMIN_FRONT_SITE ?>product_images_upload.php" name="product_images[]"
                                            class="dropzone" id="dropzoneFrom">
                                        </form>
                                    </div>
                                    <div class="card-footer">
                                        <button type="button" id="previous_sec" class="btn btn-default float-left">Previous</button>
                                        <button type="button" class="btn btn-primary float-right" id="submit-all">Upload</button>
                                    </div>
                                </div>

                                <div class="card_box card-default mt-3 mb-5" id="product_images">
                                    <div class="card-header">
                                        <h3 class="card-title">Uploaded Images</h3>
                                    </div>
                                    <div class="card-body " id="preview_images_below">

                                    </div>
                                </div>

                                <form action="" method="post" id='form_main_setting_product'>
                                    <input type="hidden" name='product_publish_as_id' value="<?= $id ?>">
                                    <div class="card_box card-default mt-3 mb-5">
                                        <div class="card-header">
                                            <h3 class="card-title">Main Setting</h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <div class="row">

                                                <div class="form-group col-md-6">
                                                    <label for="product_publish_as_data">Publish Product</label>
                                                    <select name="product_publish_as_data" id="product_publish_as_data"
                                                        class="form-control " style="width: 100%;"
                                                        required>
                                                        <option selected="selected" disabled>Publish Product as</option>
                                                        <?php
                                                                $arr_visible = array("0"=>'Private', '1' => 'Public', '2' => 'Draft');
                                                                foreach ($arr_visible as $key => $value) {
                                                                    if ($product_status == $key) {
                                                                        $Publish_selected = 'selected';
                                                                    }else{
                                                                        $Publish_selected = '';
                                                                    }
                                                                    ?>
                                                        <option <?= $Publish_selected ?> value='<?= $key ?>'><?= $value ?></option>
                                                        <?php
                                                                }
                                                            ?>

                                                    </select>
                                                </div>

                                            </div>
                                            <!-- /.row -->
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <button type="button" id="previous_sec" class="btn btn-default float-left"> <a
                                                    href="<?= SELLER_FRONT_SITE.'ProductListing?action=ViewListing' ?>">Back to Products lists</a></button>
                                            <button type="submit" id="main_setting_product"
                                                class="btn btn-primary float-right">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <input type="hidden" id='product_ids' value="<?= $id ?>">       
                        </div>
                    </div>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js"></script>

            <script>
            var stepper1Node = document.querySelector('#stepper1')
            var stepper1 = new Stepper(document.querySelector('#stepper1'), {
                linear: true,
                animation: true
            })

                    
            </script>

        <?php
    }else{
        // LISTING IN PROGRESS // QC CHECK 
        ?>  
         <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SELLER_FRONT_SITE ?>">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Listing in Progress</li>
            </ol>
        </nav>

        <div class="container-fluid mt-3 c">
            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4 card p-2">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="example2"
                            class="table table-bordered table-striped dataTable dtr-inline text-center"
                            role="grid" aria-describedby="example2_info">
                            <thead>
                                <tr role="row">
                                    <th>IMAGE</th>
                                    <th>CATEGORY</th>
                                    <th>BRAND</th>
                                    <th>SKU ID</th>
                                    <th>CREATED ON</th>
                                    <th>STATUS</th>
                                    <th>REMARK</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $ProductDetails = ProductDetails('left join shop_category on product_details.product_categories =  shop_category.cat_id left join brands on product_details.product_brand = brands.bid where selling_by='.$_SESSION['SELLER_ID'].'');
                                    foreach($ProductDetails as $key => $val) {
                                        $ProductImageById = ProductImageById($val['id'], 'limit 1');
                                        array_unshift($ProductImageById,"");
                                        unset($ProductImageById[0]);

                                        $qc_status_explode = explode(",",$val['qc_status']);
                                        unset($qc_status_explode[0]);
                                        $end_qc_status = end($qc_status_explode);

                                        $qc_message_explode = explode(",PS_FASHION_STORE,",$val['qc_message']);
                                        unset($qc_message_explode[0]);
                                        $end_qc_message= end($qc_message_explode);

                                        if ($end_qc_status == '') {
                                            $qc_text = "Sended for QC <i class='bx bx-send' style='font-size:18px'></i>";
                                        }else if($end_qc_status==2){
                                            $qc_text = '<span class="text-danger">Rejected By '.SITE_NAME.'</span><br>
                                                        <h5> '.$end_qc_message.'</h5>';
                                        }else if($end_qc_status==1){
                                            $qc_text = '<span class="text-success"><i class="fa fa-check-circle text-success"></i> QC Passed</span>';
                                        }else{
                                            $qc_text = "<i class='bx bxs-hourglass' ></i> QC in Process";
                                        }
                                        ?>
                                        <tr class="odd" >
                                            <td style=""><img class="img-reponsive img-fluid"
                                                    width="80px" height="80px"
                                                    style="border-radius:20%;width:60px;height:80px"
                                                    src="<?= FRONT_SITE_IMAGE_PRODUCT.$ProductImageById['1']['product_img'] ?>"
                                                    alt=""></td>
                                            <td>
                                                <?php
                                                    if($val['product_subCat_Values'] == '') {
                                                        // if empty then print subcategory 
                                                        echo urldecode($val['product_subCategories']);
                                                    }else{
                                                        echo $val['product_subCat_Values'];
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <h5><?= $val['brand_name'] ?></h5>
                                            </td>
                                            <td>
                                                <h5><?= $val['sku_id'] ?></h5>
                                            </td>
                                            <td>
                                                <?= date('M d, Y', strtotime($val['product_added_on'])) ?>
                                            </td>
                                            <td> <?= $qc_text ?></td>
                                            <td>
                                                <button type="button" class="btn btn-default bg-primary text-white" data-toggle="modal" data-target="#modal-lg<?= $val['id'] ?>">
                                                    View
                                                </button>
                                                <div class="modal fade" id="modal-lg<?= $val['id'] ?>" style="display: none;" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">QC TEST PASS REMARK</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">×</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <table class="table table-bordered table-striped dataTable dtr-inline">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Status</th>
                                                                            <th>Remark</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                            
                                                                            if (count($qc_status_explode) > 0) {
                                                                                foreach ($qc_status_explode as $key => $value) {
                                                                                    if($value == 0){
                                                                                        $qc_text = 'Send for Re-Edit';
                                                                                        $alert_color = 'text-info';
                                                                                    }elseif ($value == 1) {
                                                                                        $qc_text = 'Approved';
                                                                                        $alert_color = 'text-success';
                                                                                    }else if ($value == 2){
                                                                                        $qc_text = 'Rejected';
                                                                                        $alert_color = 'text-danger';
                                                                                    }
                                                                                ?>
                                                                                    <tr>
                                                                                        <td width="20%"><span class="<?= $alert_color  ?>"> <?= $qc_text ?></span></td>
                                                                                        <td><div class="<?= $alert_color  ?>">  <?php  if(isset($qc_message_explode[$key])) echo $qc_message_explode[$key] ?></div></td>
                                                                                    </tr>
                                                                                <?php
                                                                                }
                                                                            }else{
                                                                                ?>
                                                                                    <h3>No Qc Test Pass Found.</h3>
                                                                                <?php
                                                                            }
                                                                        ?>
                                                                    </tbody>
                                                                    
                                                                </table>
                                                            </div>
                                                            <div class="modal-footer justify-content-between">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                ?>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th>By CATEGORY</th>
                                    <th>By BRAND</th>
                                    <th>By SKU ID</th>
                                    <th>By CREATED ON</th>
                                    <th>By STATUS</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>
            </div>
        </div>
        

        <?php
    }
    
    include 'includes/footer.php';
?>

<input type="hidden" value='<?= $sell_row['seller_fullname'] ?>' id="seller_fullname">
<script>
    $("#category_select2, #subcategory_select2,#subcategoryvalues_select2").select2();

    $("#brand_selection").select2({
        tags: true
    });   

    // Product Category Listing on Seller Panel 
    product_category_Change();

    function product_category_Change() {
        var id = $("#category_select2").val();
        var sub_cat_recive_from_Db = $("#sub_cat_recive_from_Db").val();
        if (id == '') {
            jQuery('#subcategory_select2').html('<option value=""  disabled selected="selected">Select Sub Category</option>');
            jQuery('#subcategoryvalues_select2').html('<option value="" disabled selected>Select Sub Category Value</option>');
        } else {
            jQuery('#subcategory_select2').html('<option value=""  disabled selected="selected">Select Sub Category</option>');
            jQuery('#subcategoryvalues_select2').html('<option value="" disabled selected>Select Sub Category Value</option>');
            jQuery.ajax({
                url: "../PS_ADMIN/admin_ajax_call.php",
                type: "post",
                data: "id=" + id + '&change_category_load_sub_category=sub_category&sub_cat_recive_from_Db=' + sub_cat_recive_from_Db,
                success: function (data) {
                    product_subcategory_Change();
                    jQuery('#subcategory_select2').append(data);
                    $("#select_brand_btn").attr("disabled", true);
                }
            });
        }
    }
    

    function product_subcategory_Change() {
        var id = $("#subcategory_select2").val();
        var sub_catValue_recive_from_Db = $("#sub_catValue_recive_from_Db").val();
        if (id == '') {
            jQuery('#subcategoryvalues_select2').html('<option value="" disabled selected>Select Sub Category Value</option>');
        } else {
            jQuery('#subcategoryvalues_select2').html('<option value="" disabled selected>Select Sub Category Value</option>');
            jQuery.ajax({
                url: "../PS_ADMIN/admin_ajax_call.php",
                type: "post",
                data: "id=" + id + '&change_subcategory_load_sub_category=sub_category&sub_catValue_recive_from_Db=' + sub_catValue_recive_from_Db,
                success: function (data) {
                    jQuery('#subcategoryvalues_select2').append(data);
                    if( !$('#subcategory_select2').val() ) { 
                        $("#select_brand_btn").attr("disabled", true);
                    }else{
                        $("#select_brand_btn").attr("disabled", false);
                    }
                }
            });
        }
    }

    // WHEN WE CLICK ON SELECT BRAND BUTTON AFTER CHOOSING ALL TYPE OF CATEGORY 
    $("#select_brand_btn").click( () => {
        if( !$('#subcategoryvalues_select2').val() ) { 
            $("#category_selected_bySeller").html('('+decodeURIComponent($("#subcategory_select2").val())+')');
        }else{
            $("#category_selected_bySeller").html('('+decodeURIComponent($("#subcategoryvalues_select2").val())+')');
        }
        
    });


    // step 2
    // Brand Selection when we select any brand then we can do below staff 
    brandSelection();
    function brandSelection() {
        var brand_selection = $("#brand_selection").val();
        var subcategory_selection = $("#subcategoryvalues_select2").val();
        if(brand_selection != null) {
            $.ajax({
                url:'seller_ajax_call.php',
                method: 'post',
                data: "brand_selection_for_add_new="+brand_selection+"&subcategory_selection="+subcategory_selection,
                success : (res) => {
                    $("#response_for_brand_approval").html(res);
                }
            })
        }
    }

    function start_selling_under_this_brand(brand_name,bid) {
        $("#brand_selected_bySeller").html("("+brand_name+")");
        stepper1.next();
        $("#brand_data").val(bid);
        $("#brand_name").val(brand_name);
        $("#category").val($("#category_select2").val());
        $("#sub_category_data").val($("#subcategory_select2").val());
        $("#sub_category_value").val($("#subcategoryvalues_select2").val());
    }


    // STEP 3 Product Upload form

    $("#product_images").hide();

    $("#previous_sec").click(() => {
        $("#product_images").hide();
        $("#product_data_form").show();
    })
    Dropzone.options.dropzoneFrom = {
        autoProcessQueue: false,
        acceptedFiles: ".png,.jpg,.jpeg,.webp",
        parallelUploads: 10000,
        uploadMultiple: true,
        init: function() {
            var submitButton = document.querySelector('#submit-all');
            myDropzone = this;
            submitButton.addEventListener("click", function() {
                myDropzone.processQueue();
            });
            this.on("complete", function() {
                if (this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0) {
                    var _this = this;
                    _this.removeAllFiles();
                    Swal.fire({
                        title: "Congratulations!",
                        text: "Uploaded Successfully",
                        icon: "success"
                    })
                }
                list_image();
            });
        },
    }

    list_image();

    function list_image() {
        var product_id = $("#product_ids").val();
        $.ajax({
            url: "../PS_ADMIN/product_images_upload.php",
            method: 'post',
            data: {
                list_image_files: "list_image_files",
                product_id: product_id
            },
            success: function(data) {
                $("#preview_images_below").html(data);
            }
        });
    }

    // Summernote
    $('#summernote').summernote({
        placeholder: 'Tell us something about this product',
        tabsize: 2,
        height: 100
    });

    $('#long_decription').summernote({
        placeholder: 'Detailed information about this product',
        tabsize: 2,
        height: 250,
    });

    $.validator.setDefaults({
        submitHandler: function(form) {
            $.ajax({
                type: "POST",
                url: "../PS_ADMIN/admin_ajax_call.php",
                data: $(form).serialize(),
                success: function(res) {
                    var data = $.parseJSON(res);
                    if (data.status == 'error_datasheet') {
                        
                        Swal.fire({
                            title: "Oops!",
                            text: data.message,
                            icon: "error"
                        })
                    }

                    if (data.status == 'error') {
                        Swal.fire({
                            title: "Oops!",
                            text: data.message,
                            icon: "error"
                        })
                    }
                    if (data.status == 'success') {
                        Swal.fire({
                            text: data.message,
                            title: "Now add Imagess",
                            icon: "error"
                        })
                        
                        $("#product_data_form").hide();
                        $("#product_images").show();
                    }

                    if (data.status == 'update_success') {
                        Swal.fire({
                            title: 'Would you like to Update Images Also?',
                            showDenyButton: true,
                            confirmButtonText: 'Yes',
                            denyButtonText: 'No',
                            customClass: {
                                actions: 'my-actions',
                                cancelButton: 'order-1 right-gap',
                                confirmButton: 'order-2',
                                denyButton: 'order-3',
                            },
                            icon: "warning",
                        }).then(function(result) {
                            if (result.isConfirmed) {
                                $("#product_data_form").hide();
                                $("#product_images").show();
                            }else{
                                window.location = 'ProductListing?action=viewListing';
                            } 
                        });
                    }

                }
            });
        }
    });
    $('#product_data_form').validate({
        rules: {
            product_name: {
                required: true,
                rangelength: [10, 255]
            },
            sku_id: {
                required : true,
            },
            total_stock: {
                required: true,
                number: true
            },
            product_price: {
                required: true,
                number: true
            },
            product_oldPrice: {
                required: true,
                number: true
            },
            product_weight: {
                required: true,
                number: true
            }
        },
        messages: {
            product_name: {
                required: "Please enter a Product Name",
            },
            total_stock: {
                number: "Please enter a valid number",
            },
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });

    var cloneNodeDataSheetCount = $("#getLastElementDataSheet").val();
    $("#add_more_product_data_sheeet_field").click(() => {
        var cloneNodeDataSheet = $("#cloneNodeDataSheet");
        cloneNodeDataSheetCount++;
        var DataAppend = '<div class="row" style="width:100%;margin: 2px 0;" id="box_' + cloneNodeDataSheetCount + '"><div class="form-group col-md-6"><label for="data_sheet_name">Product Data Sheet Name</label><input type="text" class="form-control" name="data_sheet_name[]" placeholder="Enter Product Data Sheet Name"></div><div class="form-group col-md-4"><label for="data_sheet_desc">Product Data Sheet Description</label><input type="text" class="form-control" name="data_sheet_desc[]"value="" placeholder="Enter Product Data Sheet Description"></div><div class="col-md-2" style="display: flex;    width: 100%;height: 85px;justify-content: center;align-items: center;"><a class="btn btn-danger text-white" onclick="DeleteCloneNodeDatSheet(' + cloneNodeDataSheetCount + ')">Remove</a></div></div>';

        cloneNodeDataSheet.append(DataAppend);

    })

    function DeleteCloneNodeDatSheet(id) {
        $("#box_" + id).remove();
    }

    function removeDataSheetFromDB(id) {
        jQuery.ajax({
            url: '../PS_ADMIN/admin_ajax_call.php',
            type: 'post',
            data: {
                id: id,
                "removeDataSheetFromDB": "removeDataSheetFromDB"
            },
            success: function (result) {
                $("#removeDataSheetFromDB_" + id).remove();
                Swal.fire({
                    title: "Congratulations!",
                    text: "Data Sheet Deleted Successfully",
                    icon: "success"
                })
            }
        });
    }

    // Product Adding after main setting section 
    $("#form_main_setting_product").submit((e) => {
        e.preventDefault();
        var form_data = $("#form_main_setting_product").serialize();
        $.ajax({
            url: '../PS_ADMIN/admin_ajax_call.php',
            method: 'post',
            data: form_data,
            success: (res) => {
                var data = $.parseJSON(res);

                if (data.status == 'error') {
                    Swal.fire({
                        title: "Oops!",
                        text: data.message,
                        icon: data.status
                    })
                }
                else if (data.status == 'success') {
                    Swal.fire({
                        title: "Congrats!",
                        text: data.message,
                        icon: data.status
                    })
                }
                else if (data.status == 'warning') {
                    Swal.fire({
                        title: "",
                        text: data.message,
                        icon: data.status
                    })
                }
            }
        });
    })

    var seller_fullname = $("#seller_fullname").val();
    $('#example1 tfoot th:gt(0)').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" class="form-control" placeholder="Search '+title+'" />' );
    } );
    $("#example1").DataTable({
        dom: 'Blfrtip',
        "language": {
            "emptyTable": "No Product available to list"
        },
        "responsive": true,
        "autoWidth": false,
        "lengthMenu": [[2,5, 10, 25, 50, -1], [2,5, 10, 25, 50, "All"]],
        initComplete: function () {
            // Apply the search
            this.api().columns(':gt(0)').every( function () {
                var that = this;

                $( 'input', this.footer() ).on( 'keyup change clear', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );
        },
        buttons: 
        [
            {
                extend: 'searchBuilder',
                config: {
                    depthLimit: 2
                }
            },
            {
                extend: 'print',
                title: function(){
                    var printTitle = '<h5 class="text-center mb-3">List of Products Belong to '+seller_fullname+' Seller Account</h5>';
                    return printTitle
                },
                exportOptions: {
                    stripHtml: false,
                    columns: [0,1, 2, 3,4,5,6,7,8]
                    //specify which column you want to print

                }
            },
            
        ]   
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');


    $('#example2 tfoot th:gt(0)').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" class="form-control" placeholder="Search '+title+'" />' );
    } );
    $("#example2").DataTable({
        "language": {
            "emptyTable": "No Listing in Process is found."
        },
        "responsive": true,
        "autoWidth": false,
        "lengthMenu": [[2,5, 10, 25, 50, -1], [2,5, 10, 25, 50, "All"]],
        initComplete: function () {
            // Apply the search
            this.api().columns(':gt(0)').every( function () {
                var that = this;

                $( 'input', this.footer() ).on( 'keyup change clear', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );
        },
        buttons: [{
            extend: 'print',
            title: function(){
                var printTitle = '<h5 class="text-center mb-3">List in process Belong to '+seller_fullname+' Seller Account</h5>';
                return printTitle
            },
            exportOptions: {
                stripHtml: false,
                columns: [0,1, 2, 3,4,5]
                //specify which column you want to print

            }
        },

    ]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
</script>