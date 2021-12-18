<?php
require 'includes/header.php';
$seller_id = $_SESSION['SELLER_ID']; // Global Seller id
if (isset($_GET['action']) && $_GET['action']  == 'viewBrandListing') {
    ?>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SELLER_FRONT_SITE ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= SELLER_FRONT_SITE.'brands?action=viewBrandListing' ?>">Brands</a></li>
                <li class="breadcrumb-item active" aria-current="page">Brand Listing</li>
            </ol>
        </nav>
        <div class="container-fluid mt-3 mb-5">
            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4 card p-2">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="example1"
                            class="table table-bordered table-striped dataTable dtr-inline text-center"
                            role="grid" aria-describedby="example1_info">
                            <thead>
                                <tr role="row">
                                    <th width="10%">Image</th>
                                    <th width="2%">Brand Id</th>
                                    <th width="10%">Brand Name</th>
                                    <th width="10%" title='Total Product Added'>Total PA</th>
                                    <th width="10%" title='Brand Approval Requested'>Brand Appr. Requ.</th>
                                    <th width="10%">Brand Status</th>
                                    <th width="10%">CREATED ON</th>
                                    <th width="5%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $BrandDetails = ExecutedQuery('SELECT * FROM brands WHERE sellerId_BrandOwner="'.$seller_id.'"');
                                    if ($BrandDetails != 0) {
                                        foreach($BrandDetails as $key => $val) {
                                            if ($val['brand_img'] == '') {
                                                $brand_img = 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/2048px-No_image_available.svg.png';
                                            }else{  
                                                $brand_img = FRONT_SITE_IMAGE_BRAND.$val['brand_img'];
                                            }
    
                                            if ($val['brand_status'] > 0) {
                                                $brand_status = '<span class="text-success">Active</span>';
                                            }else{
                                                $brand_status = '<span class="text-danger">blocked</span>';
                                            }

                                            $total_requested = ExecutedQuery("SELECT * FROM `brand_approval_doc` WHERE brand_id = ".$val['bid']." && seller_id = ".$seller_id."");
                                            if ($total_requested != 0) {
                                                $total_requested = count($total_requested);
                                            }else{
                                                $total_requested = 0;
                                            }

                                            $total_approved = count(array_filter(explode(",",$val['seller_request_approved'])));
                                            $total_inprocess = count(array_filter(explode(",",$val['seller_request_in_process'])));
                                            $total_rejected = count(array_filter(explode(",",$val['seller_request_rejected'])));

                                            $ProductDetails = ProductDetails('WHERE product_brand = '.$val['bid'].'');
                                            ?>
                                            <tr class="odd" >
                                                <td style=""><img class="img-reponsive img-fluid"
                                                            width="80px" height="80px"
                                                            style="border-radius:20%;width:100px;height:80px"
                                                            src="<?= $brand_img ?>"
                                                            alt=""></td>
                                                <td><?= $val['bid'] ?></td>    
                                                <td>
                                                    <h5><?= $val['brand_name'] ?></h5>
                                                </td>
                                                <td><?= count($ProductDetails) ?> Added</td>
                                                <td>
                                                    <p><strong>Total Requested:</strong>  <?= $total_requested ?></p>
                                                    <p class="text-success"><strong>Approved:</strong>  <?= $total_approved ?></p>
                                                    <p class="text-warning"> <strong>In Process:</strong>  <?= $total_inprocess ?></p>
                                                    <p class="text-danger"><strong>Rejected:</strong>  <?= $total_rejected ?></p>
                                                </td>
                                                <td>
                                                    <h5><?= $brand_status ?></h5>
                                                </td>
                                                <td>
                                                    <?= date('M d, Y', strtotime($val['brand_added_on'])) ?>
                                                </td>
                                                <td>
                                                    <a href="<?= SELLER_FRONT_SITE.'brands?action=addNewBrandListing&id='.$val['bid'] ?>">Edit Listing</a>
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
                                    <th>Brand Id</th>
                                    <th>By BRAND Name</th>
                                    <th>By TOTAL PA</th>
                                    <th>By Brand Approval Request</th>
                                    <th>By Brand Status</th>
                                    <th>By CREATED ON</th>
                                    <th width="5%">Action</th>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    <?php
}elseif (isset($_GET['action']) && $_GET['action']  == 'addNewBrandListing') {
    $head_title = 'Add New Brand';
    $type= 'add';
    $id = '';
    $status = '';
    $brand_name = '';
    $sellerId_BrandOwner = '';

    if (isset($_GET['id']) && $_GET['id'] > 0) {
        $id = get_safe_value($_GET['id']);
        $type= 'update';
        $brand_res = SqlQuery("SELECT * FROM brands WHERE bid = '$id'");
        if (mysqli_num_rows($brand_res) > 0) {
            $row = mysqli_fetch_assoc($brand_res);
            $status = $row['brand_status'];
            $brand_name = $row['brand_name'];
            $sellerId_BrandOwner = $row['sellerId_BrandOwner'];
        }else{
            redirect(ADMIN_FRONT_SITE.'brands?action=viewBrandListing');
        }
    }
    ?>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SELLER_FRONT_SITE ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= SELLER_FRONT_SITE.'brands?action=viewBrandListing' ?>">Brands</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $head_title ?></li>
            </ol>
        </nav>

        <h3 class='p-3'><?= $head_title ?></h3>
        <hr>    
        <div class="content">
        <div class="container-fluid">
            <div id="brand_images" style="display:none" class="col-md-12">
                <div class="card_box card-default mt-3 mb-5" >
                    <div class="card-header">
                        <h3 class="card-title">Brand Images</h3>
                    </div>
                    <div class="card-body">
                        <form action="<?= ADMIN_FRONT_SITE ?>brand_images.php" name="brand_images[]"
                            class="dropzone" id="dropzoneFrom">
                        </form>
                        <p class="mt-5"><strong>Note</strong>: If image uploaded then your Brand is Existed</p>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-primary float-right" id="submit-all">Upload</button>
                    </div>
                </div>

                <div class="card_box card-default mt-3 mb-5" id="brand_images">
                    <div class="card-header">
                        <h3 class="card-title">Uploaded Brand Images</h3>
                    </div>
                    <div class="card-body " id="preview_images_below">

                    </div>
                </div>
            </div>
            <input type="hidden" id='brand_ids' value="<?= $id ?>">
            <form action="" id="brand_data_form" method="post">
                <input type="hidden" name="brand_type" value="<?= $type ?>">
                <input type="hidden" name="brand_id" value="<?= $id ?>">
                <input type="hidden"  name="seller_account" value="<?= $seller_id ?>"> 
                <div class="card card-default mt-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="brand_name">Brand Name</label>
                                <input type="text" class="form-control" name="brand_name" value="<?= $brand_name ?>"
                                    placeholder="Enter Brand Name">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="sub_category">Status</label><br>
                                <?php
                                     
                                      if ($type == 'update') {
                                          if ($status == 1) {
                                              $active_status = 'checked';
                                              $blocked_status = '';
                                          }else{
                                              $active_status = '';
                                              $blocked_status = 'checked';
                                          }
                                      }else{
                                        $active_status = '';
                                        $blocked_status = '';
                                      }
                                  ?>
                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="checkboxPrimary1" name='brand_status'  value="1"
                                        <?= $active_status ?> required>
                                    <label for="checkboxPrimary1">Active
                                    </label>
                                </div>
                                <div class="icheck-danger d-inline ml-2">
                                    <input type="radio" id="checkboxPrimary2" name='brand_status' value="0"
                                        <?= $blocked_status ?> required>
                                    <label for="checkboxPrimary2">Block
                                    </label>
                                </div>
                            </div>

                           
                        </div>

                            <button id="submit_Brand_Form" class="btn btn-primary float-right">Next</button>
                        <!-- /.row -->
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php
}
else{
        
    ?>  
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SELLER_FRONT_SITE ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= SELLER_FRONT_SITE.'brands?action=viewBrandListing' ?>">Brands</a></li>
                <li class="breadcrumb-item active" aria-current="page">Approve Requested Brand</li>
            </ol>
        </nav>

        <div class="container-fluid">
            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row card  p-2">
                    <div class="col-sm-12">

                        <table id="example2"
                            class="table table-bordered table-striped dataTable dtr-inline" role="grid"
                            aria-describedby="example1_info">
                            <thead>
                                <tr role="row">
                                    <th width="2%">Id</th>
                                    <th width="5%">Brand Image</th>
                                    <th width="10%">Brand Name</th>
                                    <th width="20%">Requested By</th>
                                    <th width="35%">Comment</th>
                                    <th width="10%">STATUS</th>
                                    <th width="15%">Created On</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody id="category_listing_td">

                                <?php
                                    $brand_res =SqlQuery("SELECT * FROM brands WHERE sellerId_BrandOwner='".$seller_id."'");
                                    foreach($brand_res  as $key => $value) {
                                        if ($value['brand_img'] == '') {
                                            $brand_img = 'https://st3.depositphotos.com/23594922/31822/v/600/depositphotos_318221368-stock-illustration-missing-picture-page-for-website.jpg';
                                        }else{
                                            $brand_img = FRONT_SITE_IMAGE_BRAND.$value['brand_img'];
                                        }
                                       
                                        $getBrandApprovalRequest = ExecutedQuery("SELECT * FROM brand_approval_doc WHERE brand_id = '".$value['bid']."'");
                                        if ($getBrandApprovalRequest > 0) {
                                            foreach ($getBrandApprovalRequest as $approval_key => $approval_value) {
                                                $seller_account= ExecutedQuery("SELECT * FROM seller_account WHERE id = ".$approval_value['seller_id']."");
                                                $seller_account = $seller_account[0];
                                                 
                                                $seller_request_approved_explode = explode(",",$value['seller_request_approved']);
                                                $seller_request_in_process_explode = explode(",",$value['seller_request_in_process']);
                                                $seller_request_rejected_explode = explode(",",$value['seller_request_rejected']);

                                                if(in_array($approval_value['seller_id'],$seller_request_approved_explode)){
                                                    $approval_text = '<span class="text-success">Approved</span>';
                                                }
                                                else if(in_array($approval_value['seller_id'],$seller_request_in_process_explode)){
                                                    $approval_text = '<span class="text-warning">In Process</span>';
                                                }
                                                else if(in_array($approval_value['seller_id'],$seller_request_rejected_explode)){
                                                    $approval_text = '<span class="text-danger">Rejected</span>';
                                                }else{
                                                    $approval_text = '<span class="">Send for approval</span>';
                                                }

                                                ?>
                                                <tr>
                                                    <td><?= $approval_value['id'] ?></td>
                                                    <td><img class="img-reponsive img-fluid" width="80px" height="80px"
                                                            src="<?= $brand_img ?>"
                                                            alt=""></td>
                                                    <td><?= $value['brand_name'] ?></td>
                                                    <td><strong>Full Name:</strong> <?= $seller_account['seller_fullname'] ?> <br> <strong>Email: </strong> <?= $seller_account['seller_email'] ?> <br> <a href="<?= APPROVAL_BRAND_FILE.$approval_value['document_data'] ?>" target="_blank"> View Doc</a></td>
                                                    <td id="notes_from_brand_owner<?= $approval_value['id'] ?>">
                                                        <?php 
                                                            if ($approval_value['notes_from_brand_owner'] == '') {
                                                                echo '-';
                                                            }else{
                                                                echo $approval_value['notes_from_brand_owner'];
                                                            }
                                                        ?>
                                                     </td>
                                                    <td id="approval_text<?= $approval_value['id'] ?>">
                                                        <?php
                                                            echo $approval_text;
                                                        ?>
                                                    </td>
                                                    <td><?= date("M d, Y h:i:s A", strtotime($approval_value['created_on'])) ?></td>
                                                    <td>
                                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#UpdateStatusforBrandApproval<?= $approval_value['id'] ?>">
                                                            View
                                                        </a>
                                                        <div class="modal fade" id="UpdateStatusforBrandApproval<?= $approval_value['id'] ?>" style="display: none;" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Change Status</h4>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">×</span>
                                                                        </button>
                                                                    </div>
                                                                    <form action="" onsubmit="UpdateBrandApprovalStatus(event,<?= $approval_value['id'] ?>)" id="brand_approval_update_seller_site<?= $approval_value['id'] ?>">
                                                                        <input type="hidden" name="approvalBrand_id" value="<?= $approval_value['id'] ?>">
                                                                        <input type="hidden" name="brand_id" value="<?= $value['bid'] ?>">
                                                                        <input type="hidden" name="sellerReqId" value="<?= $seller_account['id'] ?>">
                                                                        <div class="modal-body">
                                                                            <div class="row">
                                                                                <div class="form-group col-md-12">
                                                                                    <label for="select_brand_status">Set Status as</label>
                                                                                    <select name="select_brand_status" class="form-control select_brand_status" style="width: 100%;">
                                                                                        <option value="" selected="selected" disabled>Select Status as</option>
                                                                                        <?php
                                                                                            $arr_visible = array("0"=>'In Process', '1' => 'Approved', '2' => 'Rejected');
                                                                                            foreach ($arr_visible as $arr_visible_key => $arr_visible_val) {
                                                                                                ?>
                                                                                            <option  value='<?= $arr_visible_key ?>'><?= $arr_visible_val ?></option>
                                                                                        <?php
                                                                                            }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>

                                                                                <div class="form-group col-md-12">
                                                                                    <label for="approval_comment">Comment</label>
                                                                                    <textarea name="approval_comment" id="approval_comment" cols="30" class="form-control" rows="3"></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer justify-content-between">
                                                                            <button type="submit" class="btn btn-primary">Update Status</button>
                                                                        </div>
                                                                    </form>
                                                                   
                                                                </div>
                                                                <!-- /.modal-content -->
                                                            </div>
                                                            <!-- /.modal-dialog -->
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                    }                 
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th>Brand Name</th>
                                    <th>by Seller Name</th>
                                    <th>by Brand Name</th>
                                    <th>by Status</th>
                                    <th></th>
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

?>
    <input type="hidden" value='<?= $sell_row['seller_fullname'] ?>' id="seller_fullname">
    
<?php
require 'includes/footer.php';

?>
<script>
        $(".select_brand_status").select2();
        Dropzone.options.dropzoneFrom = {
            autoProcessQueue: false,
            acceptedFiles: ".png,.jpg,.jpeg",
            maxFiles: 1,
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
                        list_image();
                    }
                });
            },
        }
        list_image();   
        function list_image() {
            var brand_ids = $("#brand_ids").val();
            $.ajax({
                url: "../PS_ADMIN/brand_images.php",
                method: 'post',
                data: {
                    list_image_files: "list_image_files",
                    brand_ids: brand_ids
                },
                success: function(data) {
                    $("#preview_images_below").html(data);
                }
            });
        }

        // Brand Adding to Db
        $("#brand_data_form").submit((e) => {
            e.preventDefault();
            var form_data = $("#brand_data_form").serialize();

            jQuery.ajax({
                url: '../PS_ADMIN/admin_ajax_call.php',
                type: 'post',
                data: form_data,
                success: function (result) {
                    // window.location = window.location.href;
                    if (result == 'exist') {
                        swal("Brand Exist", 'Try to add another brand', 'error');
                    } else {
                        $("#brand_data_form").hide();
                        $("#brand_images").show();
                    }
                }
            });
        });

      var seller_fullname = $("#seller_fullname").val();
        $('#example1 tfoot th:gt(0)').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" class="form-control" placeholder="Search '+title+'" />' );
        } );
        $("#example1").DataTable({
            "language": {
                "emptyTable": "No Brand Added By You"
            },
            "responsive": true,
            "autoWidth": false,
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
            initComplete: function () {
                // Apply the search
                this.api().columns('').every( function () {
                    var that = this;

                    $( 'input', this.footer() ).on( 'keyup change clear', function () {
                        if ( that.search() !== this.value ) {
                            that
                            .search( "^" + this.value, true, false, true )
                                .draw();
                        }
                    } );
                } );
            },
            buttons: [{
                extend: 'print',
                title: function(){
                    var printTitle = '<h5 class="text-center mb-3">List of brands belong to '+seller_fullname+' Seller Account</h5>';
                    return printTitle
                },
                exportOptions: {
                    stripHtml: false,
                    columns: [0,1, 2, 3,4,5,6]
                    //specify which column you want to print

                }
            },

        ]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        $('#example2 tfoot th:gt(1)').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" class="form-control" placeholder="Search '+title+'" />' );
        } );
        $("#example2").DataTable({
            "language": {
                "emptyTable": "No Brand Approval Requested"
            },
            "responsive": true,
            "autoWidth": false,
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
            initComplete: function () {
                // Apply the search
                this.api().columns('').every( function () {
                    var that = this;

                    $( 'input', this.footer() ).on( 'keyup change clear', function () {
                        if ( that.search() !== this.value ) {
                            that
                                .search($(this).val())
                                .draw();
                        }
                    } );
                } );
            },
            buttons: [{
                extend: 'print',
                title: function(){
                    var printTitle = '<h5 class="text-center mb-3">List of brands belong to '+seller_fullname+' Seller Account</h5>';
                    return printTitle
                },
                exportOptions: {
                    stripHtml: false,
                    columns: [0,1, 2, 3,4,5,6]
                    //specify which column you want to print

                }
            },

        ]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

       function UpdateBrandApprovalStatus(e,approval_id) {
        e.preventDefault();
            $.ajax({
                url: "seller_ajax_call.php",
                method: "post",
                data: $("#brand_approval_update_seller_site"+approval_id).serialize(),
                success: (res) => {
                    var data = $.parseJSON(res);

                    if(data.status == 'error') {
                        Swal.fire({
                            icon : 'error',
                            text : 'Please Select Status',
                            title : 'Error',
                        })
                    }

                    if(data.status == 'success') {
                        Swal.fire({
                            icon : 'success',
                            text : 'Brand Approval Status Updated',
                            title : 'Updated',
                        })
                        $('.modal').removeClass('show');
                        $('.modal-backdrop').removeClass('show');
                        $("body").attr("style",'');
                        $("#notes_from_brand_owner"+data.approval_Brandid).html(data.note);
                        $("#approval_text"+data.approval_Brandid).html(data.approval_status);
                    }
                }
            })
       }
</script>