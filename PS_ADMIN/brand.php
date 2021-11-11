<?php
    require 'includes/header.php';
    if (isset($_GET['operation']) && $_GET['operation'] != '') {
        $head_title = 'Add New Brand';
        $type= 'add';
        $id = '';
        $status = '';
        $brand_name = '';
        $hide_previe_image = 'display:none';

        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $id = get_safe_value($_GET['id']);
            $type= 'update';
            $hide_previe_image = '';
            $brand_res = SqlQuery("SELECT * FROM brands WHERE bid = '$id'");
            if (mysqli_num_rows($brand_res) > 0) {
                $row = mysqli_fetch_assoc($brand_res);
                $status = $row['brand_status'];
                $brand_name = $row['brand_name'];
            }else{
                redirect(ADMIN_FRONT_SITE.'category');
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
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

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

                <div class="card_box card-default mt-3 mb-5" id="brand_images" style="<?= $hide_previe_image ?>">
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
                <div class="card_box card-default mt-3">
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

                        <div class="card-footer">
                            <button id="submit_Brand_Form" class="btn btn-primary float-right">Next</button>
                        </div>
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
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Brand</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <form action="" id="delete_all_brand_checkbox_frm" method="post">
            <div class="content">
                <div class="container-fluid">
                    <div class="card_box">
                        <div class="card-header">
                            <button type="submit" class="btn btn-danger float-left" id="product_brand_btn"
                                style="display:none">Delete</button>

                            <h3 class="card-title float-right">

                                <button class="btn btn-success"><a
                                        href="<?= ADMIN_FRONT_SITE.'brand?operation=addNewBrand' ?>"
                                        style="color:#fff">Add new</a></button>
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12">

                                        <table id="example1"
                                            class="table table-bordered table-striped dataTable dtr-inline" role="grid"
                                            aria-describedby="example1_info">
                                            <thead>
                                                <tr role="row">
                                                    <th class="sorting"><input type="checkbox"
                                                            id="delete_check_brand" onclick="select_all_brand()">
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Browser: activate to sort column ascending"
                                                        style="">Id</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Browser: activate to sort column ascending"
                                                        style="">Brand Image</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending">
                                                        Brand Name</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending">
                                                        STATUS</th>


                                                </tr>
                                            </thead>
                                            <tbody id="category_listing_td">

                                                <?php
                                                   $brand_res =SqlQuery("SELECT * FROM brands");
                                                   foreach($brand_res  as $key => $value) {
                                                       if ($value['brand_status'] == 1) {
                                                           $brand_status = '<p class="text-success">Active</p>';
                                                       }else{
                                                           $brand_status = '<p class="text-danger">Blocked</p>';
                                                       }

                                                       if ($value['brand_img'] == '') {
                                                           $brand_img = 'https://st3.depositphotos.com/23594922/31822/v/600/depositphotos_318221368-stock-illustration-missing-picture-page-for-website.jpg';
                                                       }else{
                                                           $brand_img = FRONT_SITE_IMAGE_BRAND.$value['brand_img'];
                                                       }
                                                       ?>
                                                <tr>
                                                    <td class="dtr-control sorting_1" tabindex="0"><input
                                                            type="checkbox" name="checked_brand_delete[]"
                                                            onclick="get_total_selected()" id="<?= $value['bid']?>"
                                                            value="<?= $value['bid'] ?>"></td>
                                                    <td><?= $key+1 ?></td>
                                                    <td><img class="img-reponsive img-fluid" width="80px" height="80px"
                                                            src="<?= $brand_img ?>"
                                                            alt=""></td>
                                                    <td><a
                                                            href="<?= ADMIN_FRONT_SITE.'brand?operation=editBrand&id='.$value['bid'].'' ?>"><?= $value['brand_name'] ?></a>
                                                    </td>
                                                    <td><?= $brand_status ?></td>
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

        <?php
        require 'includes/footer.php';
    ?>

        <script>
        
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

                        swal({
                            title: "Brand Added Successfully!",
                            text: "",
                            type: "success",
                            timer: 3000
                            }).then(() => {
                                window.location = 'brand';
                            })
                    }
                });
            },
        }
        list_image();   
        function list_image() {
            
            var brand_ids = $("#brand_ids").val();
            
            $.ajax({
                url: "brand_images.php",
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

        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "colvis"],
                buttons: [{
                        extend: 'print',
                        exportOptions: {
                            stripHtml: false,
                            columns: [1, 2, 3]
                            //specify which column you want to print

                        }
                    }

                ]
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


        });
        </script>