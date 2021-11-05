<?php
    require 'includes/header.php';
    $BRAND_DATA = ExecutedQuery("SELECT * FROM brands WHERE brand_status = 1");
    $Category_data = ExecutedQuery("SELECT * FROM shop_category WHERE status = 1");
    
?>
<style>
 .dt-buttons{
            display:none
        }
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
                <div class="card_box card-default" data-select2-id="40">
                    <div class="card-header">
                        <h3 class="card-title">Add Basic information </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="product_name">Product Name</label>
                                <input type="text" class="form-control" id="product_name" name="product_name"
                                    placeholder="Enter Product Name" value="<?= $product_name ?>">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Category</label>
                                <select name="category" id='product_category_121'
                                    class="form-control select2 select2-hidden-accessible" style="width: 100%;"
                                    required onchange="product_category_Change()">
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
                                    </option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Sub Category</label>
                                <select name="sub_category_data" id='sub_category_data'
                                    class="form-control select2 select2-hidden-accessible" style="width: 100%;"
                                    required>
                                    <option selected="selected" disabled>Sub Category</option>
                                   
                                </select>
                                <input type="hidden" id="sub_cat_recive_from_Db" value="<?= $product_subCategories ?>">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Brand</label>
                                <select name="brand_data" id='brand_data'
                                    class="form-control select2 select2-hidden-accessible" style="width: 100%;"
                                    required>
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

                            <div class="form-group col-md-6">
                                <label for="product_weight">Product Weight</label>
                                <input type="text" class="form-control" name="product_weight"
                                    value="<?= $product_weight ?>" placeholder="Enter Product Weight">
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
                                        <div class="row" style="width:100%;margin: 2px 0;" id="removeDataSheetFromDB_<?= $value['id'] ?>">
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

                                            <div class="col-md-2" style="display: flex;width: 100%;height: 85px;justify-content: center;align-items: center;">
                                                <a class="btn btn-danger" onclick = "removeDataSheetFromDB(<?= $value['id'] ?>)">Remove</a>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                }
                            ?>
                            <input type="hidden" id="getLastElementDataSheet" value="<?= end($lastid) ?>">
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-primary float-right" id="add_more_product_data_sheeet_field"><i class="fa fa-plus"></i>  Add More</button>
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

                <form action="" id="delete_all_product_checkbox_frm" method="post">
                    <div class="content">
                        <div class="container-fluid">
                            <div class="card_box">
                                <div class="card-header">
                                    <button type="submit" class="btn btn-danger float-left" id="product_delete_btn" style="display:none">Delete</button>

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

                                                <table id="example1"
                                                    class="table table-bordered table-striped dataTable dtr-inline"
                                                    role="grid" aria-describedby="example1_info">
                                                    <thead>
                                                        <tr role="row">
                                                            <th class="sorting"><input type="checkbox"
                                                                    id="delete_check_data" onclick="select_all()"></th>
                                                            <th class="sorting" tabindex="0" aria-controls="example1"
                                                                rowspan="1" colspan="1"
                                                                aria-label="Browser: activate to sort column ascending"
                                                                style="">IMAGE</th>
                                                            <th class="sorting" tabindex="0" aria-controls="example1"
                                                                rowspan="1" colspan="1"
                                                                aria-label="Browser: activate to sort column ascending"
                                                                style="">NAME</th>
                                                            <th class="sorting" tabindex="0" aria-controls="example1"
                                                                rowspan="1" colspan="1"
                                                                aria-label="Platform(s): activate to sort column ascending">
                                                                PRODUCT PRICE</th>
                                                            <th class="sorting" tabindex="0" aria-controls="example1"
                                                                rowspan="1" colspan="1"
                                                                aria-label="CSS grade: activate to sort column ascending">
                                                                PRODUCT BRAND</th>
                                                            <th class="sorting" tabindex="0" aria-controls="example1"
                                                                rowspan="1" colspan="1"
                                                                aria-label="CSS grade: activate to sort column ascending">
                                                                Instock</th>
                                                            <th class="sorting" tabindex="0" aria-controls="example1"
                                                                rowspan="1" colspan="1"
                                                                aria-label="CSS grade: activate to sort column ascending">
                                                                PRODUCT SIZE</th>
                                                            <th class="sorting" tabindex="0" aria-controls="example1"
                                                                rowspan="1" colspan="1"
                                                                aria-label="CSS grade: activate to sort column ascending">
                                                                CATEGORIES</th>
                                                            <th class="sorting" tabindex="0" aria-controls="example1"
                                                                rowspan="1" colspan="1"
                                                                aria-label="CSS grade: activate to sort column ascending">
                                                                SUB CATEGORIES</th>                                                                
                                                            <th class="sorting" tabindex="0" aria-controls="example1"
                                                                rowspan="1" colspan="1"
                                                                aria-label="CSS grade: activate to sort column ascending">
                                                                STATUS</th>
                                                            <th class="sorting" tabindex="0" aria-controls="example1"
                                                                rowspan="1" colspan="1"
                                                                aria-label="CSS grade: activate to sort column ascending">
                                                                ADDED ON</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody id="product_listing_td">
                                                        <?php
                                                                    $ProductDetails = ProductDetails('left join shop_category on product_details.product_categories =  shop_category.cat_id left join brands on product_details.product_brand = brands.bid');
                                                                    foreach($ProductDetails as $key => $val) {
                                                                        $ProductImageById = ProductImageById($val['id'], 'limit 1');
                                                                        array_unshift($ProductImageById,"");
                                                                        unset($ProductImageById[0]);
                                                                        if ($val['total_stock'] -  $val['total_sold'] < 100) {
                                                                            $color = 'red';
                                                                        }else{
                                                                            $color = 'green';
                                                                        }

                                                                        if ($val['product_status'] == 0) {
                                                                            $text = 'Blocked';
                                                                            $bgColor = 'bg-danger';
                                                                        }else if ($val['product_status'] == 2) {
                                                                            $text = 'Draft';
                                                                            $bgColor = 'bg-warning';
                                                                        }else{
                                                                            $text = 'Active';
                                                                            $bgColor = 'bg-success';
                                                                        }
                                                                    ?>
                                                        <tr class="odd" id="delete_box_<?= $val['id'] ?>">
                                                            <td class="dtr-control sorting_1" tabindex="0"><input type="checkbox" name="checked_product_delete[]" onclick="get_total_selected()"
                                                                    id="<?= $val['id']?>"
                                                                    value="<?= $val['id'] ?>"></td>
                                                            <td style=""><img class="img-reponsive img-fluid"
                                                                    width="80px" height="80px" style="border-radius:50%;width:80px;height:80px"
                                                                    src="<?= FRONT_SITE_IMAGE_PRODUCT.$ProductImageById['1']['product_img'] ?>"
                                                                    alt=""></td>
                                                            <td style=""><a
                                                                    href="<?= ADMIN_FRONT_SITE.'products?operation=addProduct&id='.$val['id'].'' ?>"><?= $val['product_name'] ?></a>
                                                            </td>
                                                            <td>
                                                                <h6 class="text-muted">
                                                                    <strike>₹<?= $val['product_oldPrice'] ?></strike>
                                                                </h6>
                                                                <h5>₹ <?= $val['product_price'] ?></h5>
                                                            </td>
                                                            <td><?= $val['brand_name'] ?></td>
                                                            <td style="color: <?= $color ?>">
                                                                <?= $val['total_stock'] - $val['total_sold'] ?></td>
                                                            <td><?= $val['product_size'] ?></td>
                                                            <td><?= $val['category_name'] ?></td>
                                                            <td><?= $val['product_subCategories'] ?></td>
                                                            <td><span class="btn <?= $bgColor ?>"><?= $text ?></span>
                                                            </td>
                                                            <td><?= date("d M,Y", strtotime($val['product_added_on'])) ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                            }
                                                        ?>

                                                    </tbody>

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

            product_category_Change();

            function  product_category_Change() {
                var id = $("#product_category_121").val();
                var sub_cat_recive_from_Db = $("#sub_cat_recive_from_Db").val();
                if (id == '-1') {
                    jQuery('#sub_category_data').html('<option value="-1" disabled selected>Select Sub Category</option>');
                }else{
                    jQuery('#sub_category_data').html('<option value="-1" disabled selected>Select Sub Category</option>');
                    jQuery.ajax({
                        url : "admin_ajax_call.php",
                        type : "post",
                        data : "id="+id+'&change_category_load_sub_category=sub_category&sub_cat_recive_from_Db='+sub_cat_recive_from_Db,
                        success: function(data){
                            jQuery('#sub_category_data').append(data);
                        }
                    });
                }
            }
            
            Dropzone.options.dropzoneFrom = {
                autoProcessQueue: false,
                acceptedFiles: ".png,.jpg,.jpeg",
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
                $("#example1").DataTable({
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
                $('#example2').DataTable({
                    "paging": true,
                    "lengthChange": false,
                    "searching": false,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                });

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


            });
            </script>