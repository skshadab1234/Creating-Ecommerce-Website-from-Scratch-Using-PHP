<?php
    require 'includes/header.php';
    $BRAND_DATA = ExecutedQuery("SELECT * FROM brands WHERE brand_status = 1");
    $Category_data = ExecutedQuery("SELECT * FROM shop_category WHERE status = 1");
    
?>
<style>

</style>

<?php
    if (isset($_GET['operation']) && $_GET['operation'] != '') {
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
        $selling_by = 'admin';
        $sku_id = '';
        $qc_status = '';

        $type = 'add';

        if(isset($_GET['id']) && $_GET['id'] > 0) {
            $id= get_safe_value($_GET['id']);
            $head_title = 'Edit Product';
            $ProductDetails = ProductDetails("where id = ".$id."");
            $type = 'update';
            if (empty($ProductDetails)) {
                redirect(ADMIN_FRONT_SITE.'products');
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
                $qc_status = $ProductDetails['qc_status'];
            }

        }
        ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= $head_title ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">

                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="content">
        <div class="container-fluid">
            
            <form action="" id="product_data_form">
                <input type="hidden" name='product_opt' value="<?= $type ?>">
                <input type="hidden" name='prodid' value="<?= $prodid ?>">
                <input type="hidden" name='selling_by' value="<?= $selling_by ?>">
                <div class="card_box card-default">
                    <div class="card-header">
                        <h3 class="card-title h5">Add Basic information </h3>
                        <button type="submit" id="submit_data" class="btn btn-primary float-right">Next</button>
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
                                <label for="product_size">SKU ID</label>
                                <input type="text" class="form-control"  value="<?= $sku_id ?>" name="sku_id" placeholder="Enter Unique SKU ID">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Category</label>
                                <select name="category" id='product_category_121'
                                    class="form-control select2 select2-hidden-accessible" style="width: 100%;" 
                                    onchange="product_category_Change()">
                                    <option selected="selected" disabled>Select Category</option>
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
                                <select name="sub_category_data" id='sub_category_data'
                                    class="form-control select2 select2-hidden-accessible" style="width: 100%;"
                                    onchange="product_subcategory_Change()">
                                    <option value=""> Select Sub Category</option>

                                </select>
                                <input type="hidden" id="sub_cat_recive_from_Db" value="<?= $product_subCategories ?>">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Sub Category Value</label>
                                <select name="sub_category_value" id='sub_category_value'
                                    class="form-control select2 select2-hidden-accessible" style="width: 100%;">
                                    <option selected="selected" value="">Select Sub Category Value</option>

                                </select>
                                <input type="hidden" id="sub_catValue_recive_from_Db"
                                    value="<?= $product_subCat_Values ?>">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Brand</label>
                                <select name="brand_data" id='brand_data' class="form-control select2 select2-hidden-accessible" style="width: 100%;">
                                    <option selected="selected" disabled>Select Brand</option>
                                    <?php
                                        foreach($BRAND_DATA as $key => $val) {
                                            if ($val['bid'] == $product_brand) {
                                                $check_brand = 'selected';
                                            }else{
                                                $check_brand = '';
                                            }
                                            ?>
                                    <option <?= $check_brand ?> value="<?= $val['bid'] ?>"><?= $val['brand_name'] ?>
                                    </option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>



                            <div class="form-group col-md-6">
                                <label for="product_size">Product Size</label>
                                <input type="text" class="form-control" data-role="tagsinput"
                                    value="<?= $product_size ?>" name="product_size">
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
                                <input type="text" name="product_tags" data-role="tagsinput"
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
                                        class="form-control select2 select2-hidden-accessible" style="width: 100%;"
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
                                    href="<?= ADMIN_FRONT_SITE.'products' ?>">Back to Products lists</a></button>
                            <button type="submit" id="main_setting_product"
                                class="btn btn-primary float-right">Submit</button>
                        </div>
                    </div>
                </form>

                <form action="" method="post" id='qc_form_settings'>
                    <input type="hidden" name='product_qc_status_pid' value="<?= $id ?>">
                    <div class="card_box card-default mt-3 mb-5">
                        <div class="card-header">
                            <h3 class="card-title">QC (Quality Check)</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">

                                <div class="form-group col-md-6">
                                    <label for="qc_status">Set QC as</label>
                                    <select name="qc_status" id="qc_status"
                                        class="form-control select2 select2-hidden-accessible" style="width: 100%;">
                                        <option value="" selected="" disabled>Select QC Status</option>
                                        <?php
                                            $arr_visible = array("0"=>'Send for re-edit', '1' => 'Approved', '2' => 'Reject');
                                            foreach ($arr_visible as $key => $value) {
                                                if ($qc_status == $key) {
                                                    $qc_status_selected = 'selected';
                                                }else{
                                                    $qc_status_selected = '';
                                                }
                                                ?>
                                            <option <?= $qc_status_selected ?> value='<?= $key ?>'><?= $value ?></option>
                                        <?php
                                                }
                                            ?>

                                    </select>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="qc_note">Add Note (if any)</label>
                                    <textarea name="qc_note" id="qc_note_summernote" cols="30" rows="10"></textarea>
                                </div>

                                <div class="alert alert-warning alert-dismissible">
                                    <h5><i class="icon fas fa-ban"></i> Note!</h5>
                                    Note this point, you can't edit anything after you submit your QC message. Make Sure you Submit After Checking all Qc Status and Qc Note.
                                </div>

                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" id="qc_pass_btn"
                                class="btn btn-primary float-right">Submit</button>
                        </div>
                    </div>
                </form>

                <div class="card_box card-default">
                    <div class="callout callout-danger" style="background-color: #283046;">
                        <h5>QC Test Pass Notes.</h5>
                        <p>Following are the messages wrote by qc checker.</p>
                        <dl class="row" id="qc_status_notets" >
                            <?php
                                $qc_status_explode = explode(",",$qc_status);
                                unset($qc_status_explode[0]);
                                $qc_message_explode = explode(",PS_FASHION_STORE,",$ProductDetails['qc_message']);
                                unset($qc_message_explode[0]);

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
                                        <dt class="col-12 col-md-3 <?= $alert_color ?>"><?= $qc_text ?></dt>
                                        <dd class="col-12 col-md-9 <?= $alert_color ?>"><?php if(isset($qc_message_explode[$key])) echo $qc_message_explode[$key] ?></dd>
                                    <?php
                                    }
                                }else{
                                    ?>
                                        <h3>No Qc Test Pass Found.</h3>
                                    <?php
                                }
                            ?>
                        </dl>

                    </div>
                </div>
            </div>

            <input type="hidden" id='product_ids' value="<?= $id ?>">

            <?php
    }
    else{
        ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">Products</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">

                                </ol>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->

                <form action="" id="update_all_product_checkbox_frm" method="post">
                    <input type="hidden" name="product_status" id="productStatusAfterBtnClick">
                    <div class="content">
                        <div class="container-fluid">
                            <div class="card_box">
                                <div class="card-header">
                                    <button type="submit" class="btn text-primary" id="product_activate_btn" style="display:none">Activate</button>
                                    <button type="submit" class="btn text-primary" id="product_deactivate_btn" style="display:none">Deactive</button>
                                    <button type="submit" class="btn text-primary" id="product_draft_btn" style="display:none">Draft</button>
                                    <button type="button" class="btn text-primary" id="update_stock_bulk" style="display:none" data-toggle="modal"
                                                    data-target="#update_stock_modal" >Update Stock</button>

                                    <div class="modal fade" aria-hidden="true" id='update_stock_modal'>
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content ">
                                                <div class="modal-header card_box">
                                                    <h4 class="modal-title">Update Stock</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body text-left card_box" >
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="UpdateStockBulk" id="update_stock_value_123" placeholder="Enter Bulk Stock"> 
                                                    </div>
                                                </div>
                                                <div class="modal-footer card_box justify-content-between">
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                </div>

                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <h3 class="card-title float-right">
                                        <button class="btn btn-success"><a
                                                href="<?= ADMIN_FRONT_SITE.'products?operation=addNewProduct' ?>"
                                                style="color:#fff">Add new</a></button>
                                    </h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <table id="ProductListExample"
                                                    class="table table-bordered table-striped dataTable dtr-inline "
                                                    role="grid" aria-describedby="example1_info">
                                                    <thead>
                                                        <tr role="row">
                                                            <th width="1%"> 
                                                                <input type="checkbox" id="update_check_data" onclick="select_all()">
                                                            </th>
                                                            <th width="2%">IMAGE</th>
                                                            <th width="20%">NAME</th>
                                                            <th width="2%">SELLING PRICE</th>
                                                            <th width="2%">UNIT PRICE</th>
                                                            <th width="2%">PRODUCT BRAND</th>
                                                            <th width="2%">Instock</th>
                                                            <th width="2%">PRODUCT SIZE</th>
                                                            <th width="20%">BreadCrump</th>
                                                            <th width="5%">STATUS</th>
                                                            <th width="5%">QC STATUS</th>
                                                            <th width="15%">ADDED ON</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="product_listing_td">

                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th></th>
                                                            <th></th>
                                                            <th>By Name</th>
                                                            <th>By Sell Price</th>
                                                            <th>By Unit Price</th>
                                                            <th>By Brand</th>
                                                            <th>By Stock</th>
                                                            <th>By Size</th>
                                                            <th>By Breadcrump</th>
                                                            <th>By Status</th>
                                                            <th>By QC status</th>
                                                            <th>By Added Date</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    </div>
                </form>
                <?php
    }
?>
            </div>


            <?php
                require 'includes/footer.php';
            ?>

            <script>
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
                            swal('Uploaded Successfully', '', 'success');
                        }
                        list_image();
                    });
                },
            }

            list_image();

            function list_image() {
                var product_id = $("#product_ids").val();
                $.ajax({
                    url: "product_images_upload.php",
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


            $(function() {
                
                //Initialize Select2 Elements
                $('.select2').select2()

                //Initialize Select2 Elements
                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                })

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

                $('#qc_note_summernote').summernote({
                    placeholder: 'Add some comment that will visible to seller so he can edit and again send for QC',
                    tabsize: 2,
                    height: 100
                });
                

                $.validator.addMethod("valueNotEquals", function(value, element, arg) {
                    return arg !== value;
                }, "Value must not equal arg.");

                $.validator.setDefaults({
                    submitHandler: function(form) {
                        $.ajax({
                            type: "POST",
                            url: "admin_ajax_call.php",
                            data: $(form).serialize(),
                            success: function(res) {
                                console.log(res)
                                var data = $.parseJSON(res);
                                if (data.status == 'error_datasheet') {
                                    swal(data.message, '', 'error');
                                }

                                if (data.status == 'error') {
                                    swal(data.message, '', 'error');
                                }
                                if (data.status == 'success') {
                                    swal(data.message, 'Now add Imagess', 'warning');
                                    $("#product_data_form").hide();
                                    $("#product_images").show();
                                }

                                if (data.status == 'update_success') {
                                    swal({
                                        title: "Would  you like to Update Images Also?",
                                        text: data.message,
                                        icon: "warning",
                                        buttons: [
                                            'No',
                                            'Yes'
                                        ],
                                        // dangerMode: true,
                                    }).then(function(isConfirm) {
                                        if (isConfirm) {
                                            $("#product_data_form").hide();
                                            $("#product_images").show();
                                        } else {
                                            window.location = 'products';
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
                        category: {
                            required: true
                        },
                        sub_category_data: {
                            required : true,
                        },
                        sku_id :{
                            required : true,
                        },
                        brand_data: {
                            required : true
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

                $.validator.setDefaults({
                    submitHandler: function(form) {
                        $("#qc_pass_btn").attr("disabled", true);
                        $.ajax({
                            type: "POST",
                            url: "admin_ajax_call.php",
                            data: $(form).serialize(),
                            success: function(res) {
                                $("#qc_status_notets").append(res);
                                $("#qc_pass_btn").attr("disabled", false);
                                $("#qc_form_settings")[0].reset();
                                swal('QC Status', 'QC Status Updated', 'success');
                            }
                        });
                    }
                });
                $('#qc_form_settings').validate({
                    rules: {
                        qc_status: {
                            required : true
                        },
                        qc_note: {
                            required: true,
                            rangelength:[3,255]
                        }
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

            });
            </script>